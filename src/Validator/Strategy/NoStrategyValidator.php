<?php

namespace Fei\Service\Bid\Validator\Strategy;

/**
 * Class NoStrategyValidator
 *
 * @package Fei\Service\Bid\Validator\Strategy
 */
class NoStrategyValidator extends AbstractStrategyValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($amount, $lastAmount, $step)
    {
        // Don't restrict bidding amount.
        return true;
    }
}
