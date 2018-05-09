<?php

namespace App\Controller\api;

use App\Controller\BaseController;
use App\Entity\Etudiant;
use App\Entity\PersonnelFormation;
use App\Entity\Semestre;
use App\MesClasses\DataUserSession;
use App\Repository\EtudiantRepository;
use App\Repository\PersonnelFormationRepository;
use App\Repository\PersonnelRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AgendaController
 * @package App\Controller
 * @Route("/api/etudiant")
 */
class EtudiantApiController extends BaseController
{
    /** @var EtudiantRepository */
    protected $etudiantRepository;

    /**
     * EtudiantApiController constructor.
     *
     * @param EtudiantRepository $etudiantRepository
     */
    public function __construct(EtudiantRepository $etudiantRepository)
    {
        $this->etudiantRepository = $etudiantRepository;
    }

    /**
     * @Route("/semestre/{semestre}", name="api_etudiants_semestre", options={"expose":true})
     * @param Semestre $semestre
     *
     * @return JsonResponse
     */
    public function trombinoscopeEtudiantsAjax(Semestre $semestre): JsonResponse
    {
        $etudiants = $this->etudiantRepository->findBySemestre($semestre->getId());

        $etus = array();
        /** @var Etudiant $p */
        foreach ($etudiants as $p) {
            $t['nom'] = $p->getNom();
            $t['prenom'] = $p->getPrenom();
            $t['slug'] = $p->getSlug();
            $t['siteperso'] = $p->getSitePerso();
            $t['siteuniv'] = $p->getSiteUniv();
            $t['mailUniv'] = $p->getMailUniv();
            $etus[] = $t;
        }

        return new JsonResponse($etus);
    }

    /**
     * @param DataUserSession $dataUserSession
     * @param Request         $request
     *
     * @return Response
     * @Route("/formation", name="api_etudiant_formation", options={"expose":true})
     * @throws \InvalidArgumentException
     */
    public function getEtudiantsByFormation(DataUserSession $dataUserSession, Request $request): Response
    {
        $length = $request->get('length');
        $length = $length && ($length !== -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start !== -1) ? $start : 0) / $length : 0;

        $search = $request->get('search');
        $filters = [
            'query' => $search['value']
        ];

        $users = $this->etudiantRepository->getArrayEtudiantsByFormation(
            $dataUserSession->getFormation()->getId(), $filters, $start, $length
        );

        $output = [
            'draw'            => 1,
            'data'            => $users,
            'recordsFiltered' => \count($this->etudiantRepository->getEtudiantsByFormation($dataUserSession->getFormation()->getId(),
                $filters, 0, false)),
            'recordsTotal'    => \count($this->etudiantRepository->getEtudiantsByFormation($dataUserSession->getFormation()->getId(),
                [], 0, false))
        ];

        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);

    }
}