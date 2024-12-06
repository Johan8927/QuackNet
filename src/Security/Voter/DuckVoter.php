<?php

namespace App\Security\Voter;

use App\Entity\Ducks;
use App\Entity\Quack;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class DuckVoter extends Voter
{
    public const EDIT = 'DUCK_EDIT';
    public const VIEW = 'DUCK_VIEW';
    public const DELETE = 'DUCK_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof Ducks;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (!$subject instanceof Ducks) {
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

    private function canView(Ducks $duck, UserInterface $user): bool
    {
        // Add logic for viewing a duck
        return true; // For now, allow anyone to view
    }

    private function canEdit(Ducks $duck, UserInterface $user): bool
    {
        // Check if the user is the owner of the duck
        return $user === $duck->getOwner();
    }

    private function canDelete(Ducks $duck, UserInterface $user): bool
    {
        // For now, use the same logic as editing
        return $this->canEdit($duck, $user);
    }
}