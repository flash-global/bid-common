<?php

namespace Fei\Service\Bid\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Fei\Entity\AbstractEntity;
use Fei\Service\Context\ContextAwareTrait;

/**
 * Class Auction
 *
 * @package Fei\Service\Bid\Entity
 */
class Auction extends AbstractEntity
{
    use ContextAwareTrait {
        hydrate as protected hydrateContext;
    }

    const STEP_PERCENT = 1;
    const STEP_CURRENCY = 0;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $startAt;

    /**
     * @var \DateTime
     */
    protected $endAt;

    /**
     * @var float
     */
    protected $minimalBid;

    /**
     * @var float
     */
    protected $bidStep;

    /**
     * @var int
     */
    protected $bidStepUnit = self::STEP_CURRENCY;

    /**
     * @var ArrayCollection
     */
    protected $bids;

    /**
     * Auction constructor.
     *
     * @param array $data
     */
    public function __construct($data = null)
    {
        $this->setCreatedAt(new \DateTime());
        $this->setBids(new ArrayCollection());

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
     * Get Key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set Key
     *
     * @param string $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
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
     * Get StartAt
     *
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set StartAt
     *
     * @param string|\DateTime $startAt
     *
     * @return $this
     */
    public function setStartAt($startAt)
    {
        if (is_string($startAt)) {
            $startAt = new \DateTime($startAt);
        }

        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get EndAt
     *
     * @return \DateTime
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set EndAt
     *
     * @param string|\DateTime $endAt
     *
     * @return $this
     */
    public function setEndAt($endAt)
    {
        if (is_string($endAt)) {
            $endAt = new \DateTime($endAt);
        }

        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get MinimalBid
     *
     * @return float
     */
    public function getMinimalBid()
    {
        return $this->minimalBid;
    }

    /**
     * Set MinimalBid
     *
     * @param float $minimalBid
     *
     * @return $this
     */
    public function setMinimalBid($minimalBid)
    {
        $this->minimalBid = $minimalBid;
        return $this;
    }

    /**
     * Get BidStep
     *
     * @return float
     */
    public function getBidStep()
    {
        return $this->bidStep;
    }

    /**
     * Set BidStep
     *
     * @param float $bidStep
     *
     * @return $this
     */
    public function setBidStep($bidStep)
    {
        $this->bidStep = $bidStep;
        return $this;
    }

    /**
     * Get BidStepUnit
     *
     * @return int
     */
    public function getBidStepUnit()
    {
        return $this->bidStepUnit;
    }

    /**
     * Set BidStepUnit
     *
     * @param int $bidStepUnit
     *
     * @return $this
     */
    public function setBidStepUnit($bidStepUnit)
    {
        $this->bidStepUnit = $bidStepUnit;
        return $this;
    }

    /**
     * Get Bids
     *
     * @return ArrayCollection
     */
    public function getBids()
    {
        return $this->bids;
    }

    /**
     * Set Bids
     *
     * @param ArrayCollection $bids
     *
     * @return $this
     */
    public function setBids(ArrayCollection $bids = null)
    {
        if (!empty($bids)) {
            foreach ($bids as $bid) {
                $bid->setAuction($this);
            }
        }

        $this->bids = $bids;

        return $this;
    }

    /**
     * Add a bid
     *
     * @param Bid $bid
     *
     * @return $this
     */
    public function addBid(Bid $bid)
    {
        $bid->setAuction($this);
        $this->bids->add($bid);

        return $this;
    }

    /**
     * Clear bids collection
     */
    public function clearBids()
    {
        $this->bids->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($mapped = false)
    {
        $data = parent::toArray($mapped);

        if (!empty($data['bids'])) {
            $bids = [];
            foreach ($data['bids'] as $value) {
                $bids[] = $value->toArray();
            }
            $data['bids'] = $bids;
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate($data)
    {
        if (isset($data['bids']) && is_array($data['bids'])) {
            $bids = [];
            foreach ($data['bids'] as $bid) {
                $bids[] = new Bid($bid);
            }
            $data['bids'] = new ArrayCollection($bids);
        }

        $this->hydrateContext($data);
    }
}
