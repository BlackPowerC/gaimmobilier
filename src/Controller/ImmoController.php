<?php

namespace App\Controller;

use App\Repository\ImmoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

// Annotations
use Symfony\Component\Routing\Annotation\Route;

class ImmoController extends AbstractController
{

    private $repo ;
    private $em ;

    public function __construct(ImmoRepository $repo, EntityManagerInterface $em)
    {
        $this->em = $em ;
        $this->repo = $repo ;
    }

    /**
     * Afficher la page d'accueil avec tout les biens immobiliers.
     *
     * @Route("/", name="immos.home", methods={"GET"})
     *
     * @return Response
     */
    public function home() : Response
    {
        $immos = $this->repo->findAll() ;

        return $this->render("home.html.twig",[
            "immos" => $immos
        ]) ;
    }

    /**
     * Afficher un biem immobilier.
     *
     * @Route("/immos/{title}/{id}", name="immos.show", requirements={"id": "\d+"}, methods={"GET"})
     *
     * @param int $id L'id du bien immobilier
     * @return Response
     */
    public function show(int $id) : Response
    {
        $immo = $this->repo->find($id) ;
        if(is_null($immo)) {
            return new Response("Rien par ici", 404) ;
        }

        return $this->render("show.html.twig", [
            "immo" => $immo
        ]) ;
    }
}
