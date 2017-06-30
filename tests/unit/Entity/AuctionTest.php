<?php

namespace Tests\Fei\Service\Bid\Entity;

use Codeception\Test\Unit;
use Codeception\Util\Stub;
use Doctrine\Common\Collections\ArrayCollection;
use Fei\Service\Bid\Entity\Auction;
use Fei\Service\Bid\Entity\AuctionContext;
use Fei\Service\Bid\Entity\Bid;

/**
 * Class AuctionTest
 *
 * @package Test\Fei\Service\Bid\Entity
 */
class AuctionTest extends Unit
{
    public function testIdAccessors()
    {
        $auction = new Auction();

        $auction->setId(1);

        $this->assertEquals(1, $auction->getId());
        $this->assertAttributeEquals($auction->getId(), 'id', $auction);
    }

    public function testKeyAccessors()
    {
        $auction = new Auction();

        $auction->setKey('a key');

        $this->assertEquals('a key', $auction->getKey());
        $this->assertAttributeEquals($auction->getKey(), 'key', $auction);
    }

    public function testCreatedAtAccessors()
    {
        $auction = new Auction();

        $now = new \DateTime();

        $auction->setCreatedAt($now);

        $this->assertEquals($now, $auction->getCreatedAt());
        $this->assertAttributeEquals($auction->getCreatedAt(), 'createdAt', $auction);
    }

    public function testSetCreatedAtAsString()
    {
        $auction = new Auction();

        $dateTime = '2016-10-18 14:57';

        $auction->setCreatedAt($dateTime);

        $this->assertEquals(new \DateTime($dateTime), $auction->getCreatedAt());

        $dateTime = 'notadatetime';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(
            'DateTime::__construct(): Failed to parse time string (notadatetime) at position 0 (n): The timezone could'.
            ' not be found in the database'
        );

        $auction->setCreatedAt($dateTime);
    }

    public function testStartAtAccessors()
    {
        $auction = new Auction();

        $now = new \DateTime();

        $auction->setStartAt($now);

        $this->assertEquals($now, $auction->getStartAt());
        $this->assertAttributeEquals($auction->getStartAt(), 'startAt', $auction);
    }

    public function testSetStartAtAsString()
    {
        $auction = new Auction();

        $dateTime = '2016-10-18 14:57';

        $auction->setStartAt($dateTime);

        $this->assertEquals(new \DateTime($dateTime), $auction->getStartAt());

        $dateTime = 'notadatetime';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(
            'DateTime::__construct(): Failed to parse time string (notadatetime) at position 0 (n): The timezone could'.
            ' not be found in the database'
        );

        $auction->setStartAt($dateTime);
    }

    public function testEndAtAccessors()
    {
        $auction = new Auction();

        $now = new \DateTime();

        $auction->setEndAt($now);

        $this->assertEquals($now, $auction->getEndAt());
        $this->assertAttributeEquals($auction->getEndAt(), 'endAt', $auction);
    }

    public function testSetEndAtAsString()
    {
        $auction = new Auction();

        $dateTime = '2016-10-18 14:57';

        $auction->setEndAt($dateTime);

        $this->assertEquals(new \DateTime($dateTime), $auction->getEndAt());

        $dateTime = 'notadatetime';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(
            'DateTime::__construct(): Failed to parse time string (notadatetime) at position 0 (n): The timezone could'.
            ' not be found in the database'
        );

        $auction->setEndAt($dateTime);
    }

    public function testMinimalBidAccessor()
    {
        $auction = new Auction();

        $auction->setMinimalBid(100);

        $this->assertEquals(100, $auction->getMinimalBid());
        $this->assertAttributeEquals($auction->getMinimalBid(), 'minimalBid', $auction);
    }

    public function testBidStepAccessors()
    {
        $auction = new Auction();

        $auction->setBidStep(10);

        $this->assertEquals(10, $auction->getBidStep());
        $this->assertAttributeEquals($auction->getBidStep(), 'bidStep', $auction);
    }

    public function testBidStepStrategyAccessors()
    {
        $auction = new Auction();

        $auction->setBidStepStrategy(Auction::PERCENT_STRATEGY);

        $this->assertEquals(Auction::PERCENT_STRATEGY, $auction->getBidStepStrategy());
        $this->assertAttributeEquals($auction->getBidStepStrategy(), 'bidStepStrategy', $auction);
    }

    public function testBidsAccessors()
    {
        $auction = new Auction();

        $auction->setBids(new ArrayCollection([new Bid()]));

        $this->assertCount(1, $auction->getBids());
        $this->assertAttributeEquals($auction->getBids(), 'bids', $auction);
        $this->assertEquals($auction, $auction->getBids()->first()->getAuction());
    }

    public function testAddBid()
    {
        $auction = new Auction();

        $auction->addBid(new Bid());

        $this->assertCount(1, $auction->getBids());
        $this->assertEquals($auction, $auction->getBids()->first()->getAuction());
    }

    public function testClearBids()
    {
        $auction = new Auction();

        $auction->addBid(new Bid());

        $this->assertCount(1, $auction->getBids());

        $auction->clearBids();

        $this->assertCount(0, $auction->getBids());
    }

    public function testContextAccessors()
    {
        $auction = new Auction();
        $auction->setContexts(new AuctionContext());

        $context = new AuctionContext();
        $context->setAuction($auction);

        $this->assertEquals(new ArrayCollection([$context]), $auction->getContexts());
        $this->assertAttributeEquals($auction->getContexts(), 'contexts', $auction);
    }

