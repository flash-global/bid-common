<?php

namespace Tests\Fei\Service\Bid\Entity;

use Codeception\Test\Unit;
use Fei\Service\Bid\Entity\Auction;
use Fei\Service\Bid\Entity\AuctionTransformer;

/**
 * Class AuctionTransformerTest
 *
 * @package Tests\Fei\Service\Bid\Entity
 */
class AuctionTransformerTest extends Unit
{
    public function testTransform()
    {
        $now = new \DateTime();

        $auction = (new Auction())
            ->setId(1)
            ->setKey('a key')
            ->setCreatedAt($now)
            ->setStartAt($now)
            ->setEndAt($now)
            ->setBidStep(10)
            ->setBidStepUnit(Auction::STEP_PERCENT)
            ->setMinimalBid(100)
            ->setContext(['test' => 'test']);

        $this->assertEquals(
            [
                'id' => 1,
                'key' => 'a key',
                'created_at' => $now->format(\DateTime::ISO8601),
                'start_at' => $now->format(\DateTime::ISO8601),
                'end_at' => $now->format(\DateTime::ISO8601),
                'bid_step' => 10,
                'bid_step_unit' => Auction::STEP_PERCENT,
                'minimal_bid' => 100,
                'context' => ['test' => 'test']
            ],
            (new AuctionTransformer())->transform($auction)
        );
    }
}
