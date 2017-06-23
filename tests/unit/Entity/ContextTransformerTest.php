<?php

namespace Tests\Fei\Service\Bid\Entity;

use Codeception\Test\Unit;
use Fei\Service\Bid\Entity\Context;
use Fei\Service\Bid\Entity\ContextTransformer;

class ContextTransformerTest extends Unit
{
    public function testTransform()
    {
        $transformer = new ContextTransformer();

        $this->assertEquals(
            ['id' => 0, 'key' => 'a key', 'value' => 'a value'],
            $transformer->transform(new class (['key' => 'a key', 'value' => 'a value']) extends Context {})
        );
    }
}
