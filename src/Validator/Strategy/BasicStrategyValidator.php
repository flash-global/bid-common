<?php

namespace Fei\Service\Bid\Validator\Strategy;

/**
 * Class BasicStrategyValidator
 *
 * @package Fei\Service\Bid\Validator\Strategy
 */
class BasicStrategyValidator extends AbstractStrategyValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($amount, $lastAmount, $step)
    {
        $min = $lastAmount + $step;

        if ($amount < $min) {
            throw $this->buildException($amount, $min);
        }

        return true;
    }
}
