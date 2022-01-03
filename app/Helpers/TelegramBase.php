<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Collection;

class TelegramBase
{
    public static function getApiBase()
    {
        $apiURL = 'https://api.telegram.org/bot' . env('TELEGRAM_TOKEN') . '/';
        return new Client(array('base_uri' => $apiURL));
    }

    public static function getApiChat()
    {
        $apiURL = 'https://boredhumans.com/';
        $client =  new Client(array('base_uri' => $apiURL));
        $response = $client->post('process_chat.php', array('question' => 'text' ));
        dd($response->getBody());
        return collect(json_decode($response->getBody(), true));
    }

    public static function getUpdates()
    {
        $client =  TelegramBase::getApiBase();


        try {
            $response = $client->get('getUpdates', [
                'headers' => ['User-Agent' => null]
            ]);
            return collect(json_decode($response->getBody())->result);
        } catch (GuzzleHttp\Exception\ClientException $e) {
            //  $response = $e->getResponse();
            // $responseBodyAsString = $response->getBody()->getContents();
            sleep(10);
            $response = $client->get('getUpdates', [
                'headers' => ['User-Agent' => null]
            ]);
            return collect(json_decode($response->getBody())->result);
        }
    }

    public static function getHooks($start, $updates)
    {
        $return = collect();
        foreach ($updates as $update) {
            if (($start->where("update_id", $update->update_id)->count() == null) or ($start->where("update_id", $update->update_id)->count() == 0)) {
                $return = $return->push($update);
            }
        }
        return $return->unique();
    }


    public static function SendMessege($chat_id, $text)
    {
        $client =  TelegramBase::getApiBase();
        $response = $client->post('sendMessage', array('query' => array('chat_id' => $chat_id, 'text' => $text, 'parse_mode' => 'html')));
        return collect(json_decode($response->getBody(), true));
    }

    public static function SendSticker($chat_id, $sticker)
    {
        $client =  TelegramBase::getApiBase();
        $response = $client->post('sendSticker', array('query' => array('chat_id' => $chat_id, 'sticker' => $sticker)));
        return collect(json_decode($response->getBody(), true));
    }
}
