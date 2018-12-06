<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
	/**
	 * @var UserPasswordEncoderInterface
	 */
	private $passEncoder;

	public function __construct(UserPasswordEncoderInterface $passEncoder) {
		$this->passEncoder = $passEncoder;
	}

	public function load(ObjectManager $manager)
    {
    	$this->loadUsers($manager);
		$this->loadBlogPosts($manager);
    }

    public function loadBlogPosts(ObjectManager $manager) {
    	$user = $this->getReference('user_post');

	    $post = new BlogPost();
	    $post->setTitle('Testing seed title 1');
	    $post->setPublished(new \DateTime('2018-12-05 12:00:00'));
	    $post->setContent('Testing seed content 1...');
	    $post->setAuthor($user);
	    $post->setSlug('testing-seed-title-1');
	    $manager->persist($post);

	    $post = new BlogPost();
	    $post->setTitle('Testing seed title 2');
	    $post->setPublished(new \DateTime('2018-12-05 12:00:00'));
	    $post->setContent('Testing seed content 2...');
	    $post->setAuthor($user);
	    $post->setSlug('testing-seed-title-2');
	    $manager->persist($post);

	    $post = new BlogPost();
	    $post->setTitle('Testing seed title 3');
	    $post->setPublished(new \DateTime('2018-12-05 12:00:00'));
	    $post->setContent('Testing seed content 3...');
	    $post->setAuthor($user);
	    $post->setSlug('testing-seed-title-3');
	    $manager->persist($post);

	    $manager->flush();
    }

    public function loadComments(ObjectManager $manager) {

    }

    public function loadUsers(ObjectManager $manager) {
	    $user = new User();
	    $user->setUsername('admin');
	    $user->setEmail('admin@test.com');
	    $user->setName('Admin Test');

	    $user->setPassword($this->passEncoder->encodePassword($user, 'admin123'));

	    $this->addReference('user_post', $user);

	    $manager->persist($user);
	    $manager->flush();
    }
}
