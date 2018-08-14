<?php

namespace App\Controller\administration;

use App\Entity\Alternance;
use App\Entity\Annee;
use App\Form\AlternanceType;
use App\Repository\AlternanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration/alternance")
 */
class AlternanceController extends Controller
{
    /**
     * @Route("/{annee}", name="administration_alternance_index", methods="GET")
     */
    public function index(AlternanceRepository $alternanceRepository, Annee $annee): Response
    {
        return $this->render('administration/alternance/index.html.twig', ['alternances' => $alternanceRepository->findAll()]);
    }

    /**
     * @Route("/new", name="administration_alternance_new", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $alternance = new Alternance();
        $form = $this->createForm(AlternanceType::class, $alternance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($alternance);
            $em->flush();

            return $this->redirectToRoute('administration_alternance_index');
        }

        return $this->render('administration/alternance/new.html.twig', [
            'alternance' => $alternance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uuid}", name="alternance_show", methods="GET")
     */
    public function show(Alternance $alternance): Response
    {
        return $this->render('administration/alternance/show.html.twig', ['alternance' => $alternance]);
    }

    /**
     * @Route("/{id}/edit", name="administration_alternance_edit", methods="GET|POST")
     */
    public function edit(Request $request, Alternance $alternance): Response
    {
        $form = $this->createForm(AlternanceType::class, $alternance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('administration_alternance_edit', ['id' => $alternance->getId()]);
        }

        return $this->render('administration/alternance/edit.html.twig', [
            'alternance' => $alternance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alternance_delete", methods="DELETE")
     */
    public function delete(Request $request, Alternance $alternance): Response
    {

    }
}
