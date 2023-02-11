<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Exceptions\TelegramBotApiExceptions;
use Illuminate\Support\Facades\Http;
use Throwable;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $response = Http::get(self::HOST.$token.'/sendMessage', [
                'chat_id' => $chatId,
                'text'    => $text
            ])->throw()->json();

            return $response['ok'] ?? false;
        } catch (Throwable $exception) {
            report(new TelegramBotApiExceptions($exception->getMessage()));

            return false;
        }
    }

}
