<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(Post::class)->findAll();

        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts found'
            );
        }
        return $this->render('pages/home/view.html.twig', array('posts' => $posts));
    }

    public function flashMessage(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $this->addFlash('error', 'Error message');
        return $this->redirectToRoute('app_home');
    }
}