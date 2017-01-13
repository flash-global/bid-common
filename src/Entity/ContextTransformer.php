<?php

namespace Fei\Service\Bid\Entity;

use League\Fractal\TransformerAbstract;

/**
 * Class ContextTransformer
 *
 * @package Fei\Service\Filer\Entity
 */
class ContextTransformer extends TransformerAbstract
{
    /**
     * Transform Context
     *
     * @param Context $context
     *
     * @return array
     */
    public function transform(Context $context)
    {
        return array(
            'id' => (int)$context->getId(),
            'key' => $context->getKey(),
            'value' => $context->getValue()
        );
    }
}
