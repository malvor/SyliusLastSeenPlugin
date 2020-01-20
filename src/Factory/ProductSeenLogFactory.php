<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Factory;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Websnacks\SyliusLastSeenPlugin\Entity\ProductSeenLogInterface;

class ProductSeenLogFactory implements ProductSeenLogFactoryInterface
{
    /** @var FactoryInterface */
    private $productSeenLogFactory;

    public function __construct(FactoryInterface $productSeenLogFactory)
    {
        $this->productSeenLogFactory = $productSeenLogFactory;
    }

    public function createNew() : ProductSeenLogInterface
    {
        /** @var ProductSeenLogInterface $productSeenLog */
        $productSeenLog = $this->productSeenLogFactory->createNew();
        return $productSeenLog;
    }

    public function createForUser(ShopUserInterface $shopUser): ProductSeenLogInterface
    {
        $productSeenLog = $this->createNew();
        $productSeenLog->setShopUser($shopUser);
        return $productSeenLog;
    }
}