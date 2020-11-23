<?php

namespace App\Controller;

use App\Entity\Immo;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Entity\ImmoSearch;
use App\Form\ImmoSearchType;
use App\Repository\ImmoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

// Annotations
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImmoController extends AbstractController
{
    /**
     * @var ImmoRepository
     */
    private $repo ;

    /**
     * @var EntityManagerInterface
     */
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
     * @param PaginatorInterface $paginator
     * @param Request $req
     * @return Response
     */
    public function home(PaginatorInterface $paginator, Request $req) : Response
    {
        // Formulaire
        $immoSearch = new ImmoSearch() ;
        $form = $this->createForm(ImmoSearchType::class, $immoSearch) ;
        $form->handleRequest($req) ;

        $immos = $paginator->paginate($this->repo->findAllUnSoldedQuery($immoSearch), $req->query->getInt("page", 1), 12) ;

        return $this->render("home.html.twig",[
            "immos" => $immos,
            "searchForm" => $form->createView()
        ]) ;
    }

    /**
     * Afficher un biem immobilier.
     *
     * @Route("/immos/{title}/{id}", name="immos.show", requirements={"id": "\d+"}, methods={"GET"})
     *
     * @param Immo $immo Le bien immobilier
     * @return Response
     */
    public function show(Immo $immo, Request $req) : Response
    {
        $contact = new Contact() ;
        $contact->setImmo($immo) ;

        $form = $this->createForm(ContactType::class, $contact) ;
        
        return $this->render("show.html.twig", [
            "immo" => $immo,
            "contactForm" => $form->createView()
        ]) ;
    }
}
