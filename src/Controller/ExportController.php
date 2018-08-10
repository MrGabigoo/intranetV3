<?php

namespace App\Controller;

use App\MesClasses\MyExportListing;
use App\Repository\MatiereRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ExportController
 * @package App\Controller
 * @Route({"fr":"/export", "en":"/exported"})
 */
class ExportController extends Controller
{
    /**
     * @Route("/listing", name="export_listing")
     * @param MatiereRepository $matiereRepository
     * @param MyExportListing   $myExport
     * @param Request           $request
     *
     * @return bool|null|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function listing(MatiereRepository $matiereRepository, MyExportListing $myExport, Request $request)
    {
        $matiere = $request->request->get('matiere');
        if ($matiere !== 0) {
            $matiere = $matiereRepository->find($matiere);
        }

        $exportTypeDocument = $request->request->get('exportTypeDocument');
        $exportChamps = $request->request->get('exportChamps');
        $exportFormat = $request->request->get('exportFormat');
        $exportFiltre = $request->request->get('exportFiltre');

        return $myExport->genereFichier($exportTypeDocument, $exportFormat, $exportChamps, $exportFiltre, $matiere);
    }
}
