<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\SlackNotification;

class SlackNotificationFactory implements NotificationFactoryInterface, IterableFactoryInterface
{

    public function createNotification(string $message): SlackNotification
    {
        return new SlackNotification($message, ['chat/slack']);
    }

    public static function getDefaultIndexName(): string
    {
        return "slack";
    }
}