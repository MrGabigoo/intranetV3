<?php
/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 18/04/2018
 * Time: 08:15
 */

namespace App\MesClasses;

use App\Entity\Formation;
use App\Entity\Hrs;
use App\Entity\Matiere;
use App\Entity\Personnel;
use App\Entity\Previsionnel;
use App\Entity\Semestre;
use App\MesClasses\Excel\MyExcelWriter;
use App\Repository\HrsRepository;
use App\Repository\PrevisionnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class MyPrevisionnel
 * @package App\MesClasses
 */
class MyPrevisionnel
{
    /** @var Personnel */
    private $personnel;

    private $previsionnelRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var HrsRepository */
    private $hrsRepository;

    /**
     * @var Previsionnel[]
     */
    private $servicePrevisionnelBySemestre;

    /** @var Hrs[] */
    private $hrs;

    private $ligne = 0;

    /**
     * @var Semestre[]
     */
    private $semestres = array();

    private $totalCm = 0.0;
    private $totalTd = 0.0;
    private $totalTp = 0.0;
    private $totalEtuCm = 0.0;
    private $totalEtuTd = 0.0;
    private $totalEtuTp = 0.0;
    private $totalHrs = 0.0;

    /** @var Matiere */
    private $matiere;

    /** @var Semestre */
    private $semestre;

    /** @var Previsionnel[] */
    private $previsionnels;

    /**
     * MyPrevisionnel constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param PrevisionnelRepository $previsionnelRepository
     * @param HrsRepository          $hrsRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        PrevisionnelRepository $previsionnelRepository,
        HrsRepository $hrsRepository
    ) {
        $this->previsionnelRepository = $previsionnelRepository;
        $this->hrsRepository = $hrsRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Semestre
     */
    public function getSemestre(): Semestre
    {
        return $this->semestre;
    }


    /**
     * @return Matiere
     */
    public function getMatiere(): Matiere
    {
        return $this->matiere;
    }

    /**
     * @return Previsionnel[]
     */
    public function getPrevisionnels(): array
    {
        return $this->previsionnels;
    }

    /**
     * @return Semestre[]
     */
    public function getSemestres(): array
    {
        return $this->semestres;
    }

    /**
     * @return Previsionnel[]
     */
    public function getServicePrevisionnelBySemestre(): array
    {
        return $this->servicePrevisionnelBySemestre;
    }

    /**
     * @return float
     */
    public function getTotalCm(): float
    {
        return $this->totalCm;
    }

    /**
     * @return float
     */
    public function getTotalTd(): float
    {
        return $this->totalTd;
    }

    /**
     * @return float
     */
    public function getTotalTp(): float
    {
        return $this->totalTp;
    }

    /**
     * @return float
     */
    public function getTotalEtu(): float
    {
        return $this->totalEtuCm + $this->totalEtuTd + $this->totalEtuTp;
    }

    /**
     * @return Hrs[]
     */
    public function getHrs(): array
    {
        return $this->hrs;
    }

    /**
     * @return Personnel
     */
    public function getPersonnel(): Personnel
    {
        return $this->personnel;
    }

    /**
     * @param Personnel $personnel
     */
    public function setPersonnel(Personnel $personnel): void
    {
        $this->personnel = $personnel;
    }

    /**
     * @return float
     */
    public function getTotalEtuCm(): float
    {
        return $this->totalEtuCm;
    }

    /**
     * @return float
     */
    public function getTotalEtuTd(): float
    {
        return $this->totalEtuTd;
    }

    /**
     * @return float
     */
    public function getTotalEtuTp(): float
    {
        return $this->totalEtuTp;
    }

    /**
     * @return float
     */
    public function getTotalHrs(): float
    {
        return $this->totalHrs;
    }

    /**
     * @return float
     */
    public function getNbHeuresComplementaires(): float
    {
        $tot = $this->getTotalService() - $this->personnel->getNbHeuresService();

        return $tot < 0 ? 0 : $tot;
    }

    /**
     * @return float
     */
    public function getTotalService(): float
    {
        return $this->totalCm + $this->totalTd + $this->totalTp;
    }

    /**
     * @return float
     */
    public function getTotalHrsService(): float
    {
        return $this->totalHrs + $this->getTotalService();
    }

    /**
     * @param Personnel $personnel
     * @param Formation $formation
     *
     * @return mixed
     */
    public function getPrevisionnelEnseignantFormation(
        Personnel $personnel,
        Formation $formation
    ) {
        return $this->previsionnelRepository->findPrevisionnelEnseignantFormation($personnel, $formation);
    }

    /**
     * @param Personnel $personnel
     * @param           $annee
     *
     * @return array
     */
    public function getPrevisionnelEnseignantComplet(Personnel $personnel, $annee): array
    {
        return $this->previsionnelRepository->findPrevisionnelEnseignantComplet($personnel, $annee);
    }

