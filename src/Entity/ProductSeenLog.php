<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Entity;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

final class ProductSeenLog implements TimestampableInterface, ProductSeenLogInterface
{
    use TimestampableTrait;

    protected $id;

    protected $cookie;

    public function getId()
    {
        return $this->id;
    }

    public function setShopUser(ShopUserInterface $shopUser)
    {
        // TODO: Implement setShopUser() method.
    }

}