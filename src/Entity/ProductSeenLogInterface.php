<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Entity;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ProductSeenLogInterface extends ResourceInterface
{
    public function setShopUser(ShopUserInterface $shopUser): void;

    public function getShopUser(): ?ShopUserInterface;

    public function setCookie(string $cookie): void;

    public function getCookie(): string;

    public function setProduct(ProductInterface $product): void;

    public function getProduct(): ProductInterface;
}