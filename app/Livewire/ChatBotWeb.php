<?php

namespace App\Livewire;

use App\Models\ChatHistory;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ChatBotWeb extends Component
{
    public string $message = '';
    public array $chatHistory = [];
    public bool $isBotTyping = false;

    public function sendMessage()
    {
        if (trim($this->message) === '') {
            return;
        }

        // Add user's message
        $this->chatHistory[] = ['sender' => 'You', 'message' => $this->message];

        // Simulate bot response (replace this with your actual backend logic)
        $botResponse = $this->generateBotResponse($this->message);
//        $this->chatHistory[] = ['sender' => 'Bot', 'message' => $botResponse];

        // Clear the input field
        $this->message = '';
        $this->isBotTyping = true;

        // Trigger bot response after delay
        $this->dispatch('bot-typing');
        sleep(5);
        $this->botResponse();
    }

    public function botResponse()
    {
        $botResponse = "This is a thoughtful response.";
        $this->chatHistory[] = ['sender' => 'Bot', 'message' => $botResponse];
        $this->isBotTyping = false;
    }

    private function generateBotResponse($userMessage)
    {
        $history = ChatHistory::query()->where('user_id', '=', '680062551')
            ->orderBy('created_at')
            ->get();

        if ($history->count() > 0) {
            $formattedMessages = $history->map(function($msg) {
                return [
                    'role' => strtolower($msg->role),
                    'content' => $msg->content,
                ];
            });

            $formattedMessages->push([
                'role' => 'user',
                'content' => $userMessage,
            ]);
        } else {
            $formattedMessages = [
                [
                    'role' => 'user',
                    'content' => $userMessage,
                ]
            ];
        }

        $url = 'https://api.one-api.ir/chatbot/v1/gpt4o/';
        $headers = [
            'accept' => 'application/json',
            'one-api-token' => '373786:657b0a18cafaf',
            'Content-Type' => 'application/json',
        ];
        $request = Http::withHeaders($headers)->post($url, $formattedMessages);

        if ($request->successful() && $request->json()['status'] == '200') {
            $response = $request->json();

//            $user_requests_count = (int)$user_requests_count->remaining_requests_count - 1;
//            ChatbotUser::query()->where('chat_id', '=', (string)$this->chat_id)->update([
//                'remaining_requests_count' => $user_requests_count,
//            ]);
            // Save the user's message to the database
            ChatHistory::query()->create([
                'user_id' => '680062551',
                'content' => $userMessage,
                'role' => 'user',
            ]);

            $botResponse = $response['result'][0];

            $response = $botResponse;

            // Save the bot's response to the database
            ChatHistory::query()->create([
                'user_id' => '680062551',
                'content' => $botResponse,
                'role' => 'assistant',
            ]);
        } else {
            switch ($request['status']) {
                case 400:
                case 401:
                    $response = 'خطای داخلی.';
                    break;

                case 402:
                    $response = 'خطای درخواست.';
                    break;

                case 403:
                    $response = 'خطای اعتبار.';
                    break;

                case 404:
                    $response = 'پاسخی یافت نشد.';
                    break;

                case 409:
                    $response = 'درخواست نامناسب.';
                    break;

                case 429:
                    $response = 'تعداد درخواست‌های زیاد در لحظه.';
                    break;

                case 500:
                case 502:
                case 503:
                case 504:
                    $response = 'ارتباط برقرار نشد.';
                    break;
            }
        }
        return $response;
    }

    #[Layout('components.layouts.chatbot')]
    public function render()
    {
        return view('chat-bot-web');
    }
}
