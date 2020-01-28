<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Repository;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * Interface ProductSeenLogRepositoryInterface
 * @package Websnacks\SyliusLastSeenPlugin\Repository
 */
interface ProductSeenLogRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $cookie
     * @param int $records
     * @return array
     */
    public function findLastSeenByCookie(string $cookie, int $records): array ;

    /**
     * @param ShopUserInterface $user
     * @param string $cookie
     * @param int $records
     * @return array
     */
    public function findLastSeenByShopUser(ShopUserInterface $user, string $cookie, int $records): array ;
}