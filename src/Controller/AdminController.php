<?php

namespace App\Controller;

use App\Entity\Immo;
use App\Form\ImmoType;
use App\Repository\ImmoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// annotations
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    private $repo ;
    private $em ;


    public function __construct(ImmoRepository $repo, EntityManagerInterface $em) {
        $this->repo = $repo ;
        $this->em = $em ;
    }

    /**
     * Afficher la page pour gérer tout les biens immobilier.
     *
     * @Route("/admin", name="immos.admin", methods={"GET"})
     *
     * @return Response
     */
    public function index(): Response
    {
        $immos = $this->repo->findAll() ;
        return $this->render('admin/home.html.twig', [
            "immos" => $immos,
        ]) ;
    }

    /**
     * Afficher la page pour modifier un bien immobilier.
     *
     * @Route("/admin/immos/update/{id}", name="immos.admin.edit", methods={"GET", "POST"})
     *
     * @param Immo $immo
     * @param Request $req
     * @return Response
     */
    public function edit(Immo $immo, Request $req) : Response
    {
        $form = $this->createForm(ImmoType::class, $immo) ;
        $form->handleRequest($req) ;

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush() ;
            return $this->redirectToRoute("immos.admin") ;
        }

        return $this->render("admin/edit.html.twig", [
            "immos" => $immo,
            "form" => $form->createView()
        ]) ;
    }
}
