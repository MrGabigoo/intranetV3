<?php
/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 12/07/2018
 * Time: 13:10
 */

namespace App\MesClasses;

use App\Entity\Constantes;
use App\Entity\Etudiant;
use App\Entity\Groupe;
use App\Entity\Matiere;
use App\MesClasses\Excel\MyExcelWriter;
use App\Repository\TypeGroupeRepository;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\KernelInterface;

class MyExportListing
{
    protected $colonnesEnTete = [];

    /** @var TypeGroupeRepository */
    protected $typeGroupeRepository;

    private $name = 'test';

    protected $groupes;

    private $ligne = 1;

    private $colonne = 1;

    private $exportTypeDocument;
    private $exportFormat;
    private $exportChamps;
    private $exportFiltre;
    /** @var Matiere */
    private $matiere;

    /** @var DataUserSession */
    private $dataUserSession;
    private $base;

    /**
     * MyExport constructor.
     *
     * @param TypeGroupeRepository $typeGroupeRepository
     * @param DataUserSession      $dataUserSession
     * @param KernelInterface      $kernel
     */
    public function __construct(
        TypeGroupeRepository $typeGroupeRepository,
        DataUserSession $dataUserSession,
        KernelInterface $kernel
) {
        $this->typeGroupeRepository = $typeGroupeRepository;
        $this->dataUserSession = $dataUserSession;
        $this->base = $kernel->getRootDir() . '/../';
    }


    public function genereFichier($exportTypeDocument, $exportFormat, $exportChamps, $exportFiltre, Matiere $matiere): ?StreamedResponse
    {
        $this->exportTypeDocument = $exportTypeDocument;
        $this->exportFormat = $exportFormat;
        $this->exportChamps = $exportChamps;
        $this->exportFiltre = $exportFiltre;
        $this->matiere = $matiere;

        $tg = $this->typeGroupeRepository->find($exportFiltre);
        if ($tg !== null) {
            $this->groupes = $tg->getGroupes();

            $this->prepareColonnes();

            switch ($exportFormat) {
                case Constantes::FORMAT_CSV_POINT_VIRGULE:
                    return $this->exportCsv(';');
                    break;
                case Constantes::FORMAT_CSV_VIRGULE:
                    return $this->exportCsv(',');
                    break;
                case Constantes::FORMAT_EXCEL:
                    return $this->exportExcel();
                    break;
                case Constantes::FORMAT_PDF:
                    return $this->exportPdf();
                    break;
            }
        }

        return false;
    }

    private function prepareColonnes(): void
    {
        $this->colonnesEnTete[] = '#';
        $this->colonnesEnTete[] = 'Nom';
        $this->colonnesEnTete[] = 'Prénom';

        foreach ($this->exportChamps as $ec) {
            $this->colonnesEnTete[] = $ec;
        }

        switch ($this->exportTypeDocument) {
            case Constantes::TYPEDOCUMENT_EMARGEMENT:
                $this->titre = 'FEUILLE D\'EMARGEMENT - Semestre ' . $this->matiere->getUe()->getSemestre()->getLibelle();
                for ($i = 0; $i < 5; $i++) {
                    $this->colonnesEnTete[] = '';
                }
                break;
            case Constantes::TYPEDOCUMENT_EVALUATION:
                $this->titre = 'FEUILLE D\'EVALUATION - Semestre ' . $this->matiere->getUe()->getSemestre()->getLibelle();

                $this->colonnesEnTete[] = 'Place';
                $this->colonnesEnTete[] = 'Présence';
                $this->colonnesEnTete[] = 'Note';
                $this->colonnesEnTete[] = 'Remise Copie';
                break;
            case Constantes::TYPEDOCUMENT_LISTE:
                $this->titre = 'LISTING - Semestre ' . $this->matiere->getUe()->getSemestre()->getLibelle();

                break;
        }
    }

