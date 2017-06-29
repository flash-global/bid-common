<?php

namespace Fei\Service\Bid\Entity;

/**
 * Class AuctionContext
 *
 * @package Fei\Service\Bid\Entity
 *
 * @Entity
 */
class AuctionContext extends Context
{
    /**
     * @var Auction
     *
     * @ManyToOne(targetEntity="Auction", inversedBy="contexts")
     * @JoinColumn(name="auction_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $auction;

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
}
