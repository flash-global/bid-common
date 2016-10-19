<?php

namespace Fei\Service\Bid\Entity;

use Fei\Entity\AbstractEntity;
use Fei\Service\Context\ContextAwareTrait;

/**
 * Class Bid
 *
 * @package Fei\Service\Bid\Entity
 */
class Bid extends AbstractEntity
{
    use ContextAwareTrait {
        hydrate as protected hydrateContext;
    }

    /**
     * @var int
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var string
     */
    protected $bidder;

    /**
     * @var Auction
     */
    protected $auction;

    /**
     * Bid constructor.
     *
     * @param array $data
     */
    public function __construct($data = null)
    {
        $this->setCreatedAt(new \DateTime());

        parent::__construct($data);
    }

    /**
     * Get Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get CreatedAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set CreatedAt
     *
     * @param string|\DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        if (is_string($createdAt)) {
            $createdAt = new \DateTime($createdAt);
        }

        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get Amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set Amount
     *
     * @param float $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Get Bidder
     *
     * @return string
     */
    public function getBidder()
    {
        return $this->bidder;
    }

    /**
     * Set Bidder
     *
     * @param string $bidder
     *
     * @return $this
     */
    public function setBidder($bidder)
    {
        $this->bidder = $bidder;
        return $this;
    }

    /**
     * Get Auction
     *
     * @return Auction
     */
    public function getAuction()
    {
        return $this->auction;
    }

    /**
     * Set Auction
     *
     * @param Auction $auction
     *
     * @return $this
     */
    public function setAuction(Auction $auction)
    {
        $this->auction = $auction;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($mapped = false)
    {
        $data = parent::toArray($mapped);

        if (!empty($data['auction']) && $data['auction'] instanceof Auction) {
            $data['auction_id'] = $data['auction']->getId();
            unset($data['auction']);
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate($data)
    {
        if (isset($data['auction']) && is_array($data['auction'])) {
            $data['auction'] = new Auction($data['auction']);
        }

        $this->hydrateContext($data);
    }
}
