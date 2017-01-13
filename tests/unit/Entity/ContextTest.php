<?php

namespace Tests\Fei\Service\Bid\Entity;

use Codeception\Test\Unit;
use Fei\Service\Bid\Entity\Context;

/**
 * Class ContextTest
 *
 * @package Tests\Fei\Service\Bid\Entity
 */
class ContextTest extends Unit
{
    public function testId()
    {
        $context = $this->getContextInstance();
        $context->setId(1);

        $this->assertEquals(1, $context->getId());
        $this->assertAttributeEquals($context->getId(), 'id', $context);
    }

    public function testKey()
    {
        $context = $this->getContextInstance();
        $context->setKey(1);

        $this->assertEquals(1, $context->getKey());
        $this->assertAttributeEquals($context->getKey(), 'key', $context);
    }

    public function testValue()
    {
        $context = $this->getContextInstance();
        $context->setValue(1);

        $this->assertEquals(1, $context->getValue());
        $this->assertAttributeEquals($context->getValue(), 'value', $context);
    }

    protected function getContextInstance()
    {
        return new class extends Context
        {
        };
    }
}
