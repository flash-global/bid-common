<?php

namespace Fei\Service\Bid\Validator\Strategy;

use Fei\Service\Bid\Validator\Strategy\Exception\StrategyValidatorException;

/**
 * Class AbstractStrategyValidator
 *
 * @package Fei\Service\Bid\Validator\Strategy
 */
abstract class AbstractStrategyValidator implements StrategyValidatorInterface
{
    /**
     * Returns a instance of StrategyValidatorException
     *
     * @param float $amount
     * @param float $min
     *
     * @return StrategyValidatorException
     */
    protected function buildException($amount, $min)
    {
        return new StrategyValidatorException(
            sprintf('Invalid Bid amount. Given %.2f. Bid amount must be greater than or equal to %.2f', $amount, $min)
        );
    }
}
