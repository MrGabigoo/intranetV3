<?php

namespace App\Controller\administration;

use App\Controller\BaseController;
use App\Entity\Hrs;
use App\Form\HrsType;
use App\Repository\HrsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PrevisionnelController
 * @package App\Controller\administration
 * @Route({"fr":"administration/service-previsionnel/hrs",
 *         "en":"administration/estimated-service/hrs"}
 *)
 */
class HrsController extends BaseController
{
    /**
     * @Route("/index", name="administration_hrs_index", methods="GET")
     * @param HrsRepository $hrsRepository
     *
     * @return Response
     */
    public function index(HrsRepository $hrsRepository)
    {
        return $this->render('administration/hrs/index.html.twig', [
            'hrs' => $hrsRepository->findAll() //todo: filtrer par formation
        ]);
    }

    /**
     * @Route("/{id}/edit", name="administration_hrs_edit", methods="GET|POST")
     * @param Request $request
     * @param Hrs     $hrs
     *
     * @return Response
     * @throws \Symfony\Component\Form\Exception\LogicException
     */
    public function edit(EntityManagerInterface $entityManager, Request $request, Hrs $hrs): Response
    {
        $form = $this->createForm(HrsType::class, $hrs, ['formation' => $this->dataUserSession->getFormation()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('administration_hrs_edit', ['id' => $hrs->getId()]);
        }

        return $this->render('administration/hrs/edit.html.twig', [
            'hrs' => $hrs,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/new", name="administration_hrs_new", methods="GET|POST", options={"expose": true})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ajout(EntityManagerInterface $entityManager, Request $request)
    {
        if ($this->dataUserSession->getFormation() !== null) {
            $hrs = new Hrs($this->dataUserSession->getFormation()->getOptAnneePrevisionnel());
            $form = $this->createForm(HrsType::class, $hrs, [
                'formation' => $this->dataUserSession->getFormation()
            ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($hrs);
                $entityManager->flush();

                return $this->redirectToRoute('administration_hrs_index');
            }

            return $this->render('administration/hrs/new.html.twig', [
                'hrs'  => $hrs,
                'form' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('erreur_666');
    }

    /**
     * @Route("/imprimer", name="administration_hrs_print", methods="GET")
     */
    public function imprimer(): Response
    {
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/save", name="administration_hrs_save", methods="GET")
     */
    public function save(): Response
    {
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="administration_hrs_show", methods="GET")
     * @param Hrs $hrs
     *
     * @return Response
     */
    public function show(Hrs $hrs): Response
    {
        return $this->render('administration/hrs/show.html.twig', ['hrs' => $hrs]);
    }

    /**
     * @Route({"fr":"/{id}", "en":"/{id}"}, name="administration_hrs_delete", methods="DELETE")
     * @param Request $request
     * @param Hrs     $hrs
     *
     * @return Response
     */
    public function delete(EntityManagerInterface $entityManager, Request $request, Hrs $hrs): Response
    {
        $id = $hrs->getId();
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {

            $entityManager->remove($hrs);
            $entityManager->flush();

            return $this->json($id, Response::HTTP_OK);
        }

        return $this->json(false, Response::HTTP_INTERNAL_SERVER_ERROR);
    }


}
