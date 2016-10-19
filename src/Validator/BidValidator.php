<?php

namespace Fei\Service\Bid\Validator;

use Fei\Entity\EntityInterface;
use Fei\Entity\Validator\AbstractValidator;
use Fei\Entity\Validator\Exception;
use Fei\Service\Bid\Entity\Bid;
use Fei\Service\Context\Validator\ContextAwareValidatorTrait;

/**
 * Class BidValidator
 *
 * @package Fei\Service\Bid\Validator
 */
class BidValidator extends AbstractValidator
{
    use ContextAwareValidatorTrait;

    /**
     * {@inheritdoc}
     */
    public function validate(EntityInterface $entity)
    {
        if (!$entity instanceof Bid) {
            throw new Exception(
                sprintf('The Entity to validate must be an instance of %s', Bid::class)
            );
        }

        $this->validateCreatedAt($entity->getCreatedAt());
        $this->validateAmount($entity->getAmount());
        $this->validateBidder($entity->getBidder());
        $this->validateContext($entity->getContext());

        $errors = $this->getErrors();

        return empty($errors);
    }

    /**
     * Validate createdAt
     *
     * @param mixed $createdAt
     *
     * @return bool
     */
    public function validateCreatedAt($createdAt)
    {
        if (empty($createdAt)) {
            $this->addError('createdAt', 'The bid creation date time cannot be empty');
            return false;
        }

        if (!$createdAt instanceof \DateTime) {
            $this->addError('createdAt', 'The bid creation date time must be a \DateTime instance');
            return false;
        }

        return true;
    }

    /**
     * Validate amount
     *
     * @param mixed $amount
     *
     * @return bool
     */
    public function validateAmount($amount)
    {
        if (empty($amount) && $amount !== 0) {
            $this->addError('amount', 'The bid amount cannot be empty');
            return false;
        }

        if (!is_numeric($amount)) {
            $this->addError('amount', 'The bid amount must be numeric');
            return false;
        }

        if ($amount <= 0) {
            $this->addError('amount', 'The bid amount must be greater than 0');
            return false;
        }

        return true;
    }

    /**
     * Validate bidder
     *
     * @param mixed $bidder
     *
     * @return bool
     */
    public function validateBidder($bidder)
    {
        if (empty($bidder)) {
            $this->addError('bidder', 'The bidder identification cannot be empty');
            return false;
        }

        if (!is_string($bidder)) {
            $this->addError('bidder', 'The bidder identification must be a string');
            return false;
        }

        if (mb_strlen($bidder, 'UTF-8') > 255) {
            $this->addError('bidder', 'The bidder identification length has to be less or equal to 255');
            return false;
        }

        return true;
    }
}
