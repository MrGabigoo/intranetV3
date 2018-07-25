<?php

namespace App\Controller\appPersonnel;

use App\Controller\BaseController;
use App\MesClasses\MySalleExamen;
use App\Repository\PersonnelRepository;
use App\Repository\SalleExamenRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class QuizzController
 * @package App\Controller
 * @Route({"fr":"application/personnel/salle-examen",
 *         "en":"application/team/exam-room"}
 *)
 * @IsGranted("ROLE_PERMANENT")
 */
class SalleExamenController extends BaseController
{
    /**
     * @Route("/", name="application_personnel_salle_examen_index")
     */
    public function index(
        SalleExamenRepository $salleExamenRepository,
    PersonnelRepository $personnelRepository
    ): Response
    {
        return $this->render('appPersonnel/salle_examen/index.html.twig', [
            'salles' => $salleExamenRepository->findByFormation($this->dataUserSession->getFormation()),
            'personnels' => $personnelRepository->findByFormation($this->dataUserSession->getFormation())
        ]);
    }

    /**
     * @param Request $request
     *
     *
     * @return Response
     * @Route("/application/salle-examen/genere/document",
     *     name="application_personnel_salle_examen_genere_placement",
     *     methods={"POST"})
     */
    public function generePlacement(MySalleExamen $mySalleExamen, Request $request)
    {
        $mySalleExamen->genereDocument($request->request->get('dateeval'),
            $request->request->get('salle'),
            $request->request->get('selectmatiere'),
            $request->request->get('selectgroupes'),
            $request->request->get('selectgroupes'));
    }
}
