<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class FacebookFeedPlugin extends Bundle
{
    use SyliusPluginTrait;
}