<?php

namespace App\Notifier;

use App\Entity\User;
use App\Notifier\Factory\AbstractNotificationFactory;
use Symfony\Component\Notifier\NotifierInterface;

class MovierNotifier
{
    public function __construct(private readonly NotifierInterface $notifier, private readonly AbstractNotificationFactory $abstractNotificationFactory)
    {

    }

    public function notifyUser(User $user, string $message = "Le film à été ajouté") :void
    {
        $this->notifier->send($message, $user->getEmail());
    }
}