<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\EventListener;

use Ramsey\Uuid\Uuid;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Websnacks\SyliusLastSeenPlugin\Entity\ProductSeenLogInterface;
use Websnacks\SyliusLastSeenPlugin\Factory\ProductSeenLogFactory;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Persistence\ObjectManager;

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

    /** @var ObjectManager */
    private $lastSeenObjectManager;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        ProductSeenLogFactory $productSeenLogFactory,
        ProductRepositoryInterface $productRepository,
        ChannelInterface $channel,
        string $locale,
        ObjectManager $lastSeenObjectManager
    ) {
        $this->productSeenLogFactory = $productSeenLogFactory;
        $this->productRepository = $productRepository;
        $this->channel = $channel;
        $this->locale = $locale;
        $this->tokenStorage = $tokenStorage;
        $this->lastSeenObjectManager = $lastSeenObjectManager;
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
        $productSeenLog = $this->getUserProductSeen($request);
        $productSeenLog->setProduct($product);
        $this->lastSeenObjectManager->persist($productSeenLog);
        $this->lastSeenObjectManager->flush();
    }

    private function getUserProductSeen(Request $request) : ProductSeenLogInterface
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;
        $cookieToken = $request->cookies->get('PHPSESSID');
        if (!$user instanceof ShopUserInterface) {
            $productSeenLog = $this->productSeenLogFactory->createWithCookie($cookieToken);
            return $productSeenLog;
        }
        return $this->productSeenLogFactory->createForUserWithCookie($user, $cookieToken);
    }

}