<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use App\Repository\UserRepository;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request, UserRepository $userRepository): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Check if the admin login checkbox was checked
        $adminLoginAttempt = $request->request->get('_admin_login') === 'on';

        if ($adminLoginAttempt && $lastUsername) {
            $user = $userRepository->findOneBy(['email' => $lastUsername]);
            if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
                $error = new CustomUserMessageAuthenticationException("Vous n'avez pas les droits d'administrateur.");
            }
        }


        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
