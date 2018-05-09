<?php

namespace App\Controller\superAdministration;

use App\Entity\Site;
use App\Form\SiteType;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}/super-administration/site",
 *      requirements={
 *         "_locale": "fr|en"})
 */
class SiteController extends Controller
{
    /**
     * @Route("/", name="sa_site_index", methods="GET")
     * @param SiteRepository $siteRepository
     *
     * @return Response
     */
    public function index(SiteRepository $siteRepository): Response
    {
        return $this->render('super-administration/site/index.html.twig', ['sites' => $siteRepository->findAll()]);
    }

    /**
    * @Route("/help", name="sa_site_help", methods="GET")
    */
    public function help(): Response
    {
        return $this->render('super-administration/site/help.html.twig');
    }

    /**
    * @Route("/save", name="sa_site_save", methods="GET")
    */
    public function save(): Response
    {
        //save en csv
        return new Response('', 200);
    }

    /**
    * @Route("/imprimer", name="sa_site_print", methods="GET")
    */
    public function imprimer(): Response
    {
        //print (pdf)
        return new Response('', 200);
    }

    /**
     * @Route("/new", name="sa_site_new", methods="GET|POST")
     * @param Request $request
     *
     * @return Response
     * @throws \Symfony\Component\Form\Exception\LogicException
     */
    public function new(Request $request): Response
    {
        $site = new Site();
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($site);
            $em->flush();

            return $this->redirectToRoute('sa_site_index');
        }

        return $this->render('super-administration/site/new.html.twig', [
            'site' => $site,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sa_site_show", methods="GET")
     * @param Site $site
     *
     * @return Response
     */
    public function show(Site $site): Response
    {
        return $this->render('super-administration/site/show.html.twig', ['site' => $site]);
    }

    /**
     * @Route("/{id}/edit", name="sa_site_edit", methods="GET|POST")
     * @param Request $request
     * @param Site    $site
     *
     * @return Response
     * @throws \Symfony\Component\Form\Exception\LogicException
     */
    public function edit(Request $request, Site $site): Response
    {
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sa_site_edit', ['id' => $site->getId()]);
        }

        return $this->render('super-administration/site/edit.html.twig', [
            'site' => $site,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sa_site_delete", methods="DELETE")
     */
    public function delete(): void
    {

    }
}