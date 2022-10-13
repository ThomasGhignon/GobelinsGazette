<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostFormType;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Workflow\Registry;

class PostController extends AbstractController
{

    public function __construct(private Registry $registry)
    {

    }

    public function index(): Response
    {
        $post = new Post();
        $workflow = $this->registry->get($post, 'blog_publishing');
//        $workflow->can($post, 'to_review'); // true
//        $workflow->can($post, 'reject'); // true
//        $workflow->can($post, 'publish'); // false
//        dd($workflow->getEnabledTransitions($post));
//        $workflow->apply($post, 'to_review');
//        $workflow->apply($post, 'publish'); // throws an exception
//        dd($post);
        return $this->render('pages/post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $post = new Post();
        $post->setAuthor($this->getUser());
        $post->setCreateAt(new \DateTime());
        $post->setLikes(0);
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            $workflow = $this->registry->get($post, 'blog_publishing');
            if ($workflow->can($post, 'to_review')){
                $workflow->apply($post, 'to_review');
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/post/create.html.twig', [
            'post_form' => $form->createView(),
        ]);
    }

    public  function show(ManagerRegistry $doctrine, int $id): Response
    {
        $post = $doctrine->getRepository(Post::class)->find($id);

        if (!$post) {
            return $this->render('pages/post/single.html.twig');
        }

        return $this->render('pages/post/single.html.twig', [
            'post' => $post,
        ]);
    }
}
