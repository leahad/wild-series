<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    const USERS = [
        ['email' =>'contributor@monsite.com', 'password' => 'contributorpassword', 'role' =>['ROLE_CONTRIBUTOR']],
        ['email' =>'admin@monsite.com', 'password' => 'adminpassword', 'role' =>['ROLE_ADMIN']],
    ];

    public function __construct(private UserPasswordHasherInterface $passwordHasher) 
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        foreach(self::USERS as $userInfo) {
            $user = new User();
            $user->setEmail($userInfo['email']);
            $user->setRoles($userInfo['role']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $userInfo['password']
            );
            $user->setPassword($hashedPassword);

            $manager->persist($user);

            $this->addReference('user_' . $userInfo['email'], $user);
            
        }
        
        $manager->flush();
    }

}
