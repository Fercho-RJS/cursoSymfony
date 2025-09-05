<?php

namespace App\Repository;

use App\Entity\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evento>
 *
 * @method Evento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evento[]    findAll()
 * @method Evento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evento::class);
    }


    public function queryInscriptosAlfabeticamente()
    {
        $em = $this->getEntityManager();

        $dql = "
        SELECT e, u
        FROM App\Entity\Evento e
        JOIN e.usuarios u
        ORDER BY e.titulo ASC
    ";

        return $em->createQuery($dql);
    }

    public function findInscriptosAlfabeticamente()
    {
        return $this->queryInscriptosAlfabeticamente()->getResult();
    }

    // Función personalizada que hace una consulta DQL para traer los eventos ordenados alfabéticamente - 19/08/2025
    public function queryEventosAlfabeticamente()
    {
        $em = $this->getEntityManager();
        //En repositori extiende de otro lugar; cuando creo en Controller, AbstractController usa getDoctrine y GetManager.
        //Desde repository, utiliza otras librerías, por eso solo usa getEntityManager solamente.

        $dql = "SELECT e, d FROM App\Entity\Evento e JOIN e.disertante d ORDER BY e.titulo ASC"; //1.61ms
        // $dql = "SELECT e FROM App\Entity\Evento e ORDER BY e.titulo ASC"; //3.24ms
        return $em->createQuery($dql);
    }

    public function findEventosAlfabeticamente()
    {
        return $this->queryEventosAlfabeticamente()->getResult(); //Con getResult obtenemos el resultado de la consulta.
    }


    public function add(Evento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //Creación de la función para encontrar un evento a partir del slug del evento.
    public function findEventoPorSlug($value): ?Evento
    {
        return $this->getEntityManager()->createQuery('SELECT e, d FROM App\Entity\Evento e JOIN e.disertante d WHERE e.slug = :val')
            ->setParameter('val', $value)
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Evento[] Returns an array of Evento objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Evento
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
