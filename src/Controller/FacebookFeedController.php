<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin\Controller;

use DarkSidePro\SyliusFacebookFeedPlugin\Services\FeedGeneratorInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Symfony\Component\HttpFoundation\Response;

final class FacebookFeedController
{
    public function __construct(
        private FeedGeneratorInterface $feedGenerator,
        private ChannelContextInterface $channelContext
    ) {
    }

    public function __invoke(): Response
    {
        $channel = $this->channelContext->getChannel();
        $feed = $this->feedGenerator->generate($channel);

        return new Response($feed, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}