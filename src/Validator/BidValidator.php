<?php

namespace Fei\Service\Bid\Validator;

use Fei\Entity\EntityInterface;
use Fei\Entity\Validator\AbstractValidator;
use Fei\Entity\Validator\Exception;
use Fei\Service\Bid\Entity\Auction;
use Fei\Service\Bid\Entity\Bid;

/**
 * Class BidValidator
 *
 * @package Fei\Service\Bid\Validator
 */
class BidValidator extends AbstractValidator
{
    use ContextValidator;

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

        $isCreatedAtValid = $this->validateCreatedAt($entity->getCreatedAt());
        $isAmountValid = $this->validateAmount($entity->getAmount());
        $this->validateBidder($entity->getBidder());
        $this->validateContext($entity->getContexts());

        if ($isCreatedAtValid
            && $isAmountValid
            && $entity->getAuction() !== null
            && $this->validateAuction($entity->getAuction())
        ) {
            $this->validateCreatedAtByAuction($entity->getCreatedAt(), $entity->getAuction());
            $this->validateAmountByAuction($entity->getAmount(), $entity->getAuction());
        }

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

        if (!$createdAt instanceof \DateTimeInterface) {
            $this->addError('createdAt', 'The bid creation date time must be a \DateTimeInterface instance');
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

    /**
     * Validate associated Auction entity
     *
     * @param Auction $auction
     *
     * @return bool
     */
    public function validateAuction($auction)
    {
        if (!$auction instanceof Auction) {
            $this->addError(
                'auction',
                sprintf('The auction associated to the current bid must be a instance of %s.', Auction::class)
            );
            return false;
        }

        $validator = new AuctionValidator();

        if (!$validator->validate($auction)) {
            $this->addError(
                'auction',
                'The auction associated to the current bid must be valid - ' . $validator->getErrorsAsString()
            );
            return false;
        }

        return true;
    }

    /**
     * Validate createdAt in relation of associated Auction state
     *
     * @param \DateTimeInterface $createAt
     * @param Auction            $auction
     *
     * @return bool
     */
    public function validateCreatedAtByAuction(\DateTimeInterface $createAt, Auction $auction)
    {
        if ($createAt < $auction->getStartAt() || $createAt > $auction->getEndAt()) {
            $this->addError(
                'auction',
                sprintf(
                    'The bid creation date time must be in auction interval date time validity.'
                    . ' Given %s, not between %s and %s',
                    $createAt->format(\DateTime::ISO8601),
                    $auction->getStartAt()->format(\DateTime::ISO8601),
                    $auction->getEndAt()->format(\DateTime::ISO8601)
                )
            );
            return false;
        }

        return true;
    }

    /**
     * Validate amount in relation of associated Auction state
     *
     * @param float   $amount
     * @param Auction $auction
     *
     * @return bool
     */
    public function validateAmountByAuction($amount, Auction $auction)
    {
        if ($amount < $auction->getMinimalBid()) {
            $this->addError(
                'auction',
                sprintf(
                    'The bid amount must be greater than auction minimal bid. Given %f, not greater than %f',
                    $amount,
                    $auction->getMinimalBid()
                )
            );
            return false;
        }

        return true;
    }
}
