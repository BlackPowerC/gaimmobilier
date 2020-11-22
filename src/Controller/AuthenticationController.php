<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// annotations
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends AbstractController
{

    /**
     * @Route("/login", name="immos.admin.login")
     *
     * @param AuthenticationUtils $au
     * @return Response
     */
    public function login(AuthenticationUtils $au) : Response
    {
        return $this->render("admin/login.html.twig", [
            "lastUsername" => $au->getLastUsername(),
            "error" => $au->getLastAuthenticationError()
        ]) ;
    }
}