<?php namespace App\Repository;

use App\Entity\Consulta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consulta>
 */
class ConsultaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consulta::class);
    }

    // Ejemplo de método personalizado
    public function findRecientes(int $limite = 10): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.fecha', 'DESC')
            ->setMaxResults($limite)
            ->getQuery()
            ->getResult();
    }
}