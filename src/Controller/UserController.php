<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserFormType;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('pages/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    public function create(Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/user/auth/registerView.html.twig', [
            'register_form' => $form->createView(),
        ]);
    }
    
    public function show(ManagerRegistry $doctrine, int $id, TranslatorInterface $translator): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);

        // Traductions
        $modifier = $translator->trans('Modifier');

        if (!$user) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/user/index.html.twig', [
            'user' => $user,
            'modifier' => $modifier,
        ]);
    }

    public function edit($id, ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);
        if ($user !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}
