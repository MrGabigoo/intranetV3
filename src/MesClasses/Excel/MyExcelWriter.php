<?php
/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 15/07/2018
 * Time: 15:37
 */

namespace App\MesClasses\Excel;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\Translation\TranslatorInterface;

class MyExcelWriter
{
    /** @var Spreadsheet */
    private static $spreadsheet;

    /** @var Worksheet */
    private static $sheet;

    /** @var TranslatorInterface */
    private static $translator;

    /**
     * MyExcelWriter constructor.
     *
     * @param TranslatorInterface $translator
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function __construct(TranslatorInterface $translator)
    {
        self::$spreadsheet = new Spreadsheet();
        self::$spreadsheet->removeSheetByIndex(0);
        self::$translator = $translator;
    }

    /**
     * @return Spreadsheet
     */
    public static function getSpreadsheet(): Spreadsheet
    {
        return self::$spreadsheet;
    }

    /**
     * @return Worksheet
     */
    public static function getSheet(): Worksheet
    {
        return self::$sheet;
    }

    /**
     * @param $libelle
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function createSheet($libelle): void
    {
        self::$spreadsheet->createSheet()->setTitle($libelle);
        self::$sheet = self::$spreadsheet->getSheetByName($libelle);
    }

    /**
     * @param     $array
     * @param int $col
     * @param int $row
     */
    public static function writeHeader($array, $col = 1, $row = 1): void
    {
        foreach ($array as $value) {
            if (!empty($value) && $value !== null && $value !== '#') {
                $value = self::$translator->trans($value);
            }

            self::writeCellXY($col, $row, $value);
            $col++;
        }
    }

    /**
     * @param       $col
     * @param       $row
     * @param       $value
     * @param array $options
     */
    public static function writeCellXY($col, $row, $value, $options = []): void
    {
        self::$sheet->setCellValueByColumnAndRow($col, $row, $value);
        //traiter les options
    }

    /**
     * @param       $adresse
     * @param       $value
     * @param array $options
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function writeCellName($adresse, $value, array $options = []): void
    {
        self::$sheet->setCellValue($adresse, $value);

        if (\is_array($options) && array_key_exists('style', $options)) {
            switch ($options['style']) {
                case 'HORIZONTAL_RIGHT':
                    self::$sheet->getStyle($adresse)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    break;
                case 'HORIZONTAL_CENTER':
                    self::$sheet->getStyle($adresse)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    break;
                case 'numerique':
                    self::$sheet->getStyle($adresse)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    break;
                case 'numerique3':
                    self::$sheet->getStyle($adresse)->getNumberFormat()->setFormatCode('#,##0.000');
                    break;

            }
        }
    }

    /**
     * @param $col
     * @param $lig
     * @param $couleur
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function colorCellRange($col, $lig, $couleur): void
    {
        $cell = Coordinate::stringFromColumnIndex($col) . $lig;
        self::colorCells($cell, $couleur);
    }

    /**
     * @param $cells
     * @param $couleur
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function colorCells($cells, $couleur): void
    {
        self::$sheet->getStyle($cells)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB($couleur);
    }

    /**
     * @param $col1
     * @param $lig1
     * @param $col2
     * @param $lig2
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function borderCellsRange($col1, $lig1, $col2, $lig2): void
    {
        $cell1 = Coordinate::stringFromColumnIndex($col1) . $lig1;
        $cell2 = Coordinate::stringFromColumnIndex($col2) . $lig2;
        self::borderCells($cell1 . ':' . $cell2);
    }

    /**
     * @param $cells
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function borderCells($cells): void
    {
        self::$sheet->getStyle($cells)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }

    /**
     * @param integer $ligne
     * @param integer $taille
     */
    public static function getRowDimension($ligne, $taille): void
    {
        self::$sheet->getRowDimension($ligne)->setRowHeight($taille);
    }

    /**
     * @param string  $col
     * @param integer $taille
     */
    public static function getColumnDimension($col, $taille): void
    {
        self::$sheet->getColumnDimension($col)->setWidth($taille);
    }

    /**
     * @param $col
     */
    public static function getColumnAutoSize($col): void
    {
        if (is_numeric($col)) {
            $col = Coordinate::stringFromColumnIndex($col);
        }

        self::$sheet->getColumnDimension($col)->setAutoSize(true);
    }

    /**
     * @param $col1
     * @param $lig1
     * @param $col2
     * @param $lig2
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function mergeCellsCaR($col1, $lig1, $col2, $lig2): void
    {
        $cell1 = Coordinate::stringFromColumnIndex($col1) . $lig1;
        $cell2 = Coordinate::stringFromColumnIndex($col2) . $lig2;
        self::mergeCells($cell1 . ':' . $cell2);
    }

    /**
     * @param $cells
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function mergeCells($cells): void
    {
        self::$sheet->mergeCells($cells);
    }

    /**
     * @param string[] $tEnTete
     * @param integer  $colonne
     * @param integer  $ligne
     */
    /*public function ecritLigne($tEnTete, $colonne, $ligne)
    {
        foreach ($tEnTete as $t) {
            $this->ecritCelluleCaR($colonne, $ligne, $t);
            $colonne++;
        }
    }*/

    /**
     * @param integer $colonne
     * @param integer $ligne
     * @param         $texte
     * @param string  $style
     */
   /* public function ecritCelluleCaR($colonne, $ligne, $texte, $style = '')
    {
        $cell = PHPExcel_Cell::stringFromColumnIndex($colonne) . $ligne;
        $this->ecritCellule($cell, $texte, $style);
    }*/
}
