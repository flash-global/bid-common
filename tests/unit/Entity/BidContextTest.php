<?php

namespace Tests\Fei\Service\Bid\Entity;

use Codeception\Test\Unit;
use Fei\Service\Bid\Entity\Bid;
use Fei\Service\Bid\Entity\BidContext;

/**
 * Class BidContextTest
 *
 * @package Tests\Fei\Service\Bid\Entity
 */
class BidContextTest extends Unit
{
    public function testBidAccessors()
    {
        $context = new BidContext();
        $context->setBid(new Bid());

        $this->assertEquals(new Bid(), $context->getBid());
        $this->assertAttributeEquals($context->getBid(), 'bid', $context);
    }
}