    public function testSetContextsFromArray()
    {
        $auction = new Auction();
        $auction->setContexts([
            ['key' => 'testKey', 'value' => 'testValue']
        ]);

        $context = new AuctionContext(['key' => 'testKey', 'value' => 'testValue']);
        $context->setAuction($auction);

        $expected = new ArrayCollection([
            0 => (new AuctionContext(['key' => 'testKey', 'value' => 'testValue']))->setAuction($auction),
        ]);

        $this->assertEquals($expected, $auction->getContexts());
        $this->assertAttributeEquals($auction->getContexts(), 'contexts', $auction);
    }

    public function testHydrate()
    {
        $now = new \DateTime();

        $auction = new Auction([
            'id' => 1,
            'key' => 'a key',
            'created_at' => $now,
            'start_at' => $now,
            'end_at' => $now,
            'minimal_bid' => 100,
            'bid_step' => 10,
            'bid_step_strategy' => Auction::PERCENT_STRATEGY,
            'contexts' => ['key' => 'value'],
            'bids' => [
                [
                    'id' => 1,
                    'created_at' => $now,
                    'amount' => 120,
                    'bidder' => 'user',
                    'contexts' => ['key' => 'value']
                ]
            ]
        ]);

        $this->assertEquals(
            (new Auction())
                ->setId(1)
                ->setKey('a key')
                ->setCreatedAt($now)
                ->setStartAt($now)
                ->setEndAt($now)
                ->setMinimalBid(100)
                ->setBidStep(10)
                ->setBidStepStrategy(Auction::PERCENT_STRATEGY)
                ->setContexts(['key' => 'value'])
                ->addBid(
                    (new Bid())
                        ->setId(1)
                        ->setCreatedAt($now)
                        ->setAmount(120)
                        ->setBidder('user')
                        ->setContexts(['key' => 'value'])
                ),
            $auction
        );
    }

    public function testHydrateEmptyContext()
    {
        $now = new \DateTime();

        $auction = new Auction([
            'id' => 1,
            'key' => 'a key',
            'created_at' => $now,
            'start_at' => $now,
            'end_at' => $now,
            'minimal_bid' => 100,
            'bid_step' => 10,
            'bid_step_strategy' => Auction::PERCENT_STRATEGY,
            'contexts' => [],
            'bids' => [
                [
                    'id' => 1,
                    'created_at' => $now,
                    'amount' => 120,
                    'bidder' => 'user',
                ]
            ]
        ]);

        $this->assertEquals(
            (new Auction())
                ->setId(1)
                ->setKey('a key')
                ->setCreatedAt($now)
                ->setStartAt($now)
                ->setEndAt($now)
                ->setMinimalBid(100)
                ->setBidStep(10)
                ->setBidStepStrategy(Auction::PERCENT_STRATEGY)
                ->addBid(
                    (new Bid())
                        ->setId(1)
                        ->setCreatedAt($now)
                        ->setAmount(120)
                        ->setBidder('user')
                ),
            $auction
        );
    }

    public function testHydrateBidEmpty()
    {
        $auction = new Auction(['bid' => []]);

        $this->assertEquals((new Auction()), $auction);
    }

    public function testToArray()
    {
        $now = new \DateTime();

        $auction = (new Auction())
            ->setCreatedAt($now)
            ->addBid((new bid())->setCreatedAt($now))
            ->addContext(
                new AuctionContext(['key' => 'testContext', 'value' => 'testValue'])
            );

        $this->assertEquals(
            [
                'id' => $auction->getId(),
                'key' => $auction->getKey(),
                'created_at' => $auction->getCreatedAt()->format(\DateTime::RFC3339),
                'start_at' => null,
                'end_at' => null,
                'minimal_bid' => $auction->getMinimalBid(),
                'bid_step' => $auction->getBidStep(),
                'bid_step_strategy' => $auction->getBidStepStrategy(),
                'bids' => [
                    [
                        'id' => null,
                        'created_at' => $now->format(\DateTime::RFC3339),
                        'bidder' => null,
                        'amount' => null,
                        'contexts' => [],
                        'status' => Bid::STATUS_ONGOING,
                        'auction_id' => $auction->getId(),
                    ]
                ],
                'contexts' => [
                    ['key' => 'testContext', 'value' => 'testValue', 'id' => null],
                ]
            ],
            $auction->toArray()
        );
    }

    public function testToArrayEmptyBid()
    {
        $now = new \DateTime();

        $auction = (new Auction())
            ->setCreatedAt($now);

        $this->assertEquals(
            [
                'id' => $auction->getId(),
                'key' => $auction->getKey(),
                'created_at' => $auction->getCreatedAt()->format(\DateTime::RFC3339),
                'start_at' => null,
                'end_at' => null,
                'minimal_bid' => $auction->getMinimalBid(),
                'bid_step' => $auction->getBidStep(),
                'bid_step_strategy' => $auction->getBidStepStrategy(),
                'contexts' => [],
                'bids' => []
            ],
            $auction->toArray()
        );
    }

    public function testAddContext()
    {
        $auctionContextMock = $this->getMockBuilder(AuctionContext::class)->setMethods(['setAuction'])->getMock();
        $auctionContextMock->expects($this->once())->method('setAuction');

        $contextsMock = $this->getMockBuilder(ArrayCollection::class)->setMethods(['add'])->getMock();
        $contextsMock->expects($this->once())->method('add')->with($auctionContextMock);

        $auction = Stub::make(Auction::class, [
            'getContexts' => $contextsMock,
        ]);

        $this->assertEquals($auction, $auction->addContext($auctionContextMock));
    }
}
