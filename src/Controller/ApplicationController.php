<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApplicationController
 * @package App\Controller
 * @Route({"fr":"applications",
 *         "en":"tools"})
 */
class ApplicationController extends BaseController
{
    /**
     * @Route("/{onglet}", name="application_index")
     * @param string $onglet
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($onglet = 'messagerie'): Response
    {
        return $this->render('application/index.html.twig', [
            'onglet' => $onglet
        ]);
    }
}
