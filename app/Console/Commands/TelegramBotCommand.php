<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Helpers\TelegramBase;
use App\Helpers\TelegamCommands;
use App\Helpers\TelegramALLReactionsHelper;

class TelegramBotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Start');
        $start = TelegramBase::getUpdates();
       // TelegramBase::getApiChat();
        // dd($start); 
        do {
            $body = TelegramBase::getUpdates();
            $results = TelegramBase::getHooks($start, $body);
            //dd($results->count());
            if (($results->count() != null) or ($results->count() != 0)) {
                // dd($results);
                foreach ($results as $result) {
                    //dd($result);                    
                    if (isset($result->message)) {
                        $message = $result->message;
                        if (isset($message->text)) {
                            $text = $message->text;
                            // dd($text);
                            $info = TelegamCommands::switchCommand($text, $message->chat->id, $message->from->username, $message->from->id);
                            $this->info('Send massege from @' . $result->message->from->username . ' Text: ' . $info["result"]["text"]);
                            $start = $start->push($result);
                        } else {
                           // dd($result);
                           $this->info(TelegramALLReactionsHelper::switcReaction($message));
                           $start = $start->push($result);
                        }
                        sleep(1);                        
                    }
                    sleep(1);
                }
            }
            sleep(1);
        } while (true);


        return 0;
    }
}
