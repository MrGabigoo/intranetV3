<?php

namespace App\Controller\administration;

use App\Controller\BaseController;
use App\Repository\MatiereRepository;
use App\Repository\PersonnelRepository;
use App\Repository\SalleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EdtController
 * @package App\Controller\administration
 * @Route({"fr":"administration/emploi-du-temps",
 *         "en":"administration/timetable"}
 *)
 */
class EdtController extends BaseController
{
    /**
     * @Route("/", name="administration_edt_index")
     * @param PersonnelRepository $personnelRepository
     * @param MatiereRepository   $matiereRepository
     * @param SalleRepository     $salleRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PersonnelRepository $personnelRepository, MatiereRepository $matiereRepository, SalleRepository $salleRepository): Response
    {
        return $this->render('administration/edt/index.html.twig', [
            'personnels' => $personnelRepository->findByFormation($this->dataUserSession->getFormation()),
            'salles' => $salleRepository->findAll(),
            'matieres' => $matiereRepository->findByFormation($this->dataUserSession->getFormation())
        ]);
    }
}
