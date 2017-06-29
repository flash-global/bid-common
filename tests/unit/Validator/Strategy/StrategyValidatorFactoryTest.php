<?php

namespace Tests\Fei\Service\Bid\Validator;

use Codeception\Test\Unit;
use Fei\Service\Bid\Entity\Auction;
use Fei\Service\Bid\Validator\Strategy\Exception\StrategyValidatorFactoryException;
use Fei\Service\Bid\Validator\Strategy\StrategyValidatorFactory;
use Fei\Service\Bid\Validator\Strategy\StrategyValidatorInterface;

/**
 * Class StrategyValidatorFactoryTest
 *
 * @package Tests\Fei\Service\Bid\Validator
 */
class StrategyValidatorFactoryTest extends Unit
{
    public function testCreate()
    {
        $this->assertInstanceOf(StrategyValidatorInterface::class, StrategyValidatorFactory::create(new Auction()));
    }

    public function testCreateThrowException()
    {
        $this->expectException(StrategyValidatorFactoryException::class);
        $this->expectExceptionMessage('Unable to find strategy "10"');

        StrategyValidatorFactory::create((new Auction())->setBidStepStrategy(10));
    }

    public function testCreateBasicStrategyValidator()
    {
        $this->assertInstanceOf(StrategyValidatorInterface::class, StrategyValidatorFactory::create(new Auction()));
    }

    public function testCreatePercentStrategyValidator()
    {
        $this->assertInstanceOf(StrategyValidatorInterface::class, StrategyValidatorFactory::create(
            (new Auction())->setBidStepStrategy(Auction::PERCENT_STRATEGY)
        ));
    }
}
