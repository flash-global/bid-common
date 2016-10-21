<?php

namespace Tests\Fei\Service\Bid\Validator;

use Codeception\Test\Unit;
use Fei\Service\Bid\Validator\Strategy\Exception\StrategyValidatorException;
use Fei\Service\Bid\Validator\Strategy\PercentStrategyValidator;

/**
 * Class PercentStrategyValidatorTest
 *
 * @package Tests\Fei\Service\Bid\Validator
 */
class PercentStrategyValidatorTest extends Unit
{
    public function testValidate()
    {
        $validator = new PercentStrategyValidator();

        try {
            $validator->validate(90, 100, 10);
        } catch (\Exception $e) {
            $this->assertInstanceOf(StrategyValidatorException::class, $e);
            $this->assertEquals(
                sprintf('Invalid Bid amount. Given %.2f. Bid amount must be greater than or equal to %.2f', 90, 110),
                $e->getMessage()
            );
        }

        try {
            $validator->validate(100, 100, 10);
        } catch (\Exception $e) {
            $this->assertInstanceOf(StrategyValidatorException::class, $e);
            $this->assertEquals(
                sprintf('Invalid Bid amount. Given %.2f. Bid amount must be greater than or equal to %.2f', 100, 110),
                $e->getMessage()
            );
        }

        $this->assertTrue($validator->validate(110, 100, 10));
        $this->assertTrue($validator->validate(120, 100, 10));
    }
}
