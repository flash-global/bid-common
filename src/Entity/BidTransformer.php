<?php

namespace Fei\Service\Bid\Entity;

/**
 * Class BidTransformer
 *
 * @package Fei\Service\Bid\Entity
 */
class BidTransformer
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
        return array(
            'id' => (int) $bid->getId(),
            'created_at' => $bid->getCreatedAt()->format(\DateTime::ISO8601),
            'amount' => $bid->getAmount(),
            'context' => $bid->getContext()
        );
    }
}
