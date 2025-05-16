<?php

namespace App\Http\Controllers\Bot;

use App\Models\TelegramBotLinks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class LinksBotController extends MasterBotController
{
    const BOT = 'linksgen';

    private $admFile = "public/telBot/links_gen_bot/ADM.txt";
    private $fdmFile = "public/telBot/links_gen_bot/FDM.txt";
    private $url_pattern;
    protected $home_reply_markup;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $this->url_pattern = "/(?i)\b((?:https?:(?:\/{1,3}|[a-z0-9%])|[a-z0-9.\-]+[.](?:com|net|org|edu|gov|mil|aero|asia|biz|cat|coop|info|int|jobs|mobi|museum|name|post|pro|tel|travel|xxx|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cx|cy|cz|dd|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|Ja|sk|sl|sm|sn|so|sr|ss|st|su|sv|sx|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)\/)(?:[^\s()<>{}\[\]]+|\([^\s()]*?\([^\s()]+\)[^\s()]*?\)|\([^\s]+?\))+(?:\([^\s()]*?\([^\s()]+\)[^\s()]*?\)|\([^\s]+?\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’])|(?:(?<!@)[a-z0-9]+(?:[.\-][a-z0-9]+)*[.](?:com|net|org|edu|gov|mil|aero|asia|biz|cat|coop|info|int|jobs|mobi|museum|name|post|pro|tel|travel|xxx|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cx|cy|cz|dd|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|Ja|sk|sl|sm|sn|so|sr|ss|st|su|sv|sx|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)\b\/?(?!@)))/";
        // $updates = Telegram::getWebhookUpdate();
        $updates = Telegram::bot('linksgen')->getWebhookUpdate();

        if (!empty($update_msg = trim($updates['message']['text']))) {
            $this->chat_id = $updates['message']['chat']['id'];
            $user = $updates->getMessage()->get('from');
            $this->username = $user['username'] ?? $user['first_name'];

            if (TelegramBotLinks::query()->where('chat_id', '=', (string)$this->chat_id)->exists()) {
                $user_db_data = TelegramBotLinks::query()->where('chat_id', '=', (string)$this->chat_id)->first();
                if ($user_db_data->username != $this->username) {
                    $path = "public/telBot/links_gen_bot/$user_db_data->username";
                    if (Storage::exists($path)) {
                        Storage::move($path, "public/telBot/links_gen_bot/$this->username");
                    }

                    TelegramBotLinks::query()->where('chat_id', '=', (string)$this->chat_id)->update([
                        'username' => $this->username,
                        'is_premium' => $user['is_premium'] ?? false,
                    ]);
                }
            } else {
                TelegramBotLinks::query()->insert([
                    'chat_id' => (string)$this->chat_id,
                    'username' => $this->username,
                    'is_bot' => $user['is_bot'],
                    'is_premium' => $user['is_premium'] ?? false,
                    'is_bot_vip' => false,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $user_db_data = TelegramBotLinks::query()->where('chat_id', '=', (string)$this->chat_id)->first();
            }

            $channels = ['PixelPals' => 'pixelpalscomics'];
            $is_member = true;
            foreach ($channels as $channel) {
                $response = Telegram::bot(self::BOT)->getChatMember([
                    'chat_id' => '@' . $channel,
                    'user_id' => $updates['message']['chat']['id'],
                ]);
                Log::info('getChatMember response: ' . $response . PHP_EOL);


                $status = $response['status'];
                if (in_array($status, ['left', 'kicked'])) {
                    $is_member = false;
                    break;
                }
            }

            if ($is_member) {
                switch (true) {
                    case ($update_msg === '/start' || $update_msg === 'خانه🏠'):
                        $msg = 'سلام!
لینک قسمت اول سریال موردنظرت یا پارت اول لینک موردنظرت رو به همراه تعداد قسمت‌ها رو با فرمت زیر بفرست
                  --------------------------------------------------------------------------
https://download.test/episode01, 10';
                        $this->home_reply_markup = Keyboard::make()
                            ->setResizeKeyboard(true)
                            ->setOneTimeKeyboard(true)
                            ->row([Keyboard::button('آموزش📚 '),])
                            ->row([Keyboard::button('⏳ تاریخچه'), Keyboard::button('🛠️ پشتیبانی'),])
                            ->row([Keyboard::button('خانه🏠'),]);

                        $this->send_message($msg, self::BOT, $this->home_reply_markup);
                        break;

                    case ($update_msg == 'آموزش📚'):
                        $msg = 'آموزش مورد نظر را انتخاب کنید.';
                        $reply_markup = Keyboard::make()
                            ->setResizeKeyboard(true)
                            ->setOneTimeKeyboard(true)
                            ->row([Keyboard::button('ADM')])
                            ->row([Keyboard::button('FDM')])
                            ->row([Keyboard::button('خانه🏠'),]);

                        $this->send_message($msg, self::BOT, $reply_markup);
                        break;

                    case ($update_msg == 'ADM'):
                        $video = 'app/public/telBot/links_gen_bot/tutorial/tutorial_adm.mp4';
                        $this->send_video($video, 'آموزش نرم‌افزار ADM', self::BOT, 'tutorial_adm.mp4');
                        break;

                    case ($update_msg == 'FDM'):
                        $video = 'app/public/telBot/links_gen_bot/tutorial/tutorial_fdm.mp4';
                        $this->send_video($video, 'آموزش نرم‌افزار FDM', self::BOT, 'tutorial_fdm.mp4');
                        break;

                    case ($update_msg == '🛠️ پشتیبانی'):
                        $msg = 'ارتباط با سازنده: @komeil_aj';
                        $this->send_message($msg, self::BOT, $this->home_reply_markup);
                        break;

                    case ($update_msg == '⏳ تاریخچه'):
                        $this->show_history();
                        break;

                    case str_starts_with($update_msg, '/history'):
                        $username = $user_db_data->username;
                        $file_name = substr($update_msg, 9);

                        $adm_file = "$username/$file_name/ADM.txt";
                        $fdm_file = "$username/$file_name/FDM.txt";

                        $caption_adm = 'فایل مناسب نرم‌افزار ADM
                        <a href="'. route('file.download', ['uri' => $adm_file]) .'" download>دانلود</a>';
                        $this->send_document('public/telBot/links_gen_bot/' . $adm_file, self::BOT, $caption_adm, 'ADM.txt');

                        $caption_fdm = 'فایل مناسب نرم‌افزار FDM
                        <a href="'. route('file.download', ['uri' => $fdm_file]) .'" download>دانلود</a>';
                        $this->send_document('public/telBot/links_gen_bot/' . $fdm_file, self::BOT, $caption_fdm, 'ADM.txt');
                        break;

                    case is_string($message = $this->check_params($update_msg)):
                        $this->send_message($message, self::BOT);
                        break;

                    default:
                        $params = $this->check_params($update_msg);
                        if (!is_null($name_and_link = $this->separateLink(trim($params[0])))) {
                            $links = $this->create_links(trim($params[0]), trim($params[1]));
                            if ($files = $this->make_files($links, $this->username, $name_and_link['name'])) {
                                $caption_adm = 'فایل مناسب نرم‌افزار ADM
                                <a href="'. route('file.download', ['uri' => $files['adm']]) .'" download>دانلود</a>';
                                $this->send_document($files['adm'], self::BOT, $caption_adm, 'ADM.txt');

                                $caption_fdm = 'فایل مناسب نرم‌افزار FDM
                                <a href="'. route('file.download', ['uri' => $files['fdm']]) .'" download>دانلود</a>';
                                $this->send_document($files['fdm'], self::BOT, $caption_fdm, 'FDM.txt');
                            } else {
                                $this->send_message('اشکالی رخ داد.', self::BOT);
                            }
                        }
                }
            } else {
                $buttons = [];
                foreach ($channels as $channel => $channel_id) {
                    $buttons[] = new InlineKeyboardButton([
                        'text' => $channel,
                        'url' => 'https://t.me/' . $channel_id,
                    ]);
                }
                $keyboard = new InlineKeyboard($buttons);
                $this->send_message('لطفا اول در کانال‌های زیر عضو شوید. پس از عضویت به ربات برگشته و /start را ارسال کنید.', self::BOT, $keyboard);
            }
        }
    }

    /**
     * Check the parameters of given data
     *
     * @param string $message The message that user sent, containing the parameters
     * @returns array | string Returns an array of data or a string containing the check error message
     *
     */
    protected function check_params(string $message) : array | string
    {
        // Get All the parameters that are seperated by a comma
        $params = str_contains($message, ',') ? explode(',', $message) : null;
        if (is_array($params)) {
            // Remove any space from parameters starts and ends
            if (empty(trim($params[0])) || empty(trim($params[1]))) {
                return 'تمامی پارامترها وارد نشده‌اند.';
            }
            // Check if the first parameter which is the download link is a valid url or not
            elseif (preg_match($this->url_pattern, trim($params[0])) === 0) {
                return 'پارامتر اول باید یک لینک معتبر باشد!';
            }
            // Check if the second parameter is a number or not
            elseif (!is_int((int)trim($params[1]))) {
                return 'پارامتر دوم باید تعداد قسمت‌ها/پارت‌ها به عدد(لاتین) باشد.';
            }
            else {
                return $params;
            }
        } else {
            return 'لطفا لینک موردنظر را به همراه تعداد قسمت‌ها / پارت‌ها ارسال کنید و با , از هم جدا کنید.';
        }
    }

    /**
     * Separate episode name from link and get the name
     */
    #[ArrayShape(['name' => "false|string", 'link' => "string"])]
    protected function separateLink(string $full_link) : array
    {
        //Separate link by forward slash
        $linkArray = explode('/', $full_link);
        //Get episode name (since it's the last argument in mostly all cases)
        $name = end($linkArray);
        //Get link without episode name
        array_pop($linkArray);
        $link = implode('/', $linkArray);

        return [
            'name' => $name,
            'link' => $link,
        ];
    }

    /**
     * Create links and return them
     *
     * @param string $link
     * @param int $count The number of the parts or episodes of the file or series
     *
     * @return array
     */
    protected function create_links(string $link, int $count) : array
    {
        $storeLinks = [];

        // Pattern to match the number part
        $pattern = '/(E|%20|part)(\d+)/';

        // Extract the prefix and number part from the URL
        if (preg_match($pattern, $link, $matches)) {
            $prefix = $matches[1] ?? '';
            $number = $matches[2] ?? 0;
            // Generate URLs with replaced numbers
            for ($i = $number; $i <= $count; $i++) {
                // Format the number with leading zeros if needed
                $formattedNumber = str_pad($i, strlen($number), '0', STR_PAD_LEFT);

                // Handle prefix encoding
                $newPrefix = ($prefix === '%20') ? '%20' : $prefix;

                // Create a new URL by replacing the old number with the new formatted number
                $newUrl = preg_replace($pattern, $newPrefix . $formattedNumber, $link);

                // Add to URLs array
                $storeLinks[] = $newUrl;
            }
        }

        return $storeLinks;
    }

    /**
     * Create files for the ADM and FDM apps and store them
     *
     * @param array $links The array of created links to put them inside the file
     * @param string $username The string containing the current user's username
     * @param string|null $file_name String Containing the filename from the uri
     *
     * @return mixed
     */
    protected function make_files(array $links, string $username, string $file_name = null) : mixed
    {
        $result = false;

        // Fetch the user's username from the Telegram bot table
        $user = TelegramBotLinks::query()->where('username', '=', $username);
        if (!$user->exists()) {
            Log::error("User with username $username not found.");
            return false;
        }

        $username = $user->get()->first()->username; // Assuming 'username' is the column name in the TelegramBot table

        // Define the directory path for the user
        $userDirectory = "public/telBot/links_gen_bot/$username/$file_name";

        // Create the user's directory if it does not exist
        if (!Storage::exists($userDirectory)) {
            Storage::makeDirectory($userDirectory);
        }

        // Define the paths for the ADM.txt and FDM.txt files
        $admFilePath = "$userDirectory/ADM.txt";
        $fdmFilePath = "$userDirectory/FDM.txt";

        // Convert links array to a newline-separated string
        $linksContent = implode("\n", $links);

        // Check if the ADM.txt and FDM.txt files exist, then write the content to these files
        if (Storage::exists($admFilePath) && Storage::exists($fdmFilePath)) {
            $result = Storage::put($admFilePath, $linksContent) && Storage::put($fdmFilePath, $linksContent);
        } else {
            // Create and write the files if they don't exist
            $copy = Storage::copy($this->admFile, $admFilePath) && Storage::copy($this->fdmFile, $fdmFilePath);
            $result = $copy && Storage::put($admFilePath, $linksContent) && Storage::put($fdmFilePath, $linksContent);
        }

        return $result
            ? ['adm' => $admFilePath, 'fdm' => $fdmFilePath]
            : false;
    }

    private function show_history()
    {
        $msg = 'تاریخچه فایل‌های شما:';
        // Your array of items
        $items = Storage::exists("public/telBot/links_gen_bot/$this->username") ? Storage::directories("public/telBot/links_gen_bot/$this->username") : '';

        if (!empty($items)) {
            // Initialize the keyboard
            $keyboard = Keyboard::make()
                ->setResizeKeyboard(true)
                ->setOneTimeKeyboard(true);

            // Iterate through the array and create rows
            $rows = [];
            foreach ($items as $item) {
                $item = explode('/', $item);
                $rows[] = [Keyboard::button('/history ' . end($item))];
            }

            // Add rows to the keyboard
            foreach ($rows as $row) {
                $keyboard->row($row);
            }
            $keyboard->row([
                Keyboard::button('خانه🏠'),
            ]);

            $this->send_message($msg, self::BOT, $keyboard);
        } else {
            $this->send_message('شما هیچ فایلی ندارید.', self::BOT, $this->home_reply_markup);
        }
    }
}
