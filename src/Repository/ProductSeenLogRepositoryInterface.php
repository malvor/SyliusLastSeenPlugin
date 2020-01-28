<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Repository;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface ProductSeenLogRepositoryInterface extends RepositoryInterface
{
    public function findLastSeenByCookie(string $cookie, int $records): array ;

    public function findLastSeenByShopUser(ShopUserInterface $user, string $cookie, int $records): array ;
}