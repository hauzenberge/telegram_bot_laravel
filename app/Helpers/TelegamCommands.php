<?php

namespace App\Helpers;

use GuzzleHttp\Client;

use App\Helpers\TelegramBase;

use App\GamePenis;

class TelegamCommands
{
    public static function GamePenis($nick_name, $chat_id, $telegram_user_id)
    {
        $text = "@" . $nick_name . "<em> твій пісюн ";
        $length = rand(1, 20);
        $data_lenth = null;
        $switch = rand(1, 2);
        switch ($switch) {
            case 1: {
                    $data_lenth += $length;
                    $text .= "виріс на " . $length . " см, \xF0\x9F\x98\xB0";
                    break;
                }
            case 2: {
                    $data_lenth -= $length;
                    $text .= "зменшився на " . $length . " см, \xF0\x9F\x98\x81";
                    break;
                }
            default:
                # code...
                break;
        }
        $text .= " Довжина твого пісюна: " . GamePenis::getPenis($telegram_user_id, $data_lenth) . " cм</em>";
        $status =  TelegramBase::SendMessege($chat_id, $text);
        return $status;
    }

    public static function switchCommand($messege, $chat_id, $nick_name, $telegram_user_id)
    {
        $status = false;
        switch ($messege) {
            case "/start": {
                    $text = "Привiт, я Віка, чим можу допомогти?";
                    $status =  TelegramBase::SendMessege($chat_id, $text);
                    break;
                }
            case "/game_penis": {
                    $status = TelegamCommands::GamePenis($nick_name, $chat_id, $telegram_user_id);
                    break;
                }
            default:
                $status =  TelegramBase::SendMessege($chat_id, '@'.$nick_name.' шо ты несёшь?))');
                break;
        }
        return $status;
    }
}
