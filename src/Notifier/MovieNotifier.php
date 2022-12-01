<?php

namespace App\Notifier;

use App\Entity\User;
use App\Notifier\Factory\AbstractNotificationFactory;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class MovieNotifier
{
    public function __construct(private readonly NotifierInterface $notifier, private readonly AbstractNotificationFactory $abstractNotificationFactory)
    {

    }

    public function notifyUser(User $user, string $message = "Le film à été ajouté") :void
    {
        $recipient = new Recipient($user->getEmail(), "+33123456789");
        $notification = $this->abstractNotificationFactory->createNotification($message, $user->getPreferredChannel());
        $this->notifier->send($notification, $recipient);
    }
}