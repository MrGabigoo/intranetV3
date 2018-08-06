<?php

namespace App\Controller\administration\stage;

use App\Controller\BaseController;
use App\Entity\StagePeriode;
use App\MesClasses\MyStage;
use App\Repository\StagePeriodeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StagePeriodeGestionController
 * @package App\Controller\administration
 * @Route({"fr":"administration/stage/periode/gestion",
 *         "en":"administration/stage/period/gestion"}
 *)
 */
class StagePeriodeGestionController extends BaseController
{
    /**
     * @Route("/{uuid}", name="administration_stage_periode_gestion")
     * @ParamConverter("stagePeriode", options={"mapping": {"uuid": "uuid"}})
     * @param StagePeriodeRepository $stagePeriodeRepository
     * @param StagePeriode           $stagePeriode
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function periode(StagePeriodeRepository $stagePeriodeRepository, MyStage $myStage, StagePeriode $stagePeriode): Response
    {
        return $this->render('administration/stage/stage_periode_gestion/index.html.twig', [
            'stagePeriode' => $stagePeriode,
            'periodes' => $stagePeriodeRepository->findByFormation($this->dataUserSession->getFormation(), $this->dataUserSession->getAnneeUniversitaire()),
            'myStage' => $myStage->getDataPeriode($stagePeriode, $this->dataUserSession->getAnneeUniversitaire())
        ]);
    }
}
