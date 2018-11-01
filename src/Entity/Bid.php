<?php

namespace Fei\Service\Bid\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Fei\Entity\AbstractEntity;

/**
 * Class Bid
 *
 * @package Fei\Service\Bid\Entity
 *
 * @Entity
 * @Table(
 *     name="bids",
 *     indexes={ @Index(name="bidder_idx", columns={"bidder"}) }
 * )
 */
class Bid extends AbstractEntity
{
    const STATUS_ONGOING = 1;
    const STATUS_REFUSED = 2;
    const STATUS_ACCEPTED = 4;
    const STATUS_EXPIRED = 8;

    /**
     * @var int
     *
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var \DateTimeInterface
     *
     * @Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface
     *
     * @Column(type="datetime")
     */
    protected $expiredAt;

    /**
     * @var int
     *
     * @Column(type="integer")
     */
    protected $status;

    /**
     * @var float
     *
     * @Column(type="float")
     */
    protected $amount;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    protected $bidder;

    /**
     * @var Auction
     *
     * @ManyToOne(targetEntity="Auction")
     * @JoinColumn(name="auction_id", referencedColumnName="id")
     */
    protected $auction;

    /**
     * @var ArrayCollection
     *
     * @OneToMany(targetEntity="BidContext", mappedBy="bid", cascade={"all"})
     */
    protected $contexts;

    /**
     * Bid constructor.
     *
     * @param array $data
     */
    public function __construct($data = null)
    {
        $this->contexts = new ArrayCollection();
        $this->setStatus(self::STATUS_ONGOING);
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
     * @return \DateTimeInterface
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set CreatedAt
     *
     * @param string|\DateTimeInterface $createdAt
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
     * Get ExpiredAt
     *
     * @return \DateTimeInterface
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * Set ExpiredAt
     *
     * @param string|\DateTimeInterface $expiredAt
     *
     * @return $this
     */
    public function setExpiredAt($expiredAt)
    {
        if (is_string($expiredAt)) {
            $expiredAt = new \DateTime($expiredAt);
        }

        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * Get Status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set Status
     *
     * @param int $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * @param ArrayCollection|BidContext|array $context
     *
     * @return $this
     */
    public function setContexts($context)
    {
        if ($context instanceof BidContext) {
            $context->setBid($this);
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

                    $value = new BidContext($contextData);
                }

                $value->setBid($this);
                $this->contexts->add($value);
            }
        }

        return $this;
    }

    /**
     * Add a context
     *
     * @param BidContext $context
     *
     * @return $this
     */
    public function addContext(BidContext $context)
    {
        $context->setBid($this);
        $this->getContexts()->add($context);

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

        if (!empty($data['contexts'])) {
            $context = array();
            foreach ($data['contexts'] as $key => $value) {
                $context[$key] = $value->toArray();
                unset($context[$key]['bid']);
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
        if (isset($data['auction']) && is_array($data['auction'])) {
            $data['auction'] = new Auction($data['auction']);
        }

        parent::hydrate($data);
    }
}
