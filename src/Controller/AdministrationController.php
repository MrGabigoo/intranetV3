<?php

namespace App\Controller;

use App\Repository\StagePeriodeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdministrationController
 * @package App\Controller
 * @Route("/{_locale}/administration",
 *     requirements={
 *         "_locale": "fr|en"})
 *
 */
class AdministrationController extends BaseController
{
    /**
     * @Route("/", name="administration_index")
     */
    public function index(StagePeriodeRepository $stagePeriodeRepository) :Response
    {
        return $this->render('administration/index.html.twig',
            ['periodes' => $stagePeriodeRepository->findByFormation($this->dataUserSession->getFormation(), $this->dataUserSession->getAnneeUniversitaire())]);
    }
}
