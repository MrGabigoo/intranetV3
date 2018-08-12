<?php

namespace App\Repository;

use App\Entity\Etudiant;
use App\Entity\Groupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Groupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Groupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Groupe[]    findAll()
 * @method Groupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeRepository extends ServiceEntityRepository
{
    /**
     * GroupeRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Groupe::class);
    }

    public function findEtudiantsByTypeGroupe(\App\Entity\TypeGroupe $typeGroupe)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin(Etudiant::class, 'e', 'WITH', 'g.etudiant = e.id')
            ->where('g.typeGroupe = :typeGroupe')
            ->setParameter('typeGroupe', $typeGroupe->getId())
            ->orderBy('g.libelle', 'ASC')
            ->orderBy('e.nom', 'ASC')
            ->orderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
