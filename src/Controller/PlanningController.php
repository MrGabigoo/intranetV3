<?php

namespace App\Controller;

use App\MesClasses\Calendrier;
use App\Repository\DateRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlanningController
 * @package App\Controller
 * @Route({"fr":"agenda",
 *         "en":"calendar"})
 */
class PlanningController extends BaseController
{
    /**
     * @Route("/planning/{annee}", name="planning_index")
     * @param DateRepository $dateRepository
     * @param int            $annee
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(DateRepository $dateRepository, int $annee): Response
    {
        Calendrier::calculPlanning($annee);

        return $this->render('planning/index.html.twig', [
            'tabPlanning' => Calendrier::getTabPlanning(),
            'tabJour'     => array('', 'L', 'M', 'M', 'J', 'V', 'S', 'D'),
            'tabFerie'    => Calendrier::getTabJoursFeries(),
            'tabFinMois'  => Calendrier::getTabFinMois(),
            'annee'       => $annee,
            'events'      => $dateRepository->findByFormationPlanning(
                $this->dataUserSession->getFormationId(),
                $annee
            )
        ]);
    }
}
