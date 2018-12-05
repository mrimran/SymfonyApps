<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $post = new BlogPost();
	    $post->setTitle('Testing seed title 1');
	    $post->setPublished(new \DateTime('2018-12-05 12:00:00'));
	    $post->setContent('Testing seed content 1...');
	    $post->setAuthor('Imran');
	    $post->setSlug('testing-seed-title-1');
        $manager->persist($post);

	    $post = new BlogPost();
	    $post->setTitle('Testing seed title 2');
	    $post->setPublished(new \DateTime('2018-12-05 12:00:00'));
	    $post->setContent('Testing seed content 2...');
	    $post->setAuthor('Farhan');
	    $post->setSlug('testing-seed-title-2');
	    $manager->persist($post);

	    $post = new BlogPost();
	    $post->setTitle('Testing seed title 3');
	    $post->setPublished(new \DateTime('2018-12-05 12:00:00'));
	    $post->setContent('Testing seed content 3...');
	    $post->setAuthor('Farhan');
	    $post->setSlug('testing-seed-title-3');
	    $manager->persist($post);

        $manager->flush();
    }
}
