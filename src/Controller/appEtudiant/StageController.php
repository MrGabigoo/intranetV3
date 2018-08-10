<?php

namespace App\Controller\appEtudiant;

use App\Controller\BaseController;
use App\Entity\Constantes;
use App\Entity\StageEtudiant;
use App\Form\StageEtudiantEtudiantType;
use App\Repository\StageEtudiantRepository;
use App\Repository\StagePeriodeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StageController
 * @package App\Controller
 * @Route({"fr":"application/etudiant/stage",
 *         "en":"application/student/internship"}
 *)
 * @IsGranted("ROLE_ETUDIANT")
 */
class StageController extends BaseController
{
    /**
     * @Route("/", name="application_etudiant_stage_index")
     * @param StageEtudiantRepository $stageEtudiantRepository
     * @param StagePeriodeRepository  $stagePeriodeRepository
     *
     * @return Response
     */
    public function index(StageEtudiantRepository $stageEtudiantRepository, StagePeriodeRepository $stagePeriodeRepository): Response
    {
        $stagePeriodes = $stagePeriodeRepository->findStageEtudiant($this->dataUserSession->getUser()->getSemestre(), $this->dataUserSession->getAnneeUniversitaire());
        $stageEtudiants = array();
        foreach ($this->dataUserSession->getUser()->getStageEtudiants() as $stage) {
            $stageEtudiants[$stage->getStagePeriode()->getId()] = $stage;
        }


        return $this->render('appEtudiant/stage/index.html.twig', [
            'stagePeriodes' => $stagePeriodes,
            'stageEtudiants' => $stageEtudiants
        ]);
    }

    /**
     * @Route("/formulaire/{stageEtudiant}", name="application_etudiant_stage_formulaire", methods="GET|POST")
     * @ParamConverter("stageEtudiant", options={"mapping": {"stageEtudiant": "uuid"}})
     * @param Request       $request
     * @param StageEtudiant $stageEtudiant
     *
     * @return Response
     */
    public function create(Request $request, StageEtudiant $stageEtudiant): Response
    {
        $form = $this->createForm(StageEtudiantEtudiantType::class, $stageEtudiant, ['flexible' => $stageEtudiant->getStagePeriode()->getDatesFlexibles(), 'attr'      => [
            'data-provide' => 'validation'
        ]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stageEtudiant->setEtatStage(StageEtudiant::ETAT_STAGE_DEPOSE);
            $stageEtudiant->setDateDepotFormulaire(new \DateTime('now'));
            $this->entityManager->flush();

            //todo: mail de confirmation + mail au RP de stage et notif.
            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'stage_etudiant.formulaire.success.flash');

            return $this->redirectToRoute('application_index', ['onglet' => 'stage']);
        }

        return $this->render('appEtudiant/stage/formulaire.html.twig', [
            'stageEtudiant' => $stageEtudiant,
            'form' => $form->createView(),
        ]);
    }
}
