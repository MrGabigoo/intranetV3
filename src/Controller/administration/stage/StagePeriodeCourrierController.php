<?php

namespace App\Controller\administration\stage;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StagePeriodeCourrierController
 * @package App\Controller\administration\stage
 * @Route({"fr":"administration/stage/periode/courrier",
 *         "en":"administration/stage/period/courrier"})
 */
class StagePeriodeCourrierController extends BaseController
{
    /**
     * @Route("/", name="administration_stage_periode_courrier_index")
     */
    public function index(): Response
    {
        return $this->render('administration/stage/stage_periode_courrier/index.html.twig', [
            'controller_name' => 'StagePeriodeCourrierController',
        ]);
    }
}
