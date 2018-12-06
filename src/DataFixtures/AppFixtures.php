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

	/**
	 * @var \Faker\Factory
	 */
	private $faker;

	public function __construct(UserPasswordEncoderInterface $passEncoder) {
		$this->faker = \Faker\Factory::create();
		$this->passEncoder = $passEncoder;
	}

	public function load(ObjectManager $manager)
    {
    	$this->loadUsers($manager);
		$this->loadBlogPosts($manager);
	    $this->loadComments($manager);
    }

    public function loadBlogPosts(ObjectManager $manager) {
    	$user = $this->getReference('user_post');

	    for($i = 0; $i < 100; $i++) {
		    $post = new BlogPost();
		    $title = $this->faker->realText(30);
		    //$slug = str_replace(' ', '-', $title);
		    $post->setTitle($title);
		    $post->setPublished($this->faker->dateTimeThisYear);
		    $post->setContent($this->faker->realText());
		    $post->setAuthor($user);
		    $post->setSlug($this->faker->slug);

		    $this->setReference("blog_post_$i", $post);

		    $manager->persist($post);
	    }

	    $manager->flush();
    }

    public function loadComments(ObjectManager $manager) {
	    for($i = 0; $i < 100; $i++) {
	    	for($j = 0; $j < rand(1, 10); $j++) {
	    		$comment = new Comment();
	    		$comment->setContent($this->faker->realText());
	    		$comment->setPublished($this->faker->dateTimeThisYear);
	    		$comment->setPost($this->getReference("blog_post_$i"));
	    		$comment->setAuthor($this->getReference('user_post'));

	    		$manager->persist($comment);
		    }
	    }

	    $manager->flush();
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
