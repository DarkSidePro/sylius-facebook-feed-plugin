<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin\Exporter;

use DarkSidePro\SyliusFacebookFeedPlugin\Model\ProductFeedItem;

interface FacebookFeedExporterInterface
{
    /**
     * @param ProductFeedItem[] $items
     */
    public function export(array $items): string;
}
