<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCountProductByCategoryId(int $categoryId): int
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT count(p.id)
                FROM App\Entity\Product p
                INNER JOIN p.category c
                WHERE c.id = :id'
        )->setParameter('id', $categoryId);

        $result = $query->getSingleScalarResult();

        return intval($result);
    }

    public function getProductByCategoryId(int $categoryId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
                FROM App\Entity\Product p
                INNER JOIN p.category c
                WHERE c.id = :id
                ORDER BY p.name ASC'
        )->setParameter('id', $categoryId);

        return $query->getArrayResult();
    }
}
