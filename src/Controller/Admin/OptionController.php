<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Annotations
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/option")
 */
class OptionController extends AbstractController
{

    private $em ;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em ;
    }

    /**
     * @Route("/", name="admin.option.index", methods={"GET"})
     *
     * @param OptionRepository $optionRepository
     * @return Response
     */
    public function index(OptionRepository $repo, PaginatorInterface $paginator, Request $req): Response
    {
        $options = $paginator->paginate($repo->findAllQuery(), $req->query->getInt("page", 1), 6) ;

        return $this->render("admin/option/index.html.twig", [
            "options" => $options,
        ]) ;
    }

    /**
     * @Route("/new", name="admin.option.new", methods={"GET","POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $option = new Option() ;
        $form = $this->createForm(OptionType::class, $option) ;
        $form->handleRequest($request) ;

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($option) ;
            $this->em->flush() ;

            return $this->redirectToRoute("admin.option.index") ;
        }

        return $this->render("admin/option/new.html.twig", [
            "option" => $option,
            "form" => $form->createView(),
        ]) ;
    }

    /**
     * @Route("/{id}", name="admin.option.show", requirements={"id": "\d+"}, methods={"GET"})
     *
     * @param Option $option
     * @return Response
     */
    public function show(Option $option): Response
    {
        return $this->render("admin/option/show.html.twig", [
            "option" => $option,
        ]) ;
    }

    /**
     * @Route("/{id}/edit", name="admin.option.edit", requirements={"id": "\d+"}, methods={"GET","POST"})
     *
     * @param Request $request
     * @param Option $option
     * @return Response
     */
    public function edit(Request $request, Option $option): Response
    {
        $form = $this->createForm(OptionType::class, $option) ;
        $form->handleRequest($request) ;

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush() ;

            return $this->redirectToRoute("option_index") ;
        }

        return $this->render("admin/option/edit.html.twig", [
            "option" => $option,
            "form" => $form->createView(),
        ]) ;
    }

    /**
     * @Route("/{id}", name="admin.option.delete", methods={"DELETE"})
     *
     * @param Request $request
     * @param Option $option
     * @return Response
     */
    public function delete(Request $request, Option $option): Response
    {
        if ($this->isCsrfTokenValid("delete".$option->getId(), $request->request->get("_token")))
        {
            $this->em->remove($option) ;
            $this->em->flush() ;
        }

        return $this->redirectToRoute("option_index") ;
    }
}
