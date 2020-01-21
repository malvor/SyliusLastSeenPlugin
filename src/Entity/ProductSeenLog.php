<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Entity;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

final class ProductSeenLog implements TimestampableInterface, ProductSeenLogInterface
{
    use TimestampableTrait;

    protected $id;

    protected $cookie;

    protected $product;

    protected $shopUser;

    public function getId()
    {
        return $this->id;
    }

    public function setShopUser(ShopUserInterface $shopUser): void
    {
        $this->shopUser = $shopUser;
    }

    public function getShopUser(): ?ShopUserInterface
    {
        return $this->shopUser;
    }

    public function setCookie(string $cookie): void
    {
        $this->cookie = $cookie;
    }

    public function getCookie(): string
    {
        return $this->cookie;
    }

    public function setProduct(ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

}