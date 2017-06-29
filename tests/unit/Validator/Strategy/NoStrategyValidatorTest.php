<?php

namespace Tests\Fei\Service\Bid\Validator;

use Codeception\Test\Unit;
use Fei\Service\Bid\Validator\Strategy\NoStrategyValidator;

/**
 * Class PercentStrategyValidatorTest
 *
 * @package Tests\Fei\Service\Bid\Validator
 */
class NoStrategyValidatorTest extends Unit
{
    public function testValidate()
    {
        $validator = new NoStrategyValidator();

        $this->assertTrue($validator->validate(110, 100, 10));
        $this->assertTrue($validator->validate(100, 100, 10));
        $this->assertTrue($validator->validate(90, 100, 10));
    }
}
