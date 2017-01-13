<?php

namespace Tests\Fei\Service\Bid\Entity;

use Codeception\Test\Unit;
use Fei\Service\Bid\Entity\Bid;
use Fei\Service\Bid\Entity\BidTransformer;

/**
 * Class BidTransformerTest
 *
 * @package Tests\Fei\Service\Bid\Entity
 */
class BidTransformerTest extends Unit
{
    public function testTransform()
    {
        $now = new \DateTime();

        $bid = (new Bid())
            ->setId(1)
            ->setCreatedAt($now)
            ->setAmount(120)
            ->setBidder('a bidder')
            ->setContexts(['key' => 'value']);

        $this->assertEquals(
            [
                'id' => 1,
                'created_at' => $now->format(\DateTime::ISO8601),
                'amount' => 120,
                'bidder' => 'a bidder',
                'contexts' => ['key' => 'value']
            ],
            (new BidTransformer())->transform($bid)
        );
    }
}
