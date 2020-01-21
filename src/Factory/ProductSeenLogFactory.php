<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Factory;

use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Websnacks\SyliusLastSeenPlugin\Entity\ProductSeenLogInterface;

/**
 * Class ProductSeenLogFactory
 * @package Websnacks\SyliusLastSeenPlugin\Factory
 */
class ProductSeenLogFactory implements ProductSeenLogFactoryInterface
{
    /** @var FactoryInterface */
    private $productSeenLogFactory;

    /**
     * ProductSeenLogFactory constructor.
     * @param FactoryInterface $productSeenLogFactory
     */
    public function __construct(FactoryInterface $productSeenLogFactory)
    {
        $this->productSeenLogFactory = $productSeenLogFactory;
    }

    /**
     * @return ProductSeenLogInterface
     */
    public function createNew(): ProductSeenLogInterface
    {
        /** @var ProductSeenLogInterface $productSeenLog */
        $productSeenLog = $this->productSeenLogFactory->createNew();
        return $productSeenLog;
    }

    /**
     * @param ShopUserInterface $shopUser
     * @param string $cookie
     * @return ProductSeenLogInterface
     */
    public function createForUserWithCookie(ShopUserInterface $shopUser, string $cookie): ProductSeenLogInterface
    {
        $productSeenLog = $this->createNew();
        $productSeenLog->setShopUser($shopUser);
        $productSeenLog->setCookie($cookie);
        return $productSeenLog;
    }

    /**
     * @param string $cookie
     * @return ProductSeenLogInterface
     */
    public function createWithCookie(string $cookie): ProductSeenLogInterface
    {
        $productSeenLog = $this->createNew();
        $productSeenLog->setCookie($cookie);
        return $productSeenLog;
    }
}