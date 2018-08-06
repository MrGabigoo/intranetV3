<?php

namespace App\Controller;

use App\Entity\StageEtudiant;
use App\Form\StageEtudiantType;
use App\Repository\StageEtudiantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stage/etudiant")
 */
class StageEtudiantController extends Controller
{
    /**
     * @Route("/", name="stage_etudiant_index", methods="GET")
     */
    public function index(StageEtudiantRepository $stageEtudiantRepository): Response
    {
        return $this->render('stage_etudiant/index.html.twig', ['stage_etudiants' => $stageEtudiantRepository->findAll()]);
    }

    /**
     * @Route("/new", name="stage_etudiant_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $stageEtudiant = new StageEtudiant();
        $form = $this->createForm(StageEtudiantType::class, $stageEtudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stageEtudiant);
            $em->flush();

            return $this->redirectToRoute('stage_etudiant_index');
        }

        return $this->render('stage_etudiant/new.html.twig', [
            'stage_etudiant' => $stageEtudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stage_etudiant_show", methods="GET")
     */
    public function show(StageEtudiant $stageEtudiant): Response
    {
        return $this->render('stage_etudiant/show.html.twig', ['stage_etudiant' => $stageEtudiant]);
    }

    /**
     * @Route("/{id}/edit", name="stage_etudiant_edit", methods="GET|POST")
     */
    public function edit(Request $request, StageEtudiant $stageEtudiant): Response
    {
        $form = $this->createForm(StageEtudiantType::class, $stageEtudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stage_etudiant_edit', ['id' => $stageEtudiant->getId()]);
        }

        return $this->render('stage_etudiant/edit.html.twig', [
            'stage_etudiant' => $stageEtudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stage_etudiant_delete", methods="DELETE")
     */
    public function delete(Request $request, StageEtudiant $stageEtudiant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stageEtudiant->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stageEtudiant);
            $em->flush();
        }

        return $this->redirectToRoute('stage_etudiant_index');
    }
}
