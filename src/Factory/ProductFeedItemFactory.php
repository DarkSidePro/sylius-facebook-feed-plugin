<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin\Factory;

use DarkSidePro\SyliusFacebookFeedPlugin\Model\ProductFeedItem;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;

class ProductFeedItemFactory
{
    public function create(ProductVariantInterface $variant, ChannelInterface $channel): ProductFeedItem
    {
        $product = $variant->getProduct();
        $translation = $product->getTranslation();
        
        $price = $this->formatPrice(
            $variant->getChannelPricingForChannel($channel)->getPrice(),
            $channel->getBaseCurrency()->getName()
        );

        return new ProductFeedItem(
           (string) $variant->id,
            $translation->getName(),
            $this->generateProductUrl($product, $channel),
            $this->getFirstImagePath($product),
            $price,
            $variant->isInStock() ? 'in stock' : 'out of stock'
        );
    }

    private function formatPrice(int $price, string $currency): string
    {
        return sprintf('%.2f %s', $price / 100, $currency);
    }
    
    private function generateProductUrl(ProductInterface $product, ChannelInterface $channel): string
    {
        // Przykładowa implementacja: generowanie URL na podstawie slug i domeny kanału
        $slug = $product->getTranslation()->getSlug();
        $hostname = $channel->getHostname() ?? $_SERVER['HTTP_HOST'] ?? 'localhost';
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        return sprintf('%s://%s/%s', $scheme, $hostname, $slug);
    }
    
    private function getFirstImagePath(ProductInterface $product): ?string
    {
        $images = $product->getImages();
        if ($images && count($images) > 0) {
            $image = $images->first();
            if (method_exists($image, 'getPath')) {
                return $image->getPath();
            }
        }
        return null;
    }
}