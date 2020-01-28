<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ShopUserInterface;

class ProductSeenLogRepository extends EntityRepository implements ProductSeenLogRepositoryInterface
{
    public function findLastSeenByCookie(string $cookie, int $records): array
    {
        return $this->createQueryBuilder('psl')
            ->where('psl.cookie = :cookie')
            ->setParameter(':cookie', $cookie)
            ->orderBy('psl.createdAt', 'DESC')
            ->setMaxResults($records)
            ->getQuery()
            ->getResult();
    }

    public function findLastSeenByShopUser(ShopUserInterface $user, string $cookie, int $records): array
    {
        return $this->createQueryBuilder('psl')
            ->where('psl.cookie = :cookie')
            ->orWhere('psl.shopUser = :user')
            ->setParameters([
                    ':user' => $user,
                    'cookie' => $cookie
                ]
            )
            ->orderBy('psl.createdAt', 'DESC')
            ->setMaxResults($records)
            ->getQuery()
            ->getResult();
    }
}