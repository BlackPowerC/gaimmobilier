<?php

namespace App\Controller;

use App\Entity\Option;
use App\Entity\Options;
use App\Repository\OptionRepository;

use Doctrine\ORM\EntityManagerInterface;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\AbstractFOSRestController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Controller d'API REST pour les options.
 */
class OptionApiController extends AbstractFOSRestController
{
    private $repo ;
    private $em ;

    public function __construct(OptionRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo ;
        $this->em = $em ;
    }

    /**
     * Créer une option via une API REST
     * 
     * @Post("/api/options", name="api.options.new")
     * @View(statusCode=201)
     * @ParamConverter("option", converter="fos_rest.request_body")
     * 
     * @param Request $req
     * @return Option
     */
    public function new(Option $option, ConstraintViolationList $violations)
    {
        if(count($violations)) {
            return $this->view($violations, Response::HTTP_BAD_REQUEST) ;
        }

        $this->em->persist($option) ;
        $this->em->flush() ;

        return $this->view($option, Response::HTTP_CREATED, [
            "location" => $this->generateUrl("api.options.id", [
                "id" => $option->getId(), UrlGeneratorInterface::ABSOLUTE_URL])
        ]) ;
    }

    /**
     * Récupérer toute les options
     *
     * @Get("/api/options", name="api.options.all")
     * @View(statusCode=Response::HTTP_OK, serializerGroups={"list"})
     * @QueryParam(name="offset", default="", requirements="\d+")
     * @QueryParam(name="limit", default="", requirements="\d+")
     * 
     * @return Response
     */
    public function findAll(ParamFetcher $fetcher) 
    {
        $offset = $fetcher->get("offset") != "" ? $fetcher->get("offset") : 0 ;
        $limit = $fetcher->get("limit") != "" ? $fetcher->get("limit") : 12 ;

        return $this->repo->findWithPagination($offset, $limit) ;
    }

    /**
     * Récupérer une option avec son id.
     *
     * @Get("/api/options/{id}", name="api.options.id", requirements={"id"="\d+"})
     * @View(statusCode=Response::HTTP_OK, serializerGroups={"detail"})
     * 
     * @return Response
     */
    public function findById(int $id) {
        return $this->repo->find($id) ;
    }
}
