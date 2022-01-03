<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Collection;

use App\Helpers\TelegramBase;

class TelegramALLReactionsHelper
{
    public static function switcReaction($messege)
    {
       // dd($messege->chat->id);
       $return = "Send ";
        if (isset($messege->sticker)) {
            //dd($messege->chat->type);
            $sticker = TelegramBase::SendSticker($messege->chat->id, $messege->sticker->file_id);
           // dd($sticker["result"]);
            $return .="sticker sticker id: ". $messege->sticker->file_id." from type chat: ".$messege->chat->type;
        }
        return $return;
    }
}