<?php

namespace App\Controller\administration\stage;

use App\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StageEntrepriseController
 * @package App\Controller\administration\stage
 * @Route({"fr":"administration/stage/entreprise",
 *         "en":"administration/stage/entrepris"})
 */
class StageEntrepriseController extends BaseController
{
    /**
     * @Route("/", name="administration_stage_entreprise_index")
     */
    public function index()
    {
        return $this->render('administration/stagestage_entreprise/index.html.twig', [
            'controller_name' => 'StageEntrepriseController',
        ]);
    }
}
