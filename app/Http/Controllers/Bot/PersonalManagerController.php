<?php

namespace App\Http\Controllers\Bot;

use File;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\FileUpload\InputFile;

class PersonalManagerController extends MasterCFWPBotController
{
    private const BOT = 'personal_manager';

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
    }

    /**
     * Send the newly created post to the bot
     */
    public function send_the_post_in_telegram(array $post)
    {
        $image = Storage::url($post['image']);
        
        $url = '<a href="'. route('blog.post.show', [
            'slug' => $post['url'],
        ]) .'">'. $post['read_more'] .'</a>';
        $post['channel_id'] = '@' . $post['channel_id'];
        $caption = ucfirst($post['title']) . "\n\n" . $post['excerpt'] . "\n\n $url \n" . $post['channel_id'];
        $this->chat_id = $post['channel_id'];

        $replyPayload = [
            'chat_id' => $this->chat_id,
            'photo' => $image,
            'caption' => $caption,
            'parse_mode' => 'HTML',
        ];
        
        $response = Http::post('https://komipm.komeila0013.workers.dev/sendPhoto', $replyPayload);
        // dd($response->json());
        // return $response->json();
        return Redirect::back();
    }

    /**
     * Send the new contact request in telegram
     */
    public function send_new_contact_request(array $data)
    {
        $admin = "680062551";
        $msg = '';
        foreach ($data as $key => $value) {
            $msg .= "$key: $value\n";
        }
        $new_request = "You have a new contact request\n$msg";

        $replyPayload = [
            'chat_id' => $admin,
            'text' => $new_request,
            'parse_mode' => 'HTML',
        ];
        
        $response = Http::post('https://komipm.komeila0013.workers.dev/sendMessage', $replyPayload);
    }
}
