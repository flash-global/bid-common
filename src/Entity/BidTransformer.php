<?php

namespace Fei\Service\Bid\Entity;

use League\Fractal\TransformerAbstract;

/**
 * Class BidTransformer
 *
 * @package Fei\Service\Bid\Entity
 */
class BidTransformer extends TransformerAbstract
{
    /**
     * Transform a Bid instance to an array
     *
     * @param Bid $bid
     *
     * @return array
     */
    public function transform(Bid $bid)
    {
        $contextItems = array();

        foreach ($bid->getContexts() as $contextItem) {
            $contextItems[$contextItem->getKey()] = $contextItem->getValue();
        }

        return array(
            'id' => (int) $bid->getId(),
            'status' => (int) $bid->getStatus(),
            'created_at' => $bid->getCreatedAt()->format(\DateTime::ISO8601),
            'amount' => $bid->getAmount(),
            'bidder' => $bid->getBidder(),
            'contexts' => $contextItems
        );
    }
}
