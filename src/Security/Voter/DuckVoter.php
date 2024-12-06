<?php

namespace App\Security\Voter;

use App\Entity\Ducks;
use App\Entity\Quack;
use App\Entity\UserSecurity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class DuckVoter extends Voter
{
    public const EDIT = 'QUACK_EDIT';
    public const VIEW = 'QUACK_VIEW';
    public const DELETE = 'QUACK_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof Quack;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserSecurity) {
            return false;
        }

        if (!$subject instanceof Quack) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($subject, $user);
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::DELETE:
                return $this->canDelete($subject, $user);
        }

        return false;
    }

    private function canView(Quack $quack, UserSecurity $user): bool
    {
        // Tout le monde peut voir un quack
        return true;
    }

    private function canEdit(Quack $quack, UserSecurity $user): bool
    {
        // L'utilisateur peut éditer le quack s'il en est le propriétaire
        return $user === $quack->getAuthor();
    }

    private function canDelete(Quack $quack, UserSecurity $user): bool
    {
        // L'utilisateur peut supprimer le quack s'il en est le propriétaire
        return $user === $quack->getAuthor();
    }
}