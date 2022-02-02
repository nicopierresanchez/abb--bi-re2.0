<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    const USERS = [
        [
            'user1@monsite.com',
            'daniel',
            'name',
            ['ROLE_USER'],
            123,
        ],
        [
            'user2@monsite.com',
            'charly',
            'name',
            ['ROLE_USER'],
            123,
        ], [
            'user3@monsite.com',
            'loic',
            'name',
            ['ROLE_USER'],
            123,
        ], [
            'user4@monsite.com',
            'julien',
            'name',
            ['ROLE_USER'],
            123,
        ], [
            'user5@monsite.comt',
            'gaetan',
            'name',
            ['ROLE_USER'],
            123,
        ], [
            'user5@monsite.com',
            'antonia',
            'name',
            ['ROLE_USER'],
            123,
        ], [
            'user6@monsite.com',
            'thomas',
            'name',
            ['ROLE_USER'],
            123,
        ], [
            'admin@monsite.com',
            'nicolas',
            'name',
            ['ROLE_ADMIN'],
            123,
        ],

    ];

    public function __construct(UserPasswordHasherInterface $passwordHasher)

    {

        $this->passwordHasher = $passwordHasher;
    }


    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        foreach (self::USERS as $key => $data) {
            $user = new User();
            $user->setEmail($data[0]);
            $user->setFirstname($data[1]);
            $user->setName($data[2]);
            $user->setRoles($data[3]);
            $this->addReference('user_' . $key, $user);
            $user->setPassword($this->passwordHasher->hashPassword($user,$data[4]));

            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
