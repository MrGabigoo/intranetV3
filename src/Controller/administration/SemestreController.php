<?php

namespace App\Controller\administration;

use App\Controller\BaseController;
use App\Entity\Semestre;
use App\Repository\RattrapageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SemestreController
 * @package App\Controller\administration
 * @Route({"fr":"administration/semestre",
 *         "en":"administration/semester"}
 *)
 */
class SemestreController extends BaseController
{
    /**
     * @Route("/{semestre}", name="administration_semestre_index")
     * @param RattrapageRepository $rattrapageRepository
     * @param Semestre             $semestre
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(RattrapageRepository $rattrapageRepository,  Semestre $semestre): Response
    {
        return $this->render('administration/semestre/index.html.twig', [
            'semestre' => $semestre,
            'nbRattrapage' => $rattrapageRepository->findBySemestre($semestre, $this->dataUserSession->getAnneeUniversitaire())
        ]);
    }
}
