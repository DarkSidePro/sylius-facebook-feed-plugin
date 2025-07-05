<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin\Exporter;

use DarkSidePro\SyliusFacebookFeedPlugin\Model\ProductFeedItem;
use XMLWriter;

final class XmlFacebookFeedExporter implements FacebookFeedExporterInterface
{
    public function export(array $items): string
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('rss');
        $xml->writeAttribute('version', '2.0');
        $xml->writeAttribute('xmlns:g', 'http://base.google.com/ns/1.0');
        $xml->startElement('channel');

        foreach ($items as $item) {
            $this->addItem($xml, $item);
        }

        $xml->endElement();
        $xml->endElement();

        return $xml->outputMemory();
    }

    private function addItem(XMLWriter $xml, ProductFeedItem $item): void
    {
        $xml->startElement('item');
        $xml->writeElement('g:id', $item->id);
        $xml->writeElement('g:title', htmlspecialchars($item->title));
        $xml->writeElement('g:link', $item->link);
        $xml->writeElement('g:image_link', $item->imageLink);
        $xml->writeElement('g:price', $item->price);
        $xml->writeElement('g:availability', $item->availability);
        $xml->writeElement('g:condition', $item->condition);
        $xml->endElement();
    }
}