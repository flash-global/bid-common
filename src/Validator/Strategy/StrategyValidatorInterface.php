<?php

namespace Fei\Service\Bid\Validator\Strategy;

/**
 * Interface StrategyValidatorInterface
 *
 * @package Fei\Service\Bid\Validator
 */
interface StrategyValidatorInterface
{
    /**
     * Validate bid a amount over the last
     *
     * @param float $amount
     * @param float $lastAmount
     * @param float $step
     *
     * @return bool
     *
     * @throws \Fei\Service\Bid\Validator\Strategy\Exception\StrategyValidatorException
     */
    public function validate($amount, $lastAmount, $step);
}
