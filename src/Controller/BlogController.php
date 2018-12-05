<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 12/4/18
 * Time: 2:44 PM
 */

namespace App\Controller;


use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

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
	 * @Route("/{page}", name="blog_list", requirements={"page"="\d+"})
	 */
	public function list($page = 1) {
		return $this->json([
			'page' => $page,
			'data' => array_map(function($item) {
				return $this->generateUrl('blog_by_id', ['id' => $item['id']]);
			}, self::POSTS)
		]);
	}

	/**
	 * @param $id
	 * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"})
	 */
	public function post($id) {
		return $this->json(
			self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
		);
	}

	/**
	 * @param $slug
	 * @Route("/post/{slug}", name="blog_by_slug")
	 */
	public function postBySlug($slug) {
		return $this->json(
			self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
		);
	}

	/**
	 * @param Request $req
	 * @Route("/add", name="blog_add", methods={"POST"})
	 * @return JsonResponse
	 */
	public function add(Request $req) {
		/** @var Serializer $serializer */
		$serializer = $this->get('serializer');

		$blogPost = $serializer->deserialize($req->getContent(), BlogPost::class, 'json');

		$em = $this->getDoctrine()->getManager();
		$em->persist($blogPost);
		$em->flush();

		return $this->json($blogPost);
	}
}