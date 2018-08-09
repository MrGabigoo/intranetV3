<?php

namespace App\Controller\superAdministration;

use App\Controller\BaseController;
use App\Entity\Constantes;
use App\Entity\Site;
use App\Form\SiteType;
use App\Repository\SiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}/super-administration/site",
 *      requirements={
 *         "_locale": "fr|en"})
 */
class SiteController extends BaseController
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
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/imprimer", name="sa_site_print", methods="GET")
     */
    public function imprimer(): Response
    {
        //print (pdf)
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/new", name="sa_site_new", methods="GET|POST")
     * @param Request                $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        $site = new Site();
        $form = $this->createForm(SiteType::class, $site, [
            'attr' => [
                'data-provide' => 'validation'
            ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($site);
            $this->entityManager->flush();
            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'site.add.success.flash');

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
     * @param Request                $request
     * @param Site                   $site
     *
     * @return Response
     */
    public function edit(Request $request, Site $site): Response
    {
        $form = $this->createForm(SiteType::class, $site, [
            'attr' => [
                'data-provide' => 'validation'
            ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'site.edit.success.flash');

            return $this->redirectToRoute('sa_site_edit', ['id' => $site->getId()]);
        }

        return $this->render('super-administration/site/edit.html.twig', [
            'site' => $site,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/duplicate", name="sa_site_duplicate", methods="GET|POST")
     * @param Site $site
     *
     * @return Response
     */
    public function duplicate(Site $site): Response
    {
        $newSite = clone $site;

        $this->entityManager->persist($newSite);
        $this->entityManager->flush();

        return $this->redirectToRoute('sa_site_edit', ['id' => $newSite->getId()]);
    }

    /**
     * @Route("/{id}", name="sa_site_delete", methods="DELETE")
     */
    public function delete(): void
    {
    }
}
