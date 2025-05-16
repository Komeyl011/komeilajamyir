<?php

namespace App\Http\Controllers\Bot;

use App\Models\ChatbotUser;
use App\Models\ChatHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Telegram\Bot\Laravel\Facades\Telegram;

class ChatBotController extends MasterBotController
{
    const BOT = 'chatbot';

    protected $welcome_message;

    public function __construct()
    {
        $this->welcome_message = "سلام!\nبه ربات چت‌جی‌پی‌تی خوش‌اومدی.";
    }

    /**
     * Main function that handles the incoming requests
     *
     * @return void
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function index(Request $request)
    {
        // Process the update as usual.
        $update = $request->all();

        // Determine the chat ID. (Adjust based on your update type.)
        if (!empty($update['message']['chat']['id'])) {
            $this->chat_id = $update['message']['chat']['id'];
        } else {
            // If you cannot determine the chat ID, return an error.
            return response()->json(['error' => 'Chat ID not found'], 400);
        }


        // $update = Telegram::bot(self::BOT)->getWebhookUpdate();
        // $this->chat_id = $update['message']['chat']['id'];

        if (empty(trim($update['message']['text']))) {
            return $this->send_message($this->welcome_message, self::BOT);
        } else {
            $chat_type = $update['message']['chat']['type'];
            $message = $update['message'];
            if ($chat_type === 'group' || $chat_type === 'supergroup') {
                if (isset($message['entities'])) {
                    foreach ($message['entities'] as $entity) {
                        if ($entity['type'] === 'mention' && str_contains($message['text'], '@cgpt_4_o_bot')) {
                            // Handle the mention
                            return $this->handle_group_message($update);
                        } else {
                            return response()->json(['status' => 'ignored'], 200);
                        }
                    }
                } else {
                    return response()->json(['status' => 'ignored'], 200);
                }
            } else {
                return $this->handle_private_message($update);
            }
        }
    }

    protected function handle_private_message($update)
    {
        // $user = $update->getMessage()->get('from');
        $user = $update['message']['from'];

        if (!ChatbotUser::query()->where('chat_id', '=', (string)$this->chat_id)->exists()) {
            ChatbotUser::query()->create([
                'chat_id' => (string)$this->chat_id,
                'username' => $user['username'] ?? $user['first_name'],
                'is_bot' => $user['is_bot'] ?? false,
                'is_premium' => $user['is_premium'] ?? false,
            ]);
        }

        $update_message = trim($update['message']['text']);

        if (str_starts_with($update_message, '/start')) {
            return $this->send_message($this->welcome_message, self::BOT);
        } else {
            $user_requests_count = ChatbotUser::query()->where('chat_id', '=', (string)$this->chat_id)->first(['remaining_requests_count']);

            if ((int)$user_requests_count->remaining_requests_count > 0) {
                $request = $this->get_response($update_message);

                // return $this->send_message($request, self::BOT);
                if ($request->successful() && $request->json()['status'] == '200') {
                    $response = $request->json();

                    $user_requests_count = (int)$user_requests_count->remaining_requests_count - 1;
                    ChatbotUser::query()->where('chat_id', '=', (string)$this->chat_id)->update([
                        'remaining_requests_count' => $user_requests_count,
                    ]);
                    // Save the user's message to the database
                    ChatHistory::query()->create([
                        'user_id' => (string)$this->chat_id,
                        'content' => $update_message,
                        'role' => 'system',
                    ]);

                    $botResponse = $response['result']['choices'][0]['message']['content'];

                    // Save the bot's response to the database
                    ChatHistory::query()->create([
                        'user_id' => (string)$this->chat_id,
                        'content' => $botResponse,
                        'role' => 'assistant',
                    ]);

                    return $this->send_message($botResponse, self::BOT, false, 'Markdown');
                } else {
                    switch ($request['status']) {
                        case 400:
                        case 401:
                            return $this->send_message('خطای داخلی.' . ' ' . $request['status'], self::BOT);
                            break;

                        case 402:
                            return $this->send_message('خطای درخواست.', self::BOT);
                            break;

                        case 403:
                            return $this->send_message('خطای اعتبار.', self::BOT);
                            break;

                        case 404:
                            return $this->send_message('پاسخی یافت نشد.', self::BOT);
                            break;

                        case 409:
                            return $this->send_message('درخواست نامناسب.', self::BOT);
                            break;

                        case 429:
                            $this->send_message('تعداد درخواست‌های زیاد در لحظه.', self::BOT);
                            break;

                        case 500:
                        case 502:
                        case 503:
                        case 504:
                            return $this->send_message('ارتباط برقرار نشد.', self::BOT);
                            break;
                    }
                }
            } else {
                return $this->send_message('تمام درخواست‌ها استفاده شده.', self::BOT);
            }
        }
    }

    protected function handle_group_message($update)
    {
        $update_message = trim($update['message']['text']);

        if (str_starts_with($update_message, '/start')) {
            return $this->send_message($this->welcome_message, self::BOT);
        } else {
            $request = $this->get_response($update_message);

            if ($request->successful() && $request->json()['status'] == '200') {
                $response = $request->json();

                $botResponse = $response['result']['choices'][0]['message']['content'];

                return $this->send_message($botResponse, self::BOT, false, 'Markdown');
            } else {
                switch ($request['status']) {
                    case 400:
                    case 401:
                        return $this->send_message('خطای داخلی.' . ' ' . $request['status'], self::BOT);
                        break;

                    case 402:
                        return $this->send_message('خطای درخواست.', self::BOT);
                        break;

                    case 403:
                        return $this->send_message('خطای اعتبار.', self::BOT);
                        break;

                    case 404:
                        return $this->send_message('پاسخی یافت نشد.', self::BOT);
                        break;

                    case 409:
                        return $this->send_message('درخواست نامناسب.', self::BOT);
                        break;

                    case 429:
                        return $this->send_message('تعداد درخواست‌های زیاد در لحظه.', self::BOT);
                        break;

                    case 500:
                    case 502:
                    case 503:
                    case 504:
                        return $this->send_message('ارتباط برقرار نشد.', self::BOT);
                        break;
                }
            }
        }
    }

    private function get_response($update_message)
    {
        $history = ChatHistory::query()->where('user_id', '=', (string)$this->chat_id)
                ->orderBy('created_at')
                ->get();

        $reqBody = [
            'model' => 'gpt-4',
            'messages' => [],
            'temperature' => 1,
            'max_tokens' => 500,
        ];

        // Map the history messages and store them in the 'messages' array
        $reqBody['messages'] = $history->map(function ($msg) {
            return [
                'role' => strtolower($msg->role),
                'content' => $msg->content,
            ];
        })->toArray(); // Ensure it's converted to an array

        // Add the system message at the end
        $reqBody['messages'][] = [
            'role' => 'system',
            'content' => $update_message,
        ];

        // return $reqBody;

        $url = 'https://api.one-api.ir/openai/v1/chat/completions';
        $headers = [
            'accept' => 'application/json',
            'one-api-token' => '373786:657b0a18cafaf',
            'Content-Type' => 'application/json',
        ];
        $request = Http::withHeaders($headers)->post($url, $reqBody);

        return $request;
    }
}
