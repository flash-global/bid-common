<?php

namespace Fei\Service\Bid\Entity;

/**
 * Class BidContext
 *
 * @package Fei\Service\Bid\Entity
 *
 * @Entity
 */
class BidContext extends Context
{
    /**
     * @var Bid
     *
     * @ManyToOne(targetEntity="Bid", inversedBy="contexts")
     * @JoinColumn(name="bid_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $bid;

    /**
     * Get Bid
     *
     * @return Bid
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * Set Bid
     *
     * @param Bid $bid
     *
     * @return $this
     */
    public function setBid($bid)
    {
        $this->bid = $bid;

        return $this;
    }
}
