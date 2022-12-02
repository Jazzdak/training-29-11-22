<?php

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\SecurityEvents;

class UserLoginSubscriber implements EventSubscriberInterface
{

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function onLoginSuccess(TokenInterface $token)
    {
        /**
         * @var User $user
         */
        $user = $token->getUser();
        $user->setLastConnectedAt(new DateTimeImmutable());

        $this->userRepository->save($user);
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => ['onLoginSuccess']
        ];
    }
}