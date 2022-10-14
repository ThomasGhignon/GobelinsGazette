<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('Foo');
        $user->setEmail('foo@gmail.com');
        $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();

        for ( $i = 0; $i < 10; $i++ ) {
            $post = new post();
            $post->setTitle('Do you Remember... Phil Collins?!');
            $post->setContent("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.");
            $post->setAuthor($user);
            $post->setLikes(0);
            $post->setCreateAt(new \DateTime());
            $manager->persist($post);
            $manager->flush();
        }

        $user = new User();
        $user->setUsername('Test');
        $user->setEmail('test@gmail.com');
        $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_EDITOR']);
        $manager->persist($user);
        $manager->flush();

        for ( $i = 0; $i < 2; $i++ ) {
            $post = new post();
            $post->setTitle('Test Post Title');
            $post->setContent("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.");
            $post->setAuthor($user);
            $post->setLikes(0);
            $post->setCreateAt(new \DateTime());
            $manager->persist($post);
            $manager->flush();
        }
    }
}
