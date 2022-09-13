<?php

namespace App\Controller\Http;

use App\Entity\Application;
use App\Entity\AppPermission;
use App\Entity\AppRole;
use App\Entity\AppUser;
use App\Form\AddApplicationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]

class ProfileController extends AbstractController
{
    #[Route('', name: 'app_profile')]
    public function index(): Response
    {
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
        {
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('profile/index.html.twig', [
            'userEmail' => $this->getUser()->getEmail(),
        ]);
    }

    #[Route('/application', name: 'app_application')]
    public function application(EntityManagerInterface $entityManager): Response
    {
        $appUser = $entityManager->getRepository(AppUser::class)->findOneBy([
            'email' => $this->getUser()->getEmail(),
        ]);
        $apps = [];
        if($appUser)
        {
            $apps = $entityManager->getRepository(Application::class)->findByAppUser($appUser->getId());
        }
        return $this->render('profile/applications.html.twig', [
            'applications' => $apps,
        ]);
    }

    #[Route('/application/add', name: 'app_new_app')]
    public function addApplication(Request $request, EntityManagerInterface $entityManager): Response
    {
        $application = new Application();
        $form        = $this->createForm(AddApplicationFormType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($application);
            $entityManager->flush();

            $appUser = $entityManager->getRepository(AppUser::class)->findOneBy([
                'email' => $this->getUser()->getEmail(),

            ]);
            if($appUser === null)
            {
                $appUser = new AppUser();
                $appUser->setEmail($this->getUser()->getEmail());
                $appUser->setUsername($this->getUser()->getEmail());
                $entityManager->persist($appUser);
                $entityManager->flush();
            }
            $role = $entityManager->getRepository(AppRole::class)->findOneBy(['role' => AppRole::ROLE_CLIENT]);

            $appPermission = new AppPermission();
            $appPermission->setApplication($application);
            $appPermission->setRole($role);
            $appPermission->setUser($appUser);
            $entityManager->persist($appPermission);
            $entityManager->flush();

            return $this->redirectToRoute('app_application');
        }
        return $this->render('profile/new_app.html.twig', [
            'addApplicationForm' => $form->createView(),
        ]);
    }
//    #[Route('/dashboard', name: 'app_profile')]
//    public function dashboard(): Response
//    {
//        return $this->render('profile/index.html.twig', [
//            'controller_name' => 'ProfileController',
//        ]);
//    }
//    public function index(): Response
//    {
//        // usually you'll want to make sure the user is authenticated first,
//        // see "Authorization" below
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//
//        // returns your User object, or null if the user is not authenticated
//        // use inline documentation to tell your editor your exact User class
//        /** @var User $user */
//        $user = $this->getUser();
//
//        // Call whatever methods you've added to your User class
//        // For example, if you added a getFirstName() method, you can use that.
//        return new Response('Well hi there '.$user->getFirstName());
//    }
}
