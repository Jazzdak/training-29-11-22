<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\DiscordNotification;
use App\Notifier\Notification\SlackNotification;
use Symfony\Component\Notifier\Notification\Notification;

class AbstractNotificationFactory implements NotificationFactoryInterface
{

    /**
     * @var IterableFactoryInterface[]
     */
    private iterable $factories;

    public function __construct(#[TaggedIterator('app.notification_factory')] iterable $factories)
    {
        $this->factories = $factories instanceof \Traversable ? iterator_to_array($factories) : $factories;
    }

    public function createNotification(string $message, string $channel = 'email'): Notification
    {
        return $this->factories[$channel]->createNotification($message);
    }
}