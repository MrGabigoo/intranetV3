<?php

namespace App\Controller\superAdministration;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ScolariteController
 * @package App\Controller\superAdministration
 */
class ScolariteController extends BaseController
{
    /**
     * @Route("/scolarite", name="sa_scolarite_index")
     */
    public function index(): Response
    {
        return $this->render('super-administration/scolarite/index.html.twig', [
            'controller_name' => 'ScolariteController',
        ]);
    }
}
