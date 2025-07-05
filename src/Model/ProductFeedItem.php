<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin\Model;

final class ProductFeedItem
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $link,
        public readonly string $imageLink,
        public readonly string $price,
        public readonly string $availability,
        public readonly string $condition = 'new'
    ) {
    }
}