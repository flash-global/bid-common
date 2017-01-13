<?php

namespace Tests\Fei\Service\Bid\Entity;

use Codeception\Test\Unit;
use Fei\Service\Bid\Entity\Auction;
use Fei\Service\Bid\Entity\AuctionContext;
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
            ->setBidStepStrategy(Auction::PERCENT_STRATEGY)
            ->setMinimalBid(100)
            ->setContexts(new AuctionContext(['key' => 'test', 'value' => 'value']));

        $this->assertEquals(
            [
                'id' => 1,
                'key' => 'a key',
                'created_at' => $now->format(\DateTime::ISO8601),
                'start_at' => $now->format(\DateTime::ISO8601),
                'end_at' => $now->format(\DateTime::ISO8601),
                'bid_step' => 10,
                'bid_step_strategy' => Auction::PERCENT_STRATEGY,
                'minimal_bid' => 100,
                'contexts' => ['test' => 'value']
            ],
            (new AuctionTransformer())->transform($auction)
        );
    }
}
