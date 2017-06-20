<?php

namespace Tests\Fei\Service\Bid\Entity;

use Codeception\Test\Unit;
use Fei\Service\Bid\Entity\Auction;
use Fei\Service\Bid\Entity\AuctionContext;

/**
 * Class ActionContextTest
 *
 * @package Tests\Fei\Service\Bid\Entity
 */
class AuctionContextTest extends Unit
{
    public function testAuctionAccessors()
    {
        $context = new AuctionContext();
        $context->setAuction(new Auction());

        $this->assertEquals(new Auction(), $context->getAuction());
        $this->assertAttributeEquals($context->getAuction(), 'auction', $context);
    }
}
