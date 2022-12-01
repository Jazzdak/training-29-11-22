<?php

namespace App\Security\Voter;

use App\Entity\Movie;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MovieVoter extends Voter
{

    public const VIEW = 'movie.view';
    public const EDIT = 'movie.edit';
    public const DELETE = 'movie.delete';

    public function __construct(private readonly AuthorizationCheckerInterface $authorizationChecker, private readonly AgeVoter $ageVoter)
    {
    }

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $subject instanceof Movie && in_array($attribute, [self::VIEW, self::EDIT]);
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if($this->authorizationChecker->isGranted('ROLE_ADMIN')){
            return true;
        }

        /**
         * @var Movie $subject
         */
        return match ($attribute) {
            self::EDIT, self::DELETE => $subject->getCreatedBy() === $token->getUser(),
            self::VIEW => $this->ageVoter->vote($token, $subject, []),
            default => false
        };
    }
}