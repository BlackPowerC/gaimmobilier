<?php

namespace App\Controller;

use App\Repository\OptionRepository;
use JMS\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controller d'API REST pour les options.
 * 
 * @Route("/api/options")
 */
class OptionApiController extends AbstractController
{
    private $repo ;
    private $serializer ;
    private $em ;
    private $sc ;

    public function __construct(OptionRepository $repo, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->repo = $repo ;
        $this->serializer = $serializer ;
        $this->em = $em ;
        $this->sc = SerializationContext::create() ;
    }

    /**
     * Créer une option via une API REST
     * 
     * @Route("", name="api.options.new", methods={"POST"})
     * 
     * @param Request $req
     * @return void
     */
    public function new(Request $req, ValidatorInterface $validator) : Response
    {
        $data = $req->getContent() ;
        $newOption = $this->serializer->deserialize($data, "App\Entity\Option", "json") ;

        $this->em->persist($newOption) ;
        $this->em->flush() ;

        return new Response("", 201) ;
    }

    /**
     * Récupérer toute les options
     *
     * @Route("", name="api.options.all", methods={"GET"})
     * 
     * @return Response
     */
    public function findAll() : Response 
    {
        return new Response() ;
    }

    /**
     * Récupérer une option avec son id.
     *
     * @Route("/{id}", name="api.options.id", methods={"GET"})
     * 
     * @return Response
     */
    public function findById(int $id) : Response 
    {
        return new Response() ;
    }
}
