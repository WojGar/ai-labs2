<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // jeśli już zalogowany – przekieruj gdzieś sensownie
        if ($this->getUser()) {
            return $this->redirectToRoute('app_location_index');
        }

        // błąd logowania (jeśli był)
        $error = $authenticationUtils->getLastAuthenticationError();
        // ostatni wpisany login
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
