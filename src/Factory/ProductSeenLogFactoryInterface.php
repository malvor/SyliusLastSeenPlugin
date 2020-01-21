<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Factory;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Websnacks\SyliusLastSeenPlugin\Entity\ProductSeenLogInterface;

interface ProductSeenLogFactoryInterface extends FactoryInterface
{
    public function createForUserWithCookie(ShopUserInterface $shopUser, string $cookie): ProductSeenLogInterface;

    public function createWithCookie(string $cookie): ProductSeenLogInterface;
}