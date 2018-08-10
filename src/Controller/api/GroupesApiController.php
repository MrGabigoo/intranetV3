<?php

namespace App\Controller\api;

use App\Controller\BaseController;
use App\Entity\Semestre;
use App\Entity\TypeGroupe;
use App\Repository\GroupeRepository;
use App\Repository\TypeGroupeRepository;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MatiereApiController
 * @package App\Controller
 * @Route("/api/groupe")
 */
class GroupesApiController extends BaseController
{
    /** @var GroupeRepository */
    protected $groupeRepository;

    /**
     * @var TypeGroupeRepository
     */
    protected $typeGroupeRepository;

    /**
     * GroupesApiController constructor.
     *
     * @param GroupeRepository     $groupeRepository
     * @param TypeGroupeRepository $typeGroupeRepository
     */
    public function __construct(GroupeRepository $groupeRepository, TypeGroupeRepository $typeGroupeRepository)
    {
        $this->groupeRepository = $groupeRepository;
        $this->typeGroupeRepository = $typeGroupeRepository;
    }

    /**
     * @param Semestre $semestre
     * @Route("/type-groupe/{semestre}", name="api_type_groupe_semestre", options={"expose":true})
     */
    public function typeGroupeSemestreAjax(Semestre $semestre): void
    {
    }

    /**
     * @Route("/groupe/{typeGroupe}", name="api_groupe_type_groupe", options={"expose":true})
     * @param TypeGroupe $typeGroupe
     */
    public function grouepTypeGroupeAjax(TypeGroupe $typeGroupe): void
    {
    }
}
