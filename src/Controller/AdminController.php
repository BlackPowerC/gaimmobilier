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
    /**
     * @var ImmoRepository
     */
    private $repo ;

    /**
     * @var EntityManagerInterface
     */
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
            $this->addFlash("success", "Modifié avec succès") ;
            return $this->redirectToRoute("immos.admin") ;
        }

        return $this->render("admin/edit.html.twig", [
            "immo" => $immo,
            "form" => $form->createView()
        ]) ;
    }

    /**
     * Afficher la page pour enregistrer un nouveau bien.
     *
     * @Route("/admin/immos/new", name="immos.admin.new", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function add(Request $request) : Response
    {
        $immo = new Immo() ;
        $form = $this->createForm(ImmoType::class, $immo) ;
        $form->handleRequest($request) ;

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($immo) ;
            $this->em->flush() ;
            $this->addFlash("success", "Ajouté avec succès") ;

            return $this->redirectToRoute("immos.admin") ;
        }

        return $this->render("admin/new.html.twig", [
            "immo" => $immo,
            "form" => $form->createView()
        ]) ;
    }

    /**
     * @Route("/admin/immos/delete/{id}", name="immos.admin.delete", requirements={"id": "\d+"}, methods={"DELETE"})
     *
     * @param Request $request
     * @param Immo $immo
     * @return Response
     */
    public function delete(Request $request, Immo $immo) : Response
    {
        if($this->isCsrfTokenValid("delete" . $immo->getId(), $request->get("_token")))
        {
            $this->em->remove($immo) ;
            $this->em->flush() ;
            $this->addFlash("success", "Supprimé avec succès") ;
        }
        else {
            $this->addFlash("error", "Quelque chose s'est mal passé") ;
        }

        return $this->redirectToRoute("immos.admin") ;
    }
}
