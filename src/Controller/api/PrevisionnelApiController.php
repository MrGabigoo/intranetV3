<?php

namespace App\Controller\api;

use App\Controller\BaseController;
use App\Entity\Constantes;
use App\Entity\Matiere;

use App\Entity\Previsionnel;
use App\Repository\PrevisionnelRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class MatiereApiController
 * @package App\Controller
 * @Route("/api/previsionnel")
 */
class PrevisionnelApiController extends BaseController
{
    /**
     * @Route("/maiere/{matiere}", name="api_previsionnel_matiere", options={"expose":true})
     * @param Matiere $matiere
     *
     * @return JsonResponse
     */
    public function previsionnelMatiereAjax(
        PrevisionnelRepository $previsionnelRepository,
        Matiere $matiere
    ): Response {
        $previsionnel = $previsionnelRepository->findPrevisionnelMatiere($matiere,
            $this->dataUserSession->getAnneePrevisionnel());

        return $this->render('api/previsionnel/matiere.html.twig',
            ['previsionnel' => $previsionnel, 'matiere' => $matiere]);
    }
}
