<?php

namespace App\Controller\administration;

use App\Controller\BaseController;
use App\MesClasses\MyExport;
use App\MesClasses\MyStructure;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StructureController
 * @package App\Controller\administration
 * @Route({"fr":"administration/structure",
 *         "en":"administration/organization"}
 *)
 */
class StructureController extends BaseController
{
    /**
     * @Route("/", name="administration_structure_index")
     */
    public function index()
    {
        return $this->render('structure/index.html.twig', [
            'formation' => $this->dataUserSession->getFormation()
        ]);
    }

    /**
     * @Route("/export.{_format}", name="administration_structure_export", methods="GET", requirements={"_format"="csv|xlsx|pdf"})
     * @param                   $_format
     *
     * @return Response
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function export(MyStructure $myStructure, $_format): Response
    {
        $myStructure->export($this->dataUserSession->getFormation(), $_format);
    }
}
