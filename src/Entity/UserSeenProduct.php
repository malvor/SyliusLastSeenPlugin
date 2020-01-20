<?php
declare(strict_types=1);

namespace Websnacks\SyliusLastSeenPlugin\Entity;

use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class UserSeenProduct implements TimestampableInterface, UserSeenProductInterface
{
    use TimestampableTrait;

    protected $id;

    protected $cookie;

    protected $views;

    protected $lastSeenAt;
}