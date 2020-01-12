<?php

declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class WebsnacksSyliusLastSeenPlugin extends Bundle
{
    use SyliusPluginTrait;
}
