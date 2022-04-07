<?php

namespace App\Repository;

use App\Entity\Gite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Expr\Value;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gite[]    findAll()
 * @method Gite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gite::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Gite $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Gite $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Gite[] Returns an array of Gite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gite
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // 1- Trouver les gites d'un dpt en excluant quelques ID (passer les dpt à chercher et les ID à exclure)

    public function findByDpt($dpt_code_a_passer, array $id_a_exclure)
    {
        
        return $this->createQueryBuilder('g')
            ->innerJoin('g.city', 'c')
            ->innerJoin('c.departmentCode', 'd')
            ->andWhere('d = :val')
            ->andWhere('c.id NOT IN (:exclu)')
            ->setParameter('val', $dpt_code_a_passer)
            ->setParameter('exclu', $id_a_exclure)
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    // 2- Trouver les gites d'une reg en excluant quelques ID (passer la region à chercher et les ID à exclure)
    public function findByReg($reg_code_a_passer, array $id_a_exclure)
    {
        
        return $this->createQueryBuilder('g')
            ->innerJoin('g.city', 'c')
            ->innerJoin('c.departmentCode', 'd')
            ->innerJoin('d.regionCode', 'r')
            ->andWhere('r = :val')
            ->andWhere('d.code NOT IN (:exclu)')
            ->setParameter('val', $reg_code_a_passer)
            ->setParameter('exclu', $id_a_exclure)
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }



}