    /**
     * @param $annee
     *
     */
    public function getPrevisionnelEnseignantBySemestre($annee): void
    {
        $previsionnels = $this->previsionnelRepository->findPrevisionnelEnseignantComplet($this->personnel, $annee);

        $tprev = array();
        /** @var Previsionnel $pr */
        foreach ($previsionnels as $pr) {
            $sem = $pr->getSemestre() ? $pr->getSemestre()->getId() : null;

            if ($sem !== null) {
                if (!array_key_exists($sem, $tprev)) {
                    $tprev[$sem] = array();
                    $this->semestres[] = $pr->getSemestre();
                }
                $tprev[$sem][] = $pr;
                $this->totalCm += $pr->getTotalHCm();
                $this->totalTd += $pr->getTotalHTd();
                $this->totalTp += $pr->getTotalHTp();
            }
        }

        $this->servicePrevisionnelBySemestre = $tprev;
    }

    /**
     * @param $annee
     */
    public function getHrsEnseignant($annee): void
    {
        $this->hrs = $this->hrsRepository->findHrsEnseignant($this->personnel, $annee);

        foreach ($this->hrs as $hr) {
            $this->totalHrs += $hr->getNbHeuresTd();
        }
    }

    /**
     * @param Matiere $matiere
     * @param         $annee
     */
    public function getPrevisionnelMatiere(Matiere $matiere, $annee): void
    {
        $this->matiere = $matiere;
        $this->previsionnels = $this->previsionnelRepository->findPrevisionnelMatiere($matiere, $annee);

        /** @var Previsionnel $previ */
        foreach ($this->previsionnels as $previ) {
            $this->totalCm += $previ->getTotalHCm();
            $this->totalTp += $previ->getTotalHTp();
            $this->totalTd += $previ->getTotalHTd();

            $this->totalEtuCm += $previ->getNbHCm();
            $this->totalEtuTd += $previ->getNbHTd();
            $this->totalEtuTp += $previ->getNbHTp();
        }
    }

    /**
     * @param Semestre $semestre
     * @param          $annee
     */
    public function getPrevisionnelSemestre(Semestre $semestre, $annee): void
    {
        $this->semestre = $semestre;
        $this->previsionnels = $this->previsionnelRepository->findPrevisionnelSemestre($semestre, $annee);

        /** @var Previsionnel $previ */
        foreach ($this->previsionnels as $previ) {
            $this->totalCm += $previ->getTotalHCm();
            $this->totalTp += $previ->getTotalHTp();
            $this->totalTd += $previ->getTotalHTd();

            $this->totalEtuCm += $previ->getNbHCm();
            $this->totalEtuTd += $previ->getNbHTd();
            $this->totalEtuTp += $previ->getNbHTp();
        }
    }