    private function exportCsv($separateur): StreamedResponse
    {
        $writer = new Csv(MyExcelWriter::getSpreadsheet());

        return new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type'        => 'application/csv',
                'Content-Disposition' => 'attachment;filename="' . $this->name . '.csv"'
            ]
        );
    }

    /**
     * @return StreamedResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function exportExcel(): StreamedResponse
    {
        /** @var Groupe $groupe */
        foreach ($this->groupes as $groupe) {
            MyExcelWriter::createSheet($groupe->getLibelle());
            $this->writeSpecialHeader($groupe);
            MyExcelWriter::writeHeader($this->colonnesEnTete, 1, 15);
            $this->newLine();

            $id = 0;
            /** @var Etudiant $etudiant */
            foreach ($groupe->getEtudiants() as $etudiant) {
                $id++;
                MyExcelWriter::writeCellXY($this->colonne, $this->ligne, $id);
                $this->newColonne();
                MyExcelWriter::writeCellXY($this->colonne, $this->ligne, strtoupper($etudiant->getNom()));
                $this->newColonne();
                MyExcelWriter::writeCellXY($this->colonne, $this->ligne, strtoupper($etudiant->getPrenom()));
                $this->newLine();
            }

            MyExcelWriter::writeCellName('A11', $id);

            MyExcelWriter::borderCells('A12:H' . (string)$this->ligne);

            MyExcelWriter::getColumnDimension('A', 3);
            MyExcelWriter::getColumnAutoSize('B');
            MyExcelWriter::getColumnAutoSize('C');
            MyExcelWriter::getColumnDimension('E', 15);
            MyExcelWriter::getColumnDimension('F', 15);
            MyExcelWriter::getColumnDimension('G', 15);

            $this->setMiseEnPage();
        }

        $writer = new Xlsx(MyExcelWriter::getSpreadsheet());

        return new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="' . $this->name . '.xlsx"'
            ]
        );
    }

    private function newColonne(): void
    {
        $this->colonne++;
    }

    private function newLine(): void
    {
        $this->ligne++;
        $this->colonne = 1;
    }

    private function exportPdf(): void
    {
        return null;
    }

    /**
     * @param Groupe $groupe
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function writeSpecialHeader(Groupe $groupe): void
    {
        $dbt = $this->dataUserSession->getAnneeUniversitaire();
        $fin = $dbt + 1;

        MyExcelWriter::writeCellName('H1', 'Année Universitaire - ' . $dbt . ' - ' . $fin, ['style' => ['HORIZONTAL_RIGHT']]);
        MyExcelWriter::writeCellName('H2', 'IUT de Troyes - ' . $this->dataUserSession->getFormation()->getLibelle(), ['style' => ['HORIZONTAL_RIGHT']]);
        MyExcelWriter::writeCellName('H4', $this->titre, ['style' => ['HORIZONTAL_RIGHT']]);

        $base = $this->base . 'public/upload/';

        //todo: dans le writer ?
        $objDrawing = new Drawing();
        $objDrawing->setName('Logo Formation');
        $objDrawing->setDescription('Logo Formation');
        $objDrawing->setPath($base . 'logo/' . $this->dataUserSession->getFormation()->getLogoName());
        $objDrawing->setHeight(120);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet(MyExcelWriter::getSheet());

        switch ($this->exportTypeDocument) {
            case Constantes::TYPEDOCUMENT_EMARGEMENT:

                break;
            case Constantes::TYPEDOCUMENT_EVALUATION:
                MyExcelWriter::writeCellName(
                    'H5',
                    'Date de l\'évaluation : .......................................',
                    ['style' => ['HORIZONTAL_RIGHT']]
                );
                MyExcelWriter::writeCellName('A8', 'NOM DE L\'ENSEIGNANT :');
                MyExcelWriter::mergeCells('A8:C8');

                MyExcelWriter::writeCellName('A9', 'SURVEILLANT :');
                MyExcelWriter::mergeCells('A9:C9');

                MyExcelWriter::writeCellName('A10', 'MATIERE EVALUEE :');
                MyExcelWriter::writeCellName('D10', $this->matiere->getLibelle());

                MyExcelWriter::mergeCells('A10:C10');

                MyExcelWriter::mergeCells('B14:C14');
                MyExcelWriter::writeCellName('B14', 'Groupe ' . $groupe->getLibelle(), ['style' => ['HORIZONTAL_RIGHT']]);
                break;
            case Constantes::TYPEDOCUMENT_LISTE:

                break;
        }
    }

    private function setMiseEnPage(): void
    {
        MyExcelWriter::getSheet()->getHeaderFooter()->setOddHeader('&C&H' . $this->titre);
        MyExcelWriter::getSheet()->getHeaderFooter()->setOddFooter('&L&BDépartement | ' . $this->name . ' | Généré depuis l\'intranet le ' . date('d/m/Y') . '&RPage &P sur &N');
        MyExcelWriter::getSheet()->getPageSetup()->setFitToPage(true);
    }
}
