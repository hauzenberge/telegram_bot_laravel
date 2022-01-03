<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GamePenis extends Model
{
    protected $table = 'game_penis';

    protected $fillable = ['id', 'telegram_user_id', 'length', 'created_at', 'updated_at' ];

    public static function getPenis($telegram_user_id, $length)
    {
        //dd($length);
        $penis = GamePenis::where('telegram_user_id', $telegram_user_id)->first();
        if ($penis == null) {
            $return = GamePenis::create([
                'telegram_user_id' => $telegram_user_id, 
                'length' => $length
            ]);
            return $return->length;
        }else{
            $penis->length += $length;
            $penis->save();
            return $penis->length;
        }
    }
}
