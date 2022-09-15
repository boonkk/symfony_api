<?php

namespace App\Controller\Http;

use App\Entity\Application;
use App\Entity\AppPermission;
use App\Entity\AppUser;
use App\Form\AddApplicationFormType;
use App\Form\AddAppPermissionFormType;
use App\Form\AddAppUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('', name: 'app_admin')]
    public function index(): Response
    {
        $email = $this->getUser()?->getEmail();
        return $this->render('admin/index.html.twig', [
            'userEmail' => $email,
        ]);
    }

    #[Route('/applications', name: 'app_applications')]
    public function applications(EntityManagerInterface $entityManager): Response
    {
        $apps = $entityManager->getRepository(Application::class)->findAll();

        return $this->render('admin/applications.html.twig', [
            'applications' => $apps,
        ]);
    }

    #[Route('/permissions', name: 'app_permissions')]
    public function permissions(EntityManagerInterface $entityManager): Response
    {
        $perms = $entityManager->getRepository(AppPermission::class)->findAllWithNames();
        return $this->render('admin/permissions.html.twig', [
            'permissions' => $perms,
        ]);
    }

    #[Route('/config', name: 'app_config')]
    public function config(): Response
    {
        return $this->render('admin/config.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/users', name: 'app_users')]
    public function manageUsers(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(AppUser::class)->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/new_app', name: 'app_new_application')]
    public function addApplication(Request $request, EntityManagerInterface $entityManager): Response
    {
        $application = new Application();
        $form        = $this->createForm(AddApplicationFormType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($application);
            $entityManager->flush();

            return $this->redirectToRoute('app_applications');
        }
        return $this->render('application/new_app.html.twig', [
            'addApplicationForm' => $form->createView(),
        ]);
    }

    #[Route('/new_user', name: 'app_new_user')]
    public function addUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new AppUser();
        $form        = $this->createForm(AddAppUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_users');
        }

        return $this->render('admin/new_user.html.twig', [
            'addUserForm' => $form->createView(),
        ]);
    }

    #[Route('/new_permission', name: 'app_new_permission')]
    public function addPermission(Request $request, EntityManagerInterface $entityManager): Response
    {
        $appPermission = new AppPermission();
        $form        = $this->createForm(AddAppPermissionFormType::class, $appPermission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($appPermission);
            $entityManager->flush();

            return $this->redirectToRoute('app_permissions');
        }

        return $this->render('admin/new_permission.html.twig', [
            'addPermissionForm' => $form->createView(),
        ]);
    }
}
