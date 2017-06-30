<?php

namespace Fei\Service\Bid\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Fei\Entity\AbstractEntity;

/**
 * Class Auction
 *
 * @package Fei\Service\Bid\Entity
 *
 * @Entity
 * @Table(
 *     name="auctions",
 *     indexes={ @Index(name="key_idx", columns={"key"}) }
 * )
 */
class Auction extends AbstractEntity
{
    const NO_STRATEGY = 2;
    const PERCENT_STRATEGY = 1;
    const BASIC_STRATEGY = 0;

    const CRITERIA_KEY = 'key';

    /**
     * @var int
     *
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @Column(type="string", name="`key`", unique=true)
     */
    protected $key;

    /**
     * @var \DateTime
     *
     * @Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Column(type="datetime")
     */
    protected $startAt;

    /**
     * @var \DateTime
     *
     * @Column(type="datetime")
     */
    protected $endAt;

    /**
     * @var float
     *
     * @Column(type="float")
     */
    protected $minimalBid;

    /**
     * @var float
     *
     * @Column(type="float")
     */
    protected $bidStep;

    /**
     * @var int
     *
     * @Column(type="integer")
     */
    protected $bidStepStrategy = self::BASIC_STRATEGY;

    /**
     * @var ArrayCollection
     *
     * @OneToMany(targetEntity="Bid", mappedBy="auction", cascade={"all"})
     */
    protected $bids;

    /**
     * @var ArrayCollection
     *
     * @OneToMany(targetEntity="AuctionContext", mappedBy="auction", cascade={"all"})
     */
    protected $contexts;

    /**
     * Auction constructor.
     *
     * @param array $data
     */
    public function __construct($data = null)
    {
        $this->setCreatedAt(new \DateTime());
        $this->setBids(new ArrayCollection());
        $this->contexts = new ArrayCollection();

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
     * Get BidStepStrategy
     *
     * @return int
     */
    public function getBidStepStrategy()
    {
        return $this->bidStepStrategy;
    }

    /**
     * Set BidStepStrategy
     *
     * @param int $bidStepStrategy
     *
     * @return $this
     */
    public function setBidStepStrategy($bidStepStrategy)
    {
        $this->bidStepStrategy = $bidStepStrategy;
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
     * Get Contexts
     *
     * @return ArrayCollection
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    /**
     * Set Contexts
     *
     * @param ArrayCollection|AuctionContext|array $context
     *
     * @return $this
     */
    public function setContexts($context)
    {
        if ($context instanceof AuctionContext) {
            $context->setAuction($this);
            $context = array($context);
        }

        if ($context instanceof \ArrayObject || is_array($context) || $context instanceof \Iterator) {
            foreach ($context as $key => $value) {
                if (!$value instanceof Context) {
                    $value = $value instanceof \stdClass ? (array) $value : $value;

                    if (is_int($key)
                        && is_array($value)
                        && array_key_exists('key', $value)
                        && array_key_exists('value', $value)
                    ) {
                        $contextData = array('key' => $value['key'], 'value' => $value['value']);

                        if (isset($value['id'])) {
                            $contextData['id'] = $value['id'];
                        }
                    } else {
                        $contextData = array('key' => $key, 'value' => $value);
                    }

                    $value = new AuctionContext($contextData);
                }

                $value->setAuction($this);
                $this->contexts->add($value);
            }
        }

        return $this;
    }

    /**
     * Add a context
     *
     * @param AuctionContext $context
     *
     * @return $this
     */
    public function addContext(AuctionContext $context)
    {
        $context->setAuction($this);
        $this->getContexts()->add($context);

        return $this;
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

        if (!empty($data['contexts'])) {
            $context = array();
            foreach ($data['contexts'] as $key => $value) {
                $context[$key] = $value->toArray();
                unset($context[$key]['auction']);
            }
            $data['contexts'] = $context;
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

        parent::hydrate($data);
    }
}
