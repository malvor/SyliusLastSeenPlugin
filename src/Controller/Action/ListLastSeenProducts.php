<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Controller\Action;

use Sylius\Component\Core\Model\ShopUserInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Websnacks\SyliusLastSeenPlugin\Repository\ProductSeenLogRepositoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class ListLastSeenProducts
{
    private const
        DEFAULT_RECORDS = 4;

    /** @var EngineInterface */
    private $templatingEngine;

    /** @var ProductSeenLogRepositoryInterface  */
    private $productSeenLogRepository;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        ProductSeenLogRepositoryInterface $productSeenLogRepository,
        EngineInterface $templatingEngine
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->productSeenLogRepository = $productSeenLogRepository;
        $this->templatingEngine = $templatingEngine;
    }

    public function __invoke(Request $request): Response
    {
        $records = intval($request->get('records', self::DEFAULT_RECORDS));
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;
        $lastSeenProducts = [];
        $cookieToken = $request->cookies->get('PHPSESSID');
        if ($user instanceof ShopUserInterface) {
            $lastSeenProducts = $this->productSeenLogRepository->findLastSeenByShopUser($user, $cookieToken, $records);
        } elseif($cookieToken) {
            $lastSeenProducts = $this->productSeenLogRepository->findLastSeenByCookie($cookieToken, $records);
        }
        return $this->templatingEngine->renderResponse('@WebsnacksSyliusLastSeenPlugin/list_last_seen_products.html.twig', [
            'last_seen_products' => $lastSeenProducts
        ]);
    }
}