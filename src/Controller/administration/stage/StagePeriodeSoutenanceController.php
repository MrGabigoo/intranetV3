<?php

namespace App\Controller\administration\stage;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StagePeriodeSoutenanceController
 * @package App\Controller\administration\stage
 * @Route({"fr":"administration/stage/periode/soutenance",
 *         "en":"administration/stage/period/soutenance"})
 */
class StagePeriodeSoutenanceController extends BaseController
{
    /**
     * @Route("/", name="administration_stage_periode_soutenance_index")
     */
    public function index(): Response
    {
        return $this->render('administration/stage/stage_periode_soutenance/index.html.twig', [
            'controller_name' => 'StagePeriodeSoutenanceController',
        ]);
    }
}
