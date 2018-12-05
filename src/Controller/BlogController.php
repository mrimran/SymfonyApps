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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
 * Class BlogController
 * @package App\Controller
 *
 * @Route("/blog")
 */
class BlogController extends AbstractController {

	/**
	 * @Route("/{page}", name="blog_list", requirements={"page"="\d+"})
	 */
	public function list($page = 1) {
		//$repo = $this->getDoctrine()->getRepository(BlogPost::class);
		$items = $this->getDoctrine()->getRepository(BlogPost::class)->findAll();
		
		return $this->json([
			'page' => $page,
			'data' => array_map(function($item) {
				return $this->generateUrl('blog_by_slug', ['slug' => $item->getSlug()]);
			}, $items)
		]);
	}

	/**
	 * @param BlogPost $post
	 * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"}, methods={"GET"})
	 */
	public function post(BlogPost $post) {
		return $this->json($post);//same as find($id) on repo
	}

	/**
	 * @param BlogPost $post
	 * @Route("/post/{slug}", name="blog_by_slug", methods={"GET"})
	 */
	public function postBySlug(BlogPost $post) {
		//Note: the parameter slug should exist in db table too, if not then we need to use ParamConverter annotation to map
		return $this->json($post);//same as of findBy(['slug' => 'slug value'])
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

	/**
	 * @param BlogPost $post
	 * @Route("/post/{id}", name="blog_delete", methods={"DELETE"})
	 */
	public function delete(BlogPost $post) {
		$em = $this->getDoctrine()->getManager();
		$em->remove($post);
		$em->flush();

		return new JsonResponse(null, Response::HTTP_NO_CONTENT);
	}
}