<?php

namespace Tests\Fei\Service\Bid\Validator;

use Codeception\Test\Unit;
use Fei\Service\Bid\Validator\Strategy\BasicStrategyValidator;
use Fei\Service\Bid\Validator\Strategy\Exception\StrategyValidatorException;

/**
 * Class BasicStrategyValidatorTest
 *
 * @package Tests\Fei\Service\Bid\Validator
 */
class BasicStrategyValidatorTest extends Unit
{
    public function testValidate()
    {
        $validator = new BasicStrategyValidator();

        try {
            $validator->validate(9, 10, 1);
        } catch (\Exception $e) {
            $this->assertInstanceOf(StrategyValidatorException::class, $e);
            $this->assertEquals(
                sprintf('Invalid Bid amount. Given %.2f. Bid amount must be greater than or equal to %.2f', 9, 11),
                $e->getMessage()
            );
        }

        try {
            $validator->validate(10, 10, 1);
        } catch (\Exception $e) {
            $this->assertInstanceOf(StrategyValidatorException::class, $e);
            $this->assertEquals(
                sprintf('Invalid Bid amount. Given %.2f. Bid amount must be greater than or equal to %.2f', 10, 11),
                $e->getMessage()
            );
        }

        $this->assertTrue($validator->validate(11, 10, 1));
        $this->assertTrue($validator->validate(12, 10, 1));
        $this->assertTrue($validator->validate(11.123, 10.100, 0.023));
    }
}
