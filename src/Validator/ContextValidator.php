<?php

namespace Fei\Service\Bid\Validator;

use Doctrine\Common\Collections\Collection;
use Fei\Service\Bid\Entity\Context;

/**
 * Class ContextValidator
 *
 * @package Fei\Service\Bid\Validator
 */
trait ContextValidator
{
    /**
     * Validate contexts
     *
     * @param mixed $contexts
     *
     * @return bool
     */
    public function validateContext($contexts)
    {
        if (!$contexts instanceof Collection) {
            $this->addError(
                'contexts',
                'Context has to be and instance of \Doctrine\Common\Collections\Collection'
            );
            return false;
        }

        if (!$contexts->isEmpty()) {
            /** @var Context $context */
            foreach ($contexts as $context) {
                $this->validateKey($context->getKey());
            }

            if (!empty($this->getErrors())) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate key
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function validateKey($key)
    {
        if (empty($key) && $key !== 0) {
            $this->addError('key', 'The key cannot be empty');
            return false;
        }

        if (mb_strlen($key, 'UTF-8') > 255) {
            $this->addError('key', 'The key length has to be less or equal to 255');
            return false;
        }

        return true;
    }
}
