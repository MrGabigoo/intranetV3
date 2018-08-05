<?php

namespace App\Repository;

use App\Entity\AbsenceJustificatif;
use App\Entity\Etudiant;
use App\Entity\Semestre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AbsenceJustificatif|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbsenceJustificatif|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbsenceJustificatif[]    findAll()
 * @method AbsenceJustificatif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbsenceJustificatifRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AbsenceJustificatif::class);
    }

    public function findBySemestre(Semestre $semestre, $annee)
    {
        return $this->createQueryBuilder('j')
            ->innerJoin(Etudiant::class, 'e', 'WITH', 'j.etudiant = e.id')
            ->where('e.semestre = :semestre')
            ->andWhere('j.anneeUniversitaire = :annee')
            ->setParameter('semestre', $semestre->getId())
            ->setParameter('annee', $annee)
            ->orderBy('j.created', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return AbsenceJustificatif[] Returns an array of AbsenceJustificatif objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AbsenceJustificatif
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
