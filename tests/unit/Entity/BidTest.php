<?php

namespace Tests\Fei\Service\Bid\Entity;

use Codeception\Test\Unit;
use Fei\Service\Bid\Entity\Auction;
use Fei\Service\Bid\Entity\Bid;

/**
 * Class BidTest
 *
 * @package Tests\Fei\Service\Bid\Entity
 */
class BidTest extends Unit
{
    public function testIdAccessors()
    {
        $bid = new Bid();

        $bid->setId(1);

        $this->assertEquals(1, $bid->getId());
        $this->assertAttributeEquals($bid->getId(), 'id', $bid);
    }

    public function testCreatedAtAccessors()
    {
        $bid = new Bid();

        $now = new \DateTime();

        $bid->setCreatedAt($now);

        $this->assertEquals($now, $bid->getCreatedAt());
        $this->assertAttributeEquals($bid->getCreatedAt(), 'createdAt', $bid);
    }

    public function testSetCreatedAtAsString()
    {
        $bid = new Bid();

        $dateTime = '2016-10-18 14:57';

        $bid->setCreatedAt($dateTime);

        $this->assertEquals(new \DateTime($dateTime), $bid->getCreatedAt());

        $dateTime = 'notadatetime';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(
            'DateTime::__construct(): Failed to parse time string (notadatetime) at position 0 (n): The timezone could'.
            ' not be found in the database'
        );

        $bid->setCreatedAt($dateTime);
    }

    public function testAmountAccessors()
    {
        $bid = new Bid();

        $bid->setAmount(120);

        $this->assertEquals(120, $bid->getAmount());
        $this->assertAttributeEquals($bid->getAmount(), 'amount', $bid);
    }

    public function testBidderAccessors()
    {
        $bid = new Bid();

        $bid->setBidder('a bidder');

        $this->assertEquals('a bidder', $bid->getBidder());
        $this->assertAttributeEquals($bid->getBidder(), 'bidder', $bid);
    }

    public function testAuctionAccessors()
    {
        $bid = new Bid();

        $bid->setAuction(new Auction());

        $this->assertEquals(new Auction(), $bid->getAuction());
        $this->assertAttributeEquals($bid->getAuction(), 'auction', $bid);
    }

    public function testHydrate()
    {
        $now = new \DateTime();
        $bid = new Bid([
            'id' => 1,
            'createdAt' => $now,
            'amount' => 120,
            'bidder' => 'bidder',
            'context' => ['key' => 'value'],
            'auction' => [
                'id' => 1,
                'key' => 'key',
                'createdAt' => $now,
                'context' => ['key' => 'value']
            ]
        ]);

        $this->assertEquals(
            (new Bid())
                ->setId(1)
                ->setCreatedAt($now)
                ->setBidder('bidder')
                ->setAmount(120)
                ->setContext(['key' => 'value'])
                ->setAuction(
                    (new Auction())
                        ->setId(1)
                        ->setKey('key')
                        ->setCreatedAt($now)
                        ->setContext(['key' => 'value'])
                ),
            $bid
        );
    }

    public function testHydrateRoomEmpty()
    {
        $bid = new Bid(['auction' => []]);

        $this->assertEquals((new Bid())->setAuction(new Auction()), $bid);
    }

    public function testToArray()
    {
        $now = new \DateTime();

        $bid = (new Bid())
            ->setCreatedAt($now)
            ->setAuction((new Auction())
                ->setCreatedAt($now));

        $this->assertEquals(
            [
                'id' => null,
                'bidder' => null,
                'amount' => null,
                'created_at' => $now->format(\DateTime::RFC3339),
                'auction_id' => null,
                'context' => null
            ],
            $bid->toArray()
        );
    }

    public function testToArrayEmptyRoom()
    {
        $now = new \DateTime();

        $bid = (new Bid())
            ->setCreatedAt($now);

        $this->assertEquals(
            [
                'id' => null,
                'bidder' => null,
                'amount' => null,
                'created_at' => $now->format(\DateTime::RFC3339),
                'context' => null,
                'auction' => null
            ],
            $bid->toArray()
        );
    }
}
