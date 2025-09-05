<?php

namespace App\Repository;

use App\Entity\Disertante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Disertante>
 *
 * @method Disertante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Disertante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Disertante[]    findAll()
 * @method Disertante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisertanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Disertante::class);
    }

    public function add(Disertante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Disertante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findDisertantesAlfabeticamente()
    {
        return $this->getEntityManager()->createQuery('SELECT d, e FROM App\Entity\Disertante d JOIN d.eventos e ORDER BY d.nombre ASC')->getResult();
    }

    public function findDisertantesConEventosPorId($id): ?Disertante
    {
        return $this->getEntityManager()->createQuery(
            'SELECT d, e FROM App\Entity\Disertante d JOIN d.eventos e WHERE d.id = :id'
        )
            ->setParameter('id', $id)
            ->getOneOrNullResult();
    }
    //    /**
    //     * @return DisertanteClass[] Returns an array of DisertanteClass objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DisertanteClass
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
