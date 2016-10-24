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

        $bccomp = function ($left, $right) {
            if (function_exists('bccomp')) {
                return bccomp($left, $right);
            }

            if (abs($left - $right) < 0.00001) {
                return 0;
            }

            if ($left > $right) {
                return 1;
            }

            return -1;
        };

        if ($bccomp($amount, $min) < 0) {
            throw $this->buildException($amount, $min);
        }

        return true;
    }
}
