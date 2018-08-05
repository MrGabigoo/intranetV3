<?php

namespace App\Controller\administration\stage;

use App\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StagePeriodeOffreController
 * @package App\Controller\administration\stage
 * @Route({"fr":"administration/stage/periode/offre",
 *         "en":"administration/stage/period/offer"})
 */
class StagePeriodeOffreController extends BaseController
{
    /**
     * @Route("/", name="administration_stage_periode_offre_index")
     */
    public function index()
    {
        return $this->render('administration/stage/stage_periode_offre/index.html.twig', [
            'controller_name' => 'StagePeriodeOffreController',
        ]);
    }
}
