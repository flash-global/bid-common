<?php

namespace Fei\Service\Bid\Validator\Strategy;

use Fei\Service\Bid\Entity\Auction;
use Fei\Service\Bid\Validator\Strategy\Exception\StrategyValidatorFactoryException;

/**
 * Class StrategyValidatorFactory
 *
 * @package Fei\Service\Bid\Validator
 */
class StrategyValidatorFactory
{
    /**
     * Create a StrategyValidator interface instance in function of defined Auction's strategy
     *
     * @param Auction $auction
     *
     * @return StrategyValidatorInterface
     */
    public static function create(Auction $auction)
    {
        switch ($auction->getBidStepStrategy()) {
            case Auction::BASIC_STRATEGY:
                return new BasicStrategyValidator();
            case Auction::PERCENT_STRATEGY:
                return new PercentStrategyValidator();
            case Auction::NO_STRATEGY:
                return new NoStrategyValidator();
            default:
                throw new StrategyValidatorFactoryException(
                    sprintf('Unable to find strategy "%d"', $auction->getBidStepStrategy())
                );
        }
    }
}
