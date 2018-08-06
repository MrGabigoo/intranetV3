<?php

namespace App\Controller\administration\stage;

use App\Controller\BaseController;
use App\Entity\Constantes;
use App\Entity\Etudiant;
use App\Entity\StageEtudiant;
use App\Entity\StagePeriode;
use App\Form\StageEtudiantType;
use App\MesClasses\MyStageEtudiant;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("administration/stage/etudiant")
 */
class StageEtudiantController extends BaseController
{
    /**
     * @Route("/new", name="administration_stage_etudiant_new", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $stageEtudiant = new StageEtudiant();
        $form = $this->createForm(StageEtudiantType::class, $stageEtudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stageEtudiant);
            $em->flush();

            return $this->redirectToRoute('administration_stage_periode_gestion', ['uuid' => $stageEtudiant->getStagePeriode()->getUuidString()]);
        }

        return $this->render('administration/stage/stage_etudiant/new.html.twig', [
            'stage_etudiant' => $stageEtudiant,
            'form'           => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="administration_stage_etudiant_show", methods="GET")
     */
    public function show(StageEtudiant $stageEtudiant): Response
    {
        return $this->render('administration/stage/stage_etudiant/show.html.twig',
            ['stage_etudiant' => $stageEtudiant]);
    }

    /**
     * @Route("/{id}/edit", name="administration_stage_etudiant_edit", methods="GET|POST")
     */
    public function edit(Request $request, StageEtudiant $stageEtudiant): Response
    {
        $form = $this->createForm(StageEtudiantType::class, $stageEtudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('administration_stage_etudiant_edit', ['id' => $stageEtudiant->getId()]);
        }

        return $this->render('administration/stage/stage_etudiant/edit.html.twig', [
            'stage_etudiant' => $stageEtudiant,
            'form'           => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="administration_stage_etudiant_delete", methods="DELETE")
     */
    public function delete(Request $request, StageEtudiant $stageEtudiant): Response
    {


        return $this->redirectToRoute('administration_stage_periode_gestion', ['uuid' => $stageEtudiant->getStagePeriode()->getUuidString()]);
    }

    /**
     * @param StagePeriode $stagePeriode
     * @param Etudiant     $etudiant
     * @param              $etat
     * @Route("/change-etat/{stagePeriode}/{etudiant}/{etat}", name="administration_stage_etudiant_change_etat")
     * @ParamConverter("stagePeriode", options={"mapping": {"stagePeriode": "uuid"}})
     */
    public function changeEtat(MyStageEtudiant $myStageEtudiant, StagePeriode $stagePeriode, Etudiant $etudiant, $etat) {
        $myStageEtudiant->changeEtat($stagePeriode, $etudiant, $etat);
        $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'stage_etudiant.change_etat.success.flash');

        return $this->redirectToRoute('administration_stage_periode_gestion', ['uuid' => $stagePeriode->getUuidString()]);
    }
}
