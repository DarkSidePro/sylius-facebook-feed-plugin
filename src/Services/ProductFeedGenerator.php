<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin\Services;

use DarkSidePro\SyliusFacebookFeedPlugin\Exporter\FacebookFeedExporterInterface;
use DarkSidePro\SyliusFacebookFeedPlugin\Factory\ProductFeedItemFactory;
use DarkSidePro\SyliusFacebookFeedPlugin\Services\FeedGeneratorInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;

final class ProductFeedGenerator implements FeedGeneratorInterface
{
    public function __construct(
        private ProductVariantRepositoryInterface $productVariantRepository,
        private ProductFeedItemFactory $feedItemFactory,
        private FacebookFeedExporterInterface $exporter
    ) {
    }

    public function generate(ChannelInterface $channel): string
    {
        $variants = $this->productVariantRepository->findEnabledForChannel($channel);
        $items = array_map(
            fn ($v) => $this->feedItemFactory->create($v, $channel),
            $variants
        );

        return $this->exporter->export($items);
    }
}