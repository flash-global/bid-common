<?php

namespace Fei\Service\Bid\Validator\Strategy;

/**
 * Class PercentStrategyValidator
 *
 * @package Fei\Service\Bid\Validator\Strategy
 */
class PercentStrategyValidator extends AbstractStrategyValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($amount, $lastAmount, $step)
    {
        $min = ($lastAmount * (1 + ($step / 100)));

        if (bccomp($amount, $min) < 0) {
            throw $this->buildException($amount, $min);
        }

        return true;
    }
}