    public function update($id, $name, $value): bool
    {
        $previ = $this->previsionnelRepository->find($id);
        if ($previ) {
            $method = 'set' . $name;
            if (method_exists($previ, $method)) {
                $previ->$method($value);
                $this->entityManager->persist($previ);
                $this->entityManager->flush();

                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * @param Formation $formation
     * @param int       $anneePrevisionnel
     *
     * @return StreamedResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function exportOmegaFormation(Formation $formation, int $anneePrevisionnel)
    {
        $previsionnels = $this->previsionnelRepository->findPrevisionnelFormation($formation, $anneePrevisionnel);
        $hrs = $this->hrsRepository->findHrsFormation($formation, $anneePrevisionnel);

        MyExcelWriter::createSheet('omega');
        MyExcelWriter::writeHeader([
            'CODE VET',
            'LIBELLE VET',
            'CODE ELEMENT*',
            'LIBELLE ELEMENT',
            'CODE HARPEGE*',
            'NOM PRENOM',
            'H CM PREVU*',
            'GP CM PREVU*',
            'H TD PREVU*',
            'GP TD PREVU*',
            'H TP PREVU*',
            'GP TP PREVU*'
        ]);
        $this->ligne = 2;
        $this->ecritPrevisionnel($previsionnels);
        $this->ecritHRS($hrs);

        $writer = new Xlsx(MyExcelWriter::getSpreadsheet());

        return new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="export-omega'.$formation->getLibelle().'.xlsx"'
            ]
        );
    }

    private function ecritPrevisionnel($previsionnels)
    {
        /** @var Previsionnel $previ */
        foreach ($previsionnels as $previ) {
            $colonne = 0;
            if ($previ->getMatiere() !== null) {
                if ($previ->getMatiere()->getSemestre() !== null && $previ->getMatiere()->getSemestre()->getAnnee() !== null) {
                    //CODE VET
                    MyExcelWriter::writeCellXY($colonne, $this->ligne,
                        $previ->getMatiere()->getSemestre()->getAnnee()->getCodeApogee());
                    $colonne++;
                    //LIBELLE VET
                    MyExcelWriter::writeCellXY($colonne, $this->ligne,
                        $previ->getMatiere()->getSemestre()->getAnnee()->getLibelleLong());
                } else {
                    MyExcelWriter::writeCellXY($colonne, $this->ligne,
                        'ERR');
                    $colonne++;
                    //LIBELLE VET
                    MyExcelWriter::writeCellXY($colonne, $this->ligne,
                        'ERR');
                }
                $colonne++;
                //CODE ELEMENT*
                MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getMatiere()->getCodeApogee());
                $colonne++;
                //LIBELLE ELEMENT
                MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getMatiere()->getLibelle());
                $colonne++;
            } else {
                MyExcelWriter::writeCellXY($colonne, $this->ligne,
                    'ERR');
                $colonne++;
                //LIBELLE VET
                MyExcelWriter::writeCellXY($colonne, $this->ligne,
                    'ERR');
                $colonne++;
                //CODE ELEMENT*
                MyExcelWriter::writeCellXY($colonne, 'ERR');
                $colonne++;
                //LIBELLE ELEMENT
                MyExcelWriter::writeCellXY($colonne, 'ERR');
                $colonne++;
            }

            if ($previ->getPersonnel() !== null) {
                //CODE HARPEGE*
                MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getPersonnel()->getNumeroHarpege());
                $colonne++;
                //NOM PRENOM
                MyExcelWriter::writeCellXY($colonne, $this->ligne,
                    strtoupper($previ->getPersonnel()->getNom()) . ' ' . strtoupper($previ->getPersonnel()->getPrenom()));
            } else {
                MyExcelWriter::writeCellXY($colonne, $this->ligne, 'ERR-XXX');
                $colonne++;
                MyExcelWriter::writeCellXY($colonne, $this->ligne,
                    'ERR-XXX');
            }
            $colonne++;
            //H CM PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getNbHCm());
            $colonne++;
            //GP CM PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getNbGrCm());
            $colonne++;
            // H TD PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getNbHTd());
            $colonne++;
            //GP TD PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getNbGrTd());
            $colonne++;
            //H TP PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getNbHTp());
            $colonne++;
            //GP TP PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getNbGrTp());
            $this->ligne++;
        }
    }

    private function ecritHRS($hrs)
    {

        /** @var Hrs $previ */
        foreach ($hrs as $previ) {
            $colonne = 0;
            //CODE VET
            if ($previ->getSemestre() !== null && $previ->getSemestre()->getAnnee() !== null) {
                MyExcelWriter::writeCellXY($colonne, $this->ligne,
                    $previ->getSemestre()->getAnnee()->getCodeApogee());
                $colonne++;
                MyExcelWriter::writeCellXY($colonne, $this->ligne,
                    $previ->getSemestre()->getAnnee()->getLibelleLong());
            } else {
                MyExcelWriter::writeCellXY($colonne, $this->ligne, '');
                $colonne++;
                MyExcelWriter::writeCellXY($colonne, $this->ligne, '');
            }
//LIBELLE VET
            $colonne++;
//CODE ELEMENT*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getTypeHrs());
            $colonne++;
//LIBELLE ELEMENT
            if ($previ->getTypeHrs() !== null) {
                MyExcelWriter::writeCellXY($colonne, $this->ligne,
                    $previ->getTypeHrs()->getLibelle() . ' ' . $previ->getLibelle());
            } else {
                MyExcelWriter::writeCellXY($colonne, $this->ligne,
                    'ERR');
            }
            $colonne++;

            if ($previ->getPersonnel() !== null) {
                //CODE HARPEGE*
                MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getPersonnel()->getNumeroHarpege());
                $colonne++;
                //NOM PRENOM
                MyExcelWriter::writeCellXY($colonne, $this->ligne,
                    strtoupper($previ->getPersonnel()->getNom()) . ' ' . strtoupper($previ->getPersonnel()->getPrenom()));
            } else {
                MyExcelWriter::writeCellXY($colonne, $this->ligne, 'ERR-XXX');
                $colonne++;
                MyExcelWriter::writeCellXY($colonne, $this->ligne,
                    'ERR-XXX');
            }
//H CM PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, 0);
            $colonne++;
//GP CM PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, 1);
            $colonne++;
// H TD PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, $previ->getNbHeuresTd());
            $colonne++;
//GP TD PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, 1);
            $colonne++;
//H TP PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, 0);
            $colonne++;
//GP TP PREVU*
            MyExcelWriter::writeCellXY($colonne, $this->ligne, 1);
            $this->ligne++;
        }
    }
}
