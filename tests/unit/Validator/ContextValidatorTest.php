<?php

namespace Tests\Fei\Service\Bid\Validator;

use Codeception\Test\Unit;
use Doctrine\Common\Collections\ArrayCollection;
use Fei\Service\Bid\Entity\Bid;
use Fei\Service\Bid\Entity\Context;
use Fei\Service\Bid\Validator\BidValidator;

/**
 * Class ContextValidatorTest
 *
 * @package Tests\Fei\Service\Bid\Validator
 */
class ContextValidatorTest extends Unit
{
    public function testValidateKey()
    {
        $validator = $this->getContextValidator();

        $this->assertFalse($validator->validateKey(''));
        $this->assertEquals('The key cannot be empty', $validator->getErrors()['key'][0]);

        $this->assertFalse($validator->validateKey($validator->validateKey(str_repeat('☃', 256))));
        $this->assertEquals('The key length has to be less or equal to 255', $validator->getErrors()['key'][1]);

        $this->assertTrue($validator->validateKey($validator->validateKey(str_repeat('☃', 255))));
    }

    public function testValidate()
    {
        $validator = $this->getContextValidator();

        $this->assertFalse($validator->validateContext(new class extends Context {}));

        $validator = $this->getContextValidator();
        $context = new class(['key' => 'a key', 'value' => 'a value']) extends Context {};

        $this->assertTrue($validator->validateContext(new ArrayCollection([$context])));

        $validator = $this->getContextValidator();

        $validator->validateContext(new Bid());

        $this->assertEquals(
            ['Context has to be and instance of \Doctrine\Common\Collections\Collection'],
            $validator->getErrors()['contexts']
        );
    }

    public function testValidateWithError()
    {
        $contexts = new ArrayCollection([
            new class(['key' => 'a key', 'value' => 'a value']) extends Context {},
            new class(['key' => str_repeat('☃', 256), 'value' => 'a value']) extends Context {}
        ]);

        $validator = $this->getContextValidator();

        $this->assertFalse($validator->validateContext($contexts));
    }

    protected function getContextValidator()
    {
        return new BidValidator();
    }
}
