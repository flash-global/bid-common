<?php

namespace Fei\Service\Bid\Entity;

use League\Fractal\TransformerAbstract;

/**
 * Class AuctionTransformer
 *
 * @package Fei\Service\Bid\Entity
 */
class AuctionTransformer extends TransformerAbstract
{
    /**
     * Transform a Auction instance to an array
     *
     * @param Auction $auction
     *
     * @return array
     */
    public function transform(Auction $auction)
    {
        return array(
            'id' => (int) $auction->getId(),
            'key' => $auction->getKey(),
            'created_at' => $auction->getCreatedAt()->format(\DateTime::ISO8601),
            'start_at' => $auction->getStartAt()->format(\DateTime::ISO8601),
            'end_at' => $auction->getEndAt()->format(\DateTime::ISO8601),
            'bid_step' => $auction->getBidStep(),
            'bid_step_unit' => $auction->getBidStepUnit(),
            'minimal_bid' => $auction->getMinimalBid(),
            'context' => $auction->getContext()
        );
    }
}
