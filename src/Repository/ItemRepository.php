<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function save(Item $object): void
    {
        $this->getEntityManager()
            ->persist($object)
        ;
        $this->getEntityManager()
            ->flush()
        ;
    }

    /**
     * @return array<Item>
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('item')
            ->orderBy('item.createdAt', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

    public function findOneById(string $id): ?Item
    {
        return $this->findOneBy([
            'id' => $id,
        ]);
    }

    public function remove(Item $item): void
    {
        $this->getEntityManager()
            ->remove($item)
        ;
        $this->getEntityManager()
            ->flush()
        ;
    }
}
