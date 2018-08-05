<?php

namespace App\Controller\appEtudiant;

use App\Controller\BaseController;
use App\Entity\Absence;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AbsenceController
 * @package App\Controller
 * @Route({"fr":"application/etudiant/absence",
 *         "en":"application/student/missing"}
 *)
 */
class AbsenceController extends BaseController
{
    /**
     *
     * @Route("/details/{uuid}", name="app_etudiant_absence_detail")
     * @param Absence $absence
     * @ParamConverter("absence", options={"mapping": {"uuid": "uuid"}})
     * @return Response
     */
    public function details(Absence $absence): Response
    {

        return $this->render('appEtudiant/absence/detail.html.twig', [
            'absence' => $absence
        ]);
    }

    /**
     *
     * @Route("/justificatif/depot", name="app_etudiant_absence_justificatif_depot")
     * @return Response
     */
    public function justificatifDepot()
    {

    }

    /**
     *
     * @Route("/justificatif/depot", name="app_etudiant_absence_justificatif_etat")
     * @return Response
     */
    public function justificatifEtat()
    {
        //return $this->render('app')
    }
}
