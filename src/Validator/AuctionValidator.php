<?php

namespace Fei\Service\Bid\Validator;

use Fei\Entity\EntityInterface;
use Fei\Entity\Validator\AbstractValidator;
use Fei\Entity\Validator\Exception;
use Fei\Service\Bid\Entity\Auction;
use Fei\Service\Context\Validator\ContextAwareValidatorTrait;

/**
 * Class AuctionValidator
 *
 * @package Fei\Service\Bid\Validator
 */
class AuctionValidator extends AbstractValidator
{
    use ContextAwareValidatorTrait;

    /**
     * {@inheritdoc}
     */
    public function validate(EntityInterface $entity)
    {
        if (!$entity instanceof Auction) {
            throw new Exception(
                sprintf('The Entity to validate must be an instance of %s', Auction::class)
            );
        }

        $this->validateKey($entity->getKey());
        $this->validateCreatedAt($entity->getCreatedAt());
        $this->validateStartAt($entity->getStartAt());
        $this->validateEndAt($entity->getEndAt());
        $this->validateAuctionInterval($entity->getStartAt(), $entity->getEndAt());
        $this->validateMinimalBid($entity->getMinimalBid());
        $this->validateBidStep($entity->getBidStep());
        $this->validateBidStepUnit($entity->getBidStepUnit());
        $this->validateContext($entity->getContext());

        $errors = $this->getErrors();

        return empty($errors);
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
        if (empty($key)) {
            $this->addError('key', 'The key cannot be empty');
            return false;
        }

        if (!is_string($key)) {
            $this->addError('key', 'The key must be a string');
            return false;
        }

        if (mb_strlen($key, 'UTF-8') > 255) {
            $this->addError('key', 'The key length has to be less or equal to 255');
            return false;
        }

        return true;
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
            $this->addError('createdAt', 'The auction creation date time cannot be empty');
            return false;
        }

        if (!$createdAt instanceof \DateTimeInterface) {
            $this->addError('createdAt', 'The auction creation date time must be a \DateTimeInterface instance');
            return false;
        }

        return true;
    }

    /**
     * Validate beginAt
     *
     * @param mixed $startAt
     *
     * @return bool
     */
    public function validateStartAt($startAt)
    {
        if (empty($startAt)) {
            $this->addError('startAt', 'The auction start date time cannot be empty');
            return false;
        }

        if (!$startAt instanceof \DateTimeInterface) {
            $this->addError('startAt', 'The auction start date time must be a \DateTimeInterface instance');
            return false;
        }

        return true;
    }

    /**
     * Validate finishAt
     *
     * @param mixed $endAt
     *
     * @return bool
     */
    public function validateEndAt($endAt)
    {
        if (empty($endAt)) {
            $this->addError('endAt', 'The auction end date time cannot be empty');
            return false;
        }

        if (!$endAt instanceof \DateTimeInterface) {
            $this->addError('endAt', 'The auction end date time must be a \DateTimeInterface instance');
            return false;
        }

        return true;
    }

    /**
     * Validate auction period
     *
     * @param mixed $beginAt
     * @param mixed $finishAt
     *
     * @return bool
     */
    public function validateAuctionInterval($beginAt, $finishAt)
    {
        if (empty($beginAt) || empty($finishAt)) {
            $this->addError('auctionInterval', 'The start and end auction date time cannot be empty');
            return false;
        }

        if (!$beginAt instanceof \DateTimeInterface || !$finishAt instanceof \DateTimeInterface) {
            $this->addError(
                'auctionInterval',
                'The start and end auction date time must be a \DateTimeInterface instance'
            );
            return false;
        }

        if ($beginAt >= $finishAt) {
            $this->addError(
                'auctionInterval',
                'The end auction date time must be posterior to start auction date time'
            );
            return false;
        }

        return true;
    }

    /**
     * Validate minimalBid
     *
     * @param mixed $minimalBid
     *
     * @return bool
     */
    public function validateMinimalBid($minimalBid)
    {
        if (empty($minimalBid) && $minimalBid !== 0) {
            $this->addError('minimalBid', 'The auction minimal bid cannot be empty');
            return false;
        }

        if (!is_numeric($minimalBid)) {
            $this->addError('minimalBid', 'The auction minimal bid must be numeric');
            return false;
        }

        if ($minimalBid <= 0) {
            $this->addError('minimalBid', 'The auction minimal bid must be greater than 0');
            return false;
        }

        return true;
    }

    /**
     * Validate bidStep
     *
     * @param mixed $bidStep
     *
     * @return bool
     */
    public function validateBidStep($bidStep)
    {
        if (empty($bidStep) && $bidStep !== 0) {
            $this->addError('bidStep', 'The auction bid step cannot be empty');
            return false;
        }

        if (!is_numeric($bidStep)) {
            $this->addError('bidStep', 'The auction bid step must be numeric');
            return false;
        }

        if ($bidStep <= 0) {
            $this->addError('bidStep', 'The auction bid step must be greater than 0');
            return false;
        }

        return true;
    }

    /**
     * Validate stepUnit
     *
     * @param mixed $stepUnit
     *
     * @return bool
     */
    public function validateBidStepUnit($stepUnit)
    {
        if (empty($stepUnit) && $stepUnit !== 0) {
            $this->addError('bidStepUnit', 'The auction step unit cannot be empty');
            return false;
        }

        if (!is_numeric($stepUnit) || !in_array($stepUnit, [Auction::STEP_PERCENT, Auction::STEP_CURRENCY])) {
            $this->addError('bidStepUnit', 'The auction step unit value must be 0 or 1');
            return false;
        }

        return true;
    }
}
