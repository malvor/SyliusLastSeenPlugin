<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\EventListener;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Websnacks\SyliusLastSeenPlugin\Entity\ProductSeenLogInterface;
use Websnacks\SyliusLastSeenPlugin\Factory\ProductSeenLogFactory;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class VisitProductListener
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var ProductRepositoryInterface  */
    private $productRepository;

    /** @var ChannelInterface */
    private $channel;

    /** @var string */
    private $locale;

    /** @var ProductSeenLogFactory */
    private $productSeenLogFactory;

    public function __construct(TokenStorageInterface $tokenStorage, ProductSeenLogFactory $productSeenLogFactory, ProductRepositoryInterface $productRepository, ChannelInterface $channel, string $locale)
    {
        $this->productSeenLogFactory = $productSeenLogFactory;
        $this->productRepository = $productRepository;
        $this->channel = $channel;
        $this->locale = $locale;
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if ($event->isMasterRequest() === false) {
            return;
        }

        $request = $event->getRequest();

        $route = $request->attributes->get('_route');

        if ($route !== 'sylius_shop_product_show') {
            return;
        }
        $params = $request->attributes->get('_route_params');
        $slug = $params['slug'];
        $product = $this->productRepository->findOneByChannelAndSlug($this->channel, $this->locale, $slug);

        if ($product === null) {
            return;
        }
        $productSeenLog = $this->getUserProductSeen();
        dump($productSeenLog);die;
    }

    private function getUserProductSeen() : ProductSeenLogInterface
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;
        if ($user === null) {
            return $this->productSeenLogFactory->createNew();
        }
        return $this->productSeenLogFactory->createForUser($user);
    }
}