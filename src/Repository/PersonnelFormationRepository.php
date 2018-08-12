<?php

namespace App\Repository;

use App\Entity\Formation;
use App\Entity\Personnel;
use App\Entity\PersonnelFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PersonnelFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonnelFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonnelFormation[]    findAll()
 * @method PersonnelFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnelFormationRepository extends ServiceEntityRepository
{
    /**
     * PersonnelFormationRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PersonnelFormation::class);
    }

    /**
     * @param $type
     * @param $formation
     *
     * @return array
     */
    public function findByType($type, $formation): array
    {
        return $this->createQueryBuilder('f')
            ->innerJoin(Personnel::class, 'p', 'WITH', 'f.personnel = p.id')
            ->where('p.typeUser = :type')
            ->andWhere('f.formation = :formation')
            ->setParameter('type', $type)
            ->setParameter('formation', $formation)
            ->orderBy('p.nom', 'DESC')
            ->orderBy('p.prenom', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByPersonnel($user)
    {
        return $this->createQueryBuilder('f')
            ->innerJoin(Personnel::class, 'p', 'WITH', 'f.personnel = p.id')
            ->innerJoin(Formation::class, 'm', 'WITH', 'f.formation = m.id')
            ->where('f.personnel = :personnel')
            ->setParameter('personnel', $user)
            ->orderBy('m.libelle', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
