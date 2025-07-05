<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin\Tests\Factory;

use DarkSidePro\SyliusFacebookFeedPlugin\Factory\ProductFeedItemFactory;
use DarkSidePro\SyliusFacebookFeedPlugin\Model\ProductFeedItem;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\ProductTranslationInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Currency\Model\CurrencyInterface;

class ProductFeedItemFactoryTest extends TestCase
{
    public function test_create_returns_valid_feed_item(): void
    {
        $translation = $this->createMock(ProductTranslationInterface::class);
        $translation->method('getName')->willReturn('Test Product');
        $translation->method('getSlug')->willReturn('test-product');

        $product = $this->createMock(ProductInterface::class);
        $product->method('getTranslation')->willReturn($translation);
        $image = $this->getMockBuilder('stdClass')->addMethods(['getPath'])->getMock();
        $image->method('getPath')->willReturn('image.jpg');
        $product->method('getImages')->willReturn(new ArrayCollection([$image]));

        $variant = $this->getMockForAbstractClass(ProductVariantInterface::class);
        $variant->method('getProduct')->willReturn($product);
        $variant->method('getId')->willReturn(1);
        $variant->method('isInStock')->willReturn(true);
        $channelPricing = $this->createMock(ChannelPricingInterface::class);
        $channelPricing->method('getPrice')->willReturn(1234);
        $variant->method('getChannelPricingForChannel')->willReturn($channelPricing);

        $currency = $this->createMock(CurrencyInterface::class);
        $currency->method('getCode')->willReturn('PLN');
        $channel = $this->createMock(ChannelInterface::class);
        $channel->method('getBaseCurrency')->willReturn($currency);
        $channel->method('getHostname')->willReturn('localhost');

        $factory = new ProductFeedItemFactory();
        $item = $factory->create($variant, $channel);

        $this->assertInstanceOf(ProductFeedItem::class, $item);
        $this->assertSame('1', $item->id);
        $this->assertSame('Test Product', $item->title);
        $this->assertSame('http://localhost/test-product', $item->link);
        $this->assertSame('image.jpg', $item->imageLink);
        $this->assertSame('12.34 PLN', $item->price);
        $this->assertSame('in stock', $item->availability);
    }
}
