<?php

namespace App\Controller;

use App\Entity\Immo;
use App\Repository\ImmoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/admin/immos/update/{id}", name="immos.admin.edit", methods={"GET"})
     *
     * @param Immo $immo
     * @return Response
     */
    public function edit(Immo $immo) : Response
    {
        return $this->render("admin/edit.html.twig", [
            "immos" => $immo
        ]) ;
    }
}
