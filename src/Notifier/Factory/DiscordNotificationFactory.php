<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\DiscordNotification;

class DiscordNotificationFactory implements NotificationFactoryInterface, IterableFactoryInterface
{

    public function createNotification(string $message): DiscordNotification
    {
        return new DiscordNotification($message, ['chat/discord']);
    }

    public static function getDefaultIndexName(): string
    {
        return "discord";
    }
}