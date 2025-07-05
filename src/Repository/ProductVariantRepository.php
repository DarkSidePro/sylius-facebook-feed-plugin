<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductVariantRepository as BaseProductVariantRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;

class ProductVariantRepository extends BaseProductVariantRepository implements ProductVariantRepositoryInterface
{
    public function findEnabledVariantsForChannel(ChannelInterface $channel): array
    {
        $qb = $this->createQueryBuilder('v')
            ->innerJoin('v.product', 'p')
            ->innerJoin('p.channels', 'c')
            ->where('v.enabled = true')
            ->andWhere('c = :channel')
            ->setParameter('channel', $channel);

        return $qb->getQuery()->getResult();
    }
}
