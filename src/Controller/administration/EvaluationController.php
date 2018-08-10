<?php

namespace App\Controller\administration;

use App\Controller\BaseController;
use App\Entity\Constantes;
use App\Entity\Evaluation;
use App\Entity\Semestre;
use App\Repository\EvaluationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EvaluationController
 * @package App\Controller\administration
 * @Route({"fr":"administration/evaluation",
 *         "en":"administration/evaluation"}
 *)
 */
class EvaluationController extends BaseController
{

    /**
     * @param EvaluationRepository $evaluationRepository
     * @param                      $etat
     * @param Semestre             $semestre
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/visibilite/semestre/{semestre}/{etat}", name="administration_evaluation_visibilite_all",
     *                                                  methods={"GET"})
     */
    public function visibiliteAll(EvaluationRepository $evaluationRepository, $etat, Semestre $semestre): RedirectResponse
    {
        $evals = $evaluationRepository->findBySemestre($semestre);


        /** @var Evaluation $eval */
        foreach ($evals as $eval) {
            $eval->setVisible($etat === 'visible');
            $this->entityManager->persist($eval);
        }

        $this->entityManager->flush();

        $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'Modification de la visibilité des notes effectuées');

        return $this->redirectToRoute('administration_notes_semestre_index', ['semestre' => $semestre->getId()]);
    }

    /**
     * @param EvaluationRepository $evaluationRepository
     * @param                      $etat
     * @param Semestre             $semestre
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/modifiable/semestre/{semestre}/{etat}", name="administration_evaluation_modifiable_all",
     *                                                  methods={"GET"})
     */
    public function modifiableAll(EvaluationRepository $evaluationRepository, $etat, Semestre $semestre): RedirectResponse
    {
        $evals = $evaluationRepository->findBySemestre($semestre);

        /** @var Evaluation $eval */
        foreach ($evals as $eval) {
            $eval->setModifiable($etat === 'autorise');
            $this->entityManager->persist($eval);
        }

        $this->entityManager->flush();

        $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'Autorisation de modification des notes effectuée');

        return $this->redirectToRoute('administration_notes_semestre_index', ['semestre' => $semestre->getId()]);
    }

    /**
     *
     * @param Evaluation $evaluation
     *
     * @return Response
     * @Route("/modifiable/{uuid}", name="administration_evaluation_modifiable", methods={"GET"},
     *                                    options={"expose":true})
     * @ParamConverter("evaluation", options={"mapping": {"uuid": "uuid"}})
    */
    public function modifiable(Evaluation $evaluation): Response
    {
        $evaluation->setModifiable(!$evaluation->getModifiable());
        $this->entityManager->flush();

        return new JsonResponse($evaluation->getModifiable(), Response::HTTP_OK);
    }

    /**
     *
     * @param Evaluation $evaluation
     * @ParamConverter("evaluation", options={"mapping": {"uuid": "uuid"}})
     * @return Response
     * @Route("/visibilite/{uuid}", name="administration_evaluation_visibilite", methods={"GET"},
     *                                    options={"expose":true})
     */
    public function visibilite(Evaluation $evaluation): Response
    {
        $evaluation->setVisible(!$evaluation->getVisible());
        $this->entityManager->flush();

        return new JsonResponse($evaluation->getVisible(), Response::HTTP_OK);
    }

    /**
     * @Route("/{uuid}", name="administration_evaluation_delete", methods="DELETE")
     * @param Request    $request
     * @param Evaluation $evaluation
     * @ParamConverter("evaluation", options={"mapping": {"uuid": "uuid"}})
     * @return Response
     */
    public function delete(Request $request, Evaluation $evaluation): Response
    {
        $id = $evaluation->getUuidString();
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            //todo: supprimer les notes et les modifications de notes.

            $this->entityManager->remove($evaluation);
            $this->entityManager->flush();
            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'evaluation.delete.success.flash');

            return $this->json($id, Response::HTTP_OK);
        }
        $this->addFlashBag(Constantes::FLASHBAG_ERROR, 'evaluation.delete.error.flash');

        return $this->json(false, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
