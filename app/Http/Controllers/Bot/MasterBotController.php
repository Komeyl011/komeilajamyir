<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use App\Models\BotsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class MasterBotController extends Controller
{
    protected $chat_id;
    protected string|null $username = null;

    /**
     * Send message to the chat
     *
     * @param int $chat_id The id for the chat to send message to
     * @param string $message The message to be sent to the user
     * @return void
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function send_message(string $message, string $bot, $markup = false, string $parse_mode = 'HTML')
    {
        $markup
            ? Telegram::bot($bot)->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => $message,
                'reply_markup' => $markup,
            ])
            : Telegram::bot($bot)->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => $message,
                'parse_mode' => $parse_mode,
            ]);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Send File to the chat
     *
     * @param string|array $documents The path to the document/documents, for multiple documents please provide the documents
     * file_name and path in this format: [['name' => 'file name', 'caption' => 'file caption', 'path' => 'file path'], ['name' => 'file name 2', 'caption' => 'file caption 2', 'path' => 'path to file 2']].
     * The path should be a storage path.
     * @param string|null $caption The caption of the document, for multiple documents this field should be empty
     * @param string $bot The name of the bot to send the message to
     * @param string|null $file_name The display name used for the file, for multiple documents this field should be empty
     *
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function send_document(string|array $documents, string $bot, string|null $caption, string|null $file_name = null)
    {
        if (is_array($documents)) {
            foreach ($documents as $document) {
                $file = InputFile::create(storage_path($document['path']), $document['name']);
                Telegram::bot($bot)->sendDocument([
                    'chat_id' => $this->chat_id,
                    'document' => $file,
                    'caption' => $document['caption'],
                    'parse_mode' => 'HTML',
                ]);
            }
        } else {

            if (is_null($file_name)) {
                $file_name = File::name($documents);
            }

            $file = InputFile::create(storage_path('/app/'.$documents), $file_name);

            Telegram::bot($bot)->sendDocument([
                'chat_id' => $this->chat_id,
                'document' => $file,
                'caption' => $caption,
                'parse_mode' => 'HTML',
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Send Image to the chat
     *
     * @param string|array $images The path to the document/documents, for multiple documents please provide the documents
     * file_name and path in this format: [['name' => 'file name', 'caption' => 'file caption', 'path' => 'file path'], ['name' => 'file name 2', 'caption' => 'file caption 2', 'path' => 'path to file 2']].
     * The path should be a storage path.
     * @param string|null $caption The caption of the document, for multiple documents this field should be empty
     * @param string $bot The name of the bot to send the message to
     * @param string|null $file_name The display name used for the file, for multiple documents this field should be empty
     *
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function send_photo(string|array $images, string $bot, string|null $caption, string|null $file_name = null)
    {
        if (is_array($images)) {
            foreach ($images as $document) {
                $file = InputFile::create(storage_path($document['path']), $document['name']);
                Telegram::bot($bot)->sendPhoto([
                    'chat_id' => $this->chat_id,
                    'photo' => $file,
                    'caption' => $document['caption'],
                    'parse_mode' => 'HTML',
                ]);
            }
        } else {

            if (is_null($file_name)) {
                $file_name = File::name($images);
            }

            $file = InputFile::create(storage_path('/app/'.$images), $file_name);

            Telegram::bot($bot)->sendPhoto([
                'chat_id' => $this->chat_id,
                'photo' => $file,
                'caption' => $caption,
                'parse_mode' => 'HTML',
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Send video to the chat
     *
     * @param mixed $video path to the video
     * @param string $caption caption for the video
     * @param string $bot name of the bot to send the video to
     * @param string|null $file_name name for the video file
     *
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function send_video(mixed $video, string $caption, string $bot, string|null $file_name = null)
    {
        // if (str_starts_with($video, 'public/')) {
        //     $video = str_replace('public/', '', $video);
        // }

        if (is_null($file_name)) {
            $file_name = File::name($video);
        }

        $video_file = InputFile::create(storage_path($video), $file_name);

        Telegram::bot($bot)->sendVideo([
            'chat_id' => $this->chat_id,
            'video' => $video_file,
            'caption' => $caption,
            'parse_mode' => 'HTML',
        ]);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Show the view for sending Bulk message to all the users
     *
     */
    public function show_send_bulk_message_view($token)
    {
        if ($user = auth()->guard()->user()) {
            $role = Role::query()->find($user->role_id);
            if ($role->exists()) {
                if ($role->name != 'admin') {
                    return 'not allowed!';
                }
            } else {
                return 'invalid user';
            }
        } else {
            return 'you\'re not logged in.';
        }

        return view('bot/bulk_message', [
            'token' => $token,
        ]);
    }

    /**
     * Send bulk message to all the users
     *
     */
    public function send_bulk_message(Request $request, $token)
    {
        if ($user = auth()->guard()->user()) {
            $role = Role::query()->find($user->role_id);
            if ($role->exists()) {
                if ($role->name != 'admin') {
                    return 'not allowed!';
                }
            } else {
                return 'invalid user';
            }
        } else {
            return 'you\'re not logged in.';
        }
        $bot_table = BotsTable::query()->where('bot_name', '=', $token)->first();
        $bot_users = DB::table($bot_table->table_name)->get(['chat_id']);
        foreach ($bot_users as $bot_user) {
            $this->chat_id = $bot_user->chat_id;
            $this->send_message($request->get('message'), $token);
        }

        return Redirect::back()->with('result', 'success');
    }
}
