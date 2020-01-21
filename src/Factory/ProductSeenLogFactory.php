<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Factory;

use Sylius\Component\Core\Model\ChannelInterface;
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
     * {@inheritdoc}
     */
    public function createNew(): ProductSeenLogInterface
    {
        /** @var ProductSeenLogInterface $productSeenLog */
        $productSeenLog = $this->productSeenLogFactory->createNew();
        return $productSeenLog;
    }

    /**
     * {@inheritdoc}
     */
    public function createForUserWithCookie(ShopUserInterface $shopUser, string $cookie, ChannelInterface $channel): ProductSeenLogInterface
    {
        $productSeenLog = $this->createWithCookie($cookie, $channel);
        $productSeenLog->setShopUser($shopUser);
        return $productSeenLog;
    }

    /**
     * {@inheritdoc}
     */
    public function createWithCookie(string $cookie, ChannelInterface $channel): ProductSeenLogInterface
    {
        $productSeenLog = $this->createNew();
        $productSeenLog->setCookie($cookie);
        $productSeenLog->setChannel($channel);
        return $productSeenLog;
    }
}