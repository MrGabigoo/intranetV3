<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AgendaController
 * @package App\Controller
 * @Route({"fr":"agenda",
 *         "en":"calendar"})
 */
class AgendaController extends BaseController
{
    /**
     * @Route("/", name="agenda_index")
     */
    public function index(): Response
    {
        return $this->render('agenda/index.html.twig', [
        ]);
    }
}
