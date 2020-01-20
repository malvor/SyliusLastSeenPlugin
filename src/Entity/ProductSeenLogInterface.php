<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Entity;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ProductSeenLogInterface extends ResourceInterface
{
    public function setShopUser(ShopUserInterface $shopUser);
}