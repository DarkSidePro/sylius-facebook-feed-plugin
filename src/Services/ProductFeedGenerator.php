<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin\Services;

use DarkSidePro\SyliusFacebookFeedPlugin\Exporter\FacebookFeedExporterInterface;
use DarkSidePro\SyliusFacebookFeedPlugin\Factory\ProductFeedItemFactory;
use DarkSidePro\SyliusFacebookFeedPlugin\Services\FeedGeneratorInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;

final class ProductFeedGenerator implements FeedGeneratorInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductFeedItemFactory $feedItemFactory,
        private FacebookFeedExporterInterface $exporter
    ) {
    }

    public function generate(ChannelInterface $channel): string
    {
        // Pobierz wszystkie produkty i przefiltruj warianty
        $allProducts = $this->productRepository->findAll();
        $variants = [];
        
        foreach ($allProducts as $product) {
            // Sprawdź czy produkt jest dostępny w kanale
            if ($product->hasChannel($channel)) {
                foreach ($product->getVariants() as $variant) {
                    if ($variant->isEnabled()) {
                        $variants[] = $variant;
                    }
                }
            }
        }

        $items = array_map(
            fn ($v) => $this->feedItemFactory->create($v, $channel),
            $variants
        );

        return $this->exporter->export($items);
    }
}