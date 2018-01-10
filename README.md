# Service Bid - Common

[![GitHub release](https://img.shields.io/github/release/flash-global/bid-common.svg?style=for-the-badge)](README.md)

## Table of contents
- [Entities](#entities)
- [Contribution](#contribution)

## Entities

### Auction
| Properties    | Type              | Required | Default value |
|---------------|-------------------|----------|---------------|
| id          | `int`      | No       |               |
| createdAt          | `datetime`      | No       | Now()              |
| key     | `string`        | Yes       |          |
| startAt     | `datetime`          | Yes       |              |
| endAt     | `datetime`          | Yes       |              |
| minimalBid     | `float`          | Yes       |               |
| bidStep     | `float`          | Yes       |               |
| bidStepStrategy     | `int`          | Yes       |               |
| bids     | `ArrayCollection`          | No       |               |
| contexts     | `ArrayCollection`          | No       |               |


### AuctionContext
| Properties    | Type              | Required | Default value |
|---------------|-------------------|----------|---------------|
| id          | `int`      | No       |               |
| auction          | `Auction`      | Yes       |               |
| key     | `string`        | Yes       |          |
| value     | `string`          | Yes       |               |


### Bid
| Properties    | Type              | Required | Default value |
|---------------|-------------------|----------|---------------|
| id          | `int`      | No       |               |
| createdAt          | `datetime`      | No       | Now()              |
| status     | `int`        | Yes       | 1         |
| amount     | `float`          | Yes       |              |
| bidder     | `string`          | Yes       |              |
| auction     | `ArrayCollection`          | No       |               |
| contexts     | `ArrayCollection`          | No       |               |


### BidContext
| Properties    | Type              | Required | Default value |
|---------------|-------------------|----------|---------------|
| id          | `int`      | No       |               |
| bid          | `Bid`      | Yes       |               |
| key     | `string`        | Yes       |          |
| value     | `string`          | Yes       |               |


## Contribution
As FEI Service, designed and made by OpCoding. The contribution workflow will involve both technical teams. Feel free to contribute, to improve features and apply patches, but keep in mind to carefully deal with pull request. Merging must be the product of complete discussions between Flash and OpCoding teams :) 



