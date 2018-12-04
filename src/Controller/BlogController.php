<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 12/4/18
 * Time: 2:44 PM
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController
 * @package App\Controller
 *
 * @Route("/blog")
 */
class BlogController extends AbstractController {

	private const POSTS = [
		[
			'id' => 1,
			'slug' => 'hello-world',
			'title' => 'Hello world'
		], [
			'id' => 2,
			'slug' => 'another-post',
			'title' => 'Another post'
		]
	];

	/**
	 * @Route("/", name="blog_list")
	 */
	public function list() {
		return new JsonResponse(self::POSTS);
	}

	/**
	 * @param $id
	 * @Route("/{id}", name="blog_by_id", requirements={"id"="\d+"})
	 */
	public function post($id) {
		return new JsonResponse(
			self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
		);
	}

	/**
	 * @param $slug
	 * @Route("/{slug}", name="blog_by_slug")
	 */
	public function postBySlug($slug) {
		return new JsonResponse(
			self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
		);
	}
}