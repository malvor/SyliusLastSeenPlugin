<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ShopUserInterface;

class ProductSeenLogRepository extends EntityRepository implements ProductSeenLogRepositoryInterface
{
    /** {@inheritdoc} */
    public function findLastSeenByCookie(string $cookie, int $records): array
    {
        return $this->lastSeenQuery($cookie, null, $records);
    }

    /** {@inheritdoc} */
    public function findLastSeenByShopUser(ShopUserInterface $user, string $cookie, int $records): array
    {
        return $this->lastSeenQuery($cookie, $user, $records);
    }

    /**
     * @param string $cookie
     * @param null|ShopUserInterface $user
     * @param int $records
     * @return array
     */
    private function lastSeenQuery(string $cookie, ?ShopUserInterface $user, int $records): array
    {
        $queryBuilder = $this->createQueryBuilder('psl')
            ->where('psl.cookie = :cookie')
            ->setParameter(':cookie', $cookie)
            ->orderBy('psl.createdAt', 'DESC')
            ->setMaxResults($records);
        if (null !== $user) {
            $queryBuilder
                ->orWhere('psl.shopUser = :user')
                ->setParameter(':user', $user);
        }

        return $queryBuilder->getQuery()
            ->getResult();
    }
}