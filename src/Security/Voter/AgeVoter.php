<?php

namespace App\Security\Voter;

use App\Entity\Book;
use App\Entity\Movie;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AgeVoter extends Voter
{

    public const G = 'G';
    public const NR = 'Not Rated';
    public const PG = 'PG';
    public const PG13 = 'PG-13';
    public const NC17 = 'NC-17';
    public const R = 'R';
    public const VIEW = 'movie.view';
    public const EDIT = 'movie.edit';
    public const DELETE = 'movie.delete';

    public function __construct(private readonly AuthorizationCheckerInterface $authorizationChecker)
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
         * @var User $user
         */
        $user = $token->getUser();
        $age = $user->getDateBirth()?->diff(new \DateTimeImmutable())->y ?? null;
        dump($age);

        /**
         * @var Movie $subject
         */
        return match ($subject->getAge()) {
            self::R, self::NC17 => $age >= 17,
            self::PG, self::PG13 => $age >= 13,
            self::G => true,
            default => false
        };
    }
}