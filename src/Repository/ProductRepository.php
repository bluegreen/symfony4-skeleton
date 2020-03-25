<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCountOfAvailableProduct(): int
    {
        $result = $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->where('p.available = :available')
            ->setParameter('available', true)
            ->getQuery()
            ->getSingleScalarResult();

        return intval($result);
    }

    public function getAvailableProduct(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.available = :available')
            ->setParameter('available', false)
            ->getQuery()
            ->getArrayResult();
    }

    public function getProductsByPhrase(string $phrase): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.name LIKE :name')
            ->setParameter('name', '%'.$phrase.'%')
            ->getQuery()
            ->getArrayResult();
    }
}
