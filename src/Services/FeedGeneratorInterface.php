<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin\Services;

use Sylius\Component\Core\Model\ChannelInterface;

interface FeedGeneratorInterface
{
    public function generate(ChannelInterface $channel): string;
}
