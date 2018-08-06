<?php

namespace App\Repository;

use App\Entity\StageEtudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StageEtudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method StageEtudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method StageEtudiant[]    findAll()
 * @method StageEtudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageEtudiantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StageEtudiant::class);
    }

    /**
     * @param \App\Entity\StagePeriode $stagePeriode
     * @param \App\Entity\Etudiant     $etudiant
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findExist(\App\Entity\StagePeriode $stagePeriode, \App\Entity\Etudiant $etudiant)
    {
        return $this->createQueryBuilder('s')
            ->where('s.etudiant = :etudiant')
            ->andWhere('s.stagePeriode = :stagePeriode')
            ->setParameter('etudiant', $etudiant)
            ->setParameter('stagePeriode', $stagePeriode)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
