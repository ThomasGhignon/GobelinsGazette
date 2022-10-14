<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostFormType;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Workflow\Registry;
use Symfony\Contracts\Translation\TranslatorInterface;

class PostController extends AbstractController
{

    public function __construct(private Registry $registry)
    {

    }

    public function create(Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
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

        // Traductions
        $motdepasse = $translator->trans('Mot de passe');
        $titre = $translator->trans('Titre');
        $contenu = $translator->trans('Contenu');
        $creerunnouveaupost = $translator->trans('Créer un nouveau post');


        return $this->render('pages/post/create.html.twig', [
            'post_form' => $form->createView(),
            'creerunnouveaupost' => $creerunnouveaupost,
            'motdepasse' => $motdepasse,
            'titre' => $titre,
            'contenu' => $contenu,
        ]);
    }

    public  function show(ManagerRegistry $doctrine, int $id, TranslatorInterface $translator): Response
    {
        $post = $doctrine->getRepository(Post::class)->find($id);
        $user = $doctrine->getRepository(User::class)->find($post->getAuthor());

        // Traductions
        $retour = $translator->trans('Retour en arrière');

        if (!$post) {
            return $this->render('pages/post/single.html.twig', [
                'retour' => $retour,
            ]);
        }
        
        return $this->render('pages/post/single.html.twig', [
            'post' => $post,
            'user' => $user,
            'retour' => $retour,
        ]);
    }

    public function edit($id, ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator): Response
    {
        $post = $doctrine->getRepository(Post::class)->find($id);
        if ($post->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('message', 'Post modifié avec succès');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('pages/post/edit.html.twig', [
            'post_form' => $form->createView(),
        ]);
    }

    public function delete($id, ManagerRegistry $doctrine, TranslatorInterface $translator): Response
    {
        $post = $doctrine->getRepository(Post::class)->find($id);
        if ($post->getAuthor() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        $this->addFlash('message', 'Post supprimé avec succès');
        return $this->redirectToRoute('app_home');
    }
}
