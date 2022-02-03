<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Website;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

class MainController extends AbstractController
{
    protected bool $checkUser;

    public function checkUser(?UserInterface $user): bool
    {
        if ($user == null) {
            return true;
        }
        /** @var User $user */
        return $user->getId() === $user;
    }
}
