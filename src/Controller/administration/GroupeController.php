<?php

namespace App\Controller\administration;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class GroupeController
 * @package App\Controller\administration
 * @Route("/{_locale}/administration/groupe",
 *     requirements={
 *         "_locale": "fr|en"})
 */
class GroupeController extends Controller
{
    /**
     * @Route("/", name="administration_groupe_index")
     */
    public function index(): Response
    {
        return $this->render('administration/groupe/index.html.twig', [
        ]);
    }
}