<?php

namespace Tests\Fei\Service\Bid\Validator;

use Codeception\Test\Unit;
use Fei\Entity\Validator\Exception;
use Fei\Service\Bid\Entity\Auction;
use Fei\Service\Bid\Entity\Bid;
use Fei\Service\Bid\Validator\AuctionValidator;

/**
 * Class AuctionValidatorTest
 *
 * @package Tests\Fei\Service\Bid\Entity
 */
class AuctionValidatorTest extends Unit
{
    /**
     * @var AuctionValidator
     */
    protected $validator;

    public function _before()
    {
        $this->validator = new AuctionValidator();
    }

    public function testValidateKeyNotEmpty()
    {
        $this->assertFalse($this->validator->validateKey(''));
        $this->assertFalse($this->validator->validateKey(0));
        $this->assertFalse($this->validator->validateKey(null));

        $this->assertCount(3, $this->validator->getErrors()['key']);
        $this->assertEquals('The key cannot be empty', $this->validator->getErrors()['key'][0]);
        $this->assertEquals('The key cannot be empty', $this->validator->getErrors()['key'][1]);
        $this->assertEquals('The key cannot be empty', $this->validator->getErrors()['key'][2]);

        $this->assertTrue($this->validator->validateKey('This is a key'));
    }

    public function testValidateKeyIsString()
    {
        $this->assertFalse($this->validator->validateKey(1));

        $this->assertCount(1, $this->validator->getErrors()['key']);
        $this->assertEquals('The key must be a string', $this->validator->getErrors()['key'][0]);

        $this->assertTrue($this->validator->validateKey('This is a key'));
    }

    public function testValidateKeyLengthLessOrEqualTo255()
    {
        $this->assertFalse($this->validator->validateKey(str_repeat('☃', 256)));
        $this->assertEquals('The key length has to be less or equal to 255', $this->validator->getErrors()['key'][0]);

        $this->assertTrue($this->validator->validateKey(str_repeat('☃', 255)));
        $this->assertTrue($this->validator->validateKey(str_repeat('a', 255)));
    }

    public function testValidateCreatedAtNotEmpty()
    {
        $this->assertFalse($this->validator->validateCreatedAt(''));
        $this->assertFalse($this->validator->validateCreatedAt(0));
        $this->assertFalse($this->validator->validateCreatedAt(null));

        $this->assertCount(3, $this->validator->getErrors()['createdAt']);
        $this->assertEquals(
            'The auction creation date time cannot be empty',
            $this->validator->getErrors()['createdAt'][0]
        );
        $this->assertEquals(
            'The auction creation date time cannot be empty',
            $this->validator->getErrors()['createdAt'][1]
        );
        $this->assertEquals(
            'The auction creation date time cannot be empty',
            $this->validator->getErrors()['createdAt'][2]
        );

        $this->assertTrue($this->validator->validateCreatedAt(new \DateTime()));
    }

    public function testValidateCreatedAtIsDateTime()
    {
        $this->assertFalse($this->validator->validateCreatedAt('notadatetime'));

        $this->assertCount(1, $this->validator->getErrors()['createdAt']);
        $this->assertEquals(
            'The auction creation date time must be a \DateTimeInterface instance',
            $this->validator->getErrors()['createdAt'][0]
        );

        $this->assertTrue($this->validator->validateCreatedAt(new \DateTime()));
    }

    public function testValidateStartAtNotEmpty()
    {
        $this->assertFalse($this->validator->validateStartAt(''));
        $this->assertFalse($this->validator->validateStartAt(0));
        $this->assertFalse($this->validator->validateStartAt(null));

        $this->assertCount(3, $this->validator->getErrors()['startAt']);
        $this->assertEquals(
            'The auction start date time cannot be empty',
            $this->validator->getErrors()['startAt'][0]
        );
        $this->assertEquals(
            'The auction start date time cannot be empty',
            $this->validator->getErrors()['startAt'][1]
        );
        $this->assertEquals(
            'The auction start date time cannot be empty',
            $this->validator->getErrors()['startAt'][2]
        );

        $this->assertTrue($this->validator->validateStartAt(new \DateTime()));
    }

    public function testValidateStartAtIsDateTime()
    {
        $this->assertFalse($this->validator->validateStartAt('notadatetime'));

        $this->assertCount(1, $this->validator->getErrors()['startAt']);
        $this->assertEquals(
            'The auction start date time must be a \DateTimeInterface instance',
            $this->validator->getErrors()['startAt'][0]
        );

        $this->assertTrue($this->validator->validateStartAt(new \DateTime()));
    }

    public function testValidateEndAtNotEmpty()
    {
        $this->assertFalse($this->validator->validateEndAt(''));
        $this->assertFalse($this->validator->validateEndAt(0));
        $this->assertFalse($this->validator->validateEndAt(null));

        $this->assertCount(3, $this->validator->getErrors()['endAt']);
        $this->assertEquals(
            'The auction end date time cannot be empty',
            $this->validator->getErrors()['endAt'][0]
        );
        $this->assertEquals(
            'The auction end date time cannot be empty',
            $this->validator->getErrors()['endAt'][1]
        );
        $this->assertEquals(
            'The auction end date time cannot be empty',
            $this->validator->getErrors()['endAt'][2]
        );

        $this->assertTrue($this->validator->validateEndAt(new \DateTime()));
    }

    public function testValidateEndAtIsDateTime()
    {
        $this->assertFalse($this->validator->validateEndAt('notadatetime'));

        $this->assertCount(1, $this->validator->getErrors()['endAt']);
        $this->assertEquals(
            'The auction end date time must be a \DateTimeInterface instance',
            $this->validator->getErrors()['endAt'][0]
        );

        $this->assertTrue($this->validator->validateEndAt(new \DateTime()));
    }

    public function testValidateEndAtGreaterThanStartAt()
    {
        $now = new \DateTime();

        $this->assertFalse($this->validator->validateAuctionInterval(null, null));
        $this->assertFalse($this->validator->validateAuctionInterval($now, null));
        $this->assertFalse($this->validator->validateAuctionInterval(null, $now));
        $this->assertFalse($this->validator->validateAuctionInterval(new \DateTime('+1 day'), $now));
        $this->assertFalse($this->validator->validateAuctionInterval($now, $now));
        $this->assertFalse($this->validator->validateAuctionInterval(1, 1));

        $this->assertCount(6, $this->validator->getErrors()['auctionInterval']);
        $this->assertEquals(
            'The start and end auction date time cannot be empty',
            $this->validator->getErrors()['auctionInterval'][0]
        );
        $this->assertEquals(
            'The start and end auction date time cannot be empty',
            $this->validator->getErrors()['auctionInterval'][1]
        );
        $this->assertEquals(
            'The start and end auction date time cannot be empty',
            $this->validator->getErrors()['auctionInterval'][2]
        );
        $this->assertEquals(
            'The end auction date time must be posterior to start auction date time',
            $this->validator->getErrors()['auctionInterval'][3]
        );
        $this->assertEquals(
            'The end auction date time must be posterior to start auction date time',
            $this->validator->getErrors()['auctionInterval'][4]
        );
        $this->assertEquals(
            'The start and end auction date time must be a \DateTimeInterface instance',
            $this->validator->getErrors()['auctionInterval'][5]
        );

        $this->assertTrue($this->validator->validateAuctionInterval($now, new \DateTime('+1 day')));
    }

    public function testValidateMinimalBidNotEmpty()
    {
        $this->assertFalse($this->validator->validateMinimalBid(''));
        $this->assertFalse($this->validator->validateMinimalBid(0));
        $this->assertFalse($this->validator->validateMinimalBid(null));

        $this->assertCount(3, $this->validator->getErrors()['minimalBid']);
        $this->assertEquals(
            'The auction minimal bid cannot be empty',
            $this->validator->getErrors()['minimalBid'][0]
        );
        $this->assertEquals(
            'The auction minimal bid must be greater than 0',
            $this->validator->getErrors()['minimalBid'][1]
        );
        $this->assertEquals(
            'The auction minimal bid cannot be empty',
            $this->validator->getErrors()['minimalBid'][2]
        );

        $this->assertTrue($this->validator->validateMinimalBid(100));
    }

    public function testValidateMinimalBidIsNumeric()
    {
        $this->assertFalse($this->validator->validateMinimalBid('notadatetime'));

        $this->assertCount(1, $this->validator->getErrors()['minimalBid']);
        $this->assertEquals(
            'The auction minimal bid must be numeric',
            $this->validator->getErrors()['minimalBid'][0]
        );

        $this->assertTrue($this->validator->validateMinimalBid(120));
        $this->assertTrue($this->validator->validateMinimalBid(120.120));
        $this->assertTrue($this->validator->validateMinimalBid('120.120'));
    }

    public function testValidateMinimalBidIsGreaterThanZero()
    {
        $this->assertFalse($this->validator->validateMinimalBid(-1));
        $this->assertFalse($this->validator->validateMinimalBid(0));

        $this->assertCount(2, $this->validator->getErrors()['minimalBid']);
        $this->assertEquals(
            'The auction minimal bid must be greater than 0',
            $this->validator->getErrors()['minimalBid'][0]
        );
        $this->assertEquals(
            'The auction minimal bid must be greater than 0',
            $this->validator->getErrors()['minimalBid'][1]
        );
    }

    public function testValidateBidStepNotEmpty()
    {
        $this->assertFalse($this->validator->validateBidStep(''));
        $this->assertFalse($this->validator->validateBidStep(0));
        $this->assertFalse($this->validator->validateBidStep(null));

        $this->assertCount(3, $this->validator->getErrors()['bidStep']);
        $this->assertEquals(
            'The auction bid step cannot be empty',
            $this->validator->getErrors()['bidStep'][0]
        );
        $this->assertEquals(
            'The auction bid step must be greater than 0',
            $this->validator->getErrors()['bidStep'][1]
        );
        $this->assertEquals(
            'The auction bid step cannot be empty',
            $this->validator->getErrors()['bidStep'][2]
        );

        $this->assertTrue($this->validator->validateBidStep(100));
    }

    public function testValidateBidStepIsNumeric()
    {
        $this->assertFalse($this->validator->validateBidStep('notadatetime'));

        $this->assertCount(1, $this->validator->getErrors()['bidStep']);
        $this->assertEquals(
            'The auction bid step must be numeric',
            $this->validator->getErrors()['bidStep'][0]
        );

        $this->assertTrue($this->validator->validateBidStep(120));
        $this->assertTrue($this->validator->validateBidStep(120.120));
        $this->assertTrue($this->validator->validateBidStep('120.120'));
    }

    public function testValidateBidStepIsGreaterThanZero()
    {
        $this->assertFalse($this->validator->validateBidStep(-1));
        $this->assertFalse($this->validator->validateBidStep(0));

        $this->assertCount(2, $this->validator->getErrors()['bidStep']);
        $this->assertEquals(
            'The auction bid step must be greater than 0',
            $this->validator->getErrors()['bidStep'][0]
        );
        $this->assertEquals(
            'The auction bid step must be greater than 0',
            $this->validator->getErrors()['bidStep'][1]
        );
    }

    public function testValidateBidStepStrategyNotEmpty()
    {
        $this->assertFalse($this->validator->validateBidStepStrategy(''));
        $this->assertFalse($this->validator->validateBidStepStrategy(null));
        $this->assertTrue($this->validator->validateBidStepStrategy(0));

        $this->assertCount(2, $this->validator->getErrors()['bidStepStrategy']);
        $this->assertEquals(
            'The auction step strategy cannot be empty',
            $this->validator->getErrors()['bidStepStrategy'][0]
        );
        $this->assertEquals(
            'The auction step strategy cannot be empty',
            $this->validator->getErrors()['bidStepStrategy'][1]
        );

        $this->assertTrue($this->validator->validateBidStepStrategy(Auction::BASIC_STRATEGY));
    }

    public function testValidateBidStepStrategyInValidValues()
    {
        $this->assertFalse($this->validator->validateBidStepStrategy('notinvalues'));

        $this->assertEquals(
            'The auction step strategy value must be 0, 1, or 2',
            $this->validator->getErrors()['bidStepStrategy'][0]
        );

        $this->assertTrue($this->validator->validateBidStepStrategy(Auction::BASIC_STRATEGY));
        $this->assertTrue($this->validator->validateBidStepStrategy(Auction::PERCENT_STRATEGY));
    }

    public function testValidateEntityType()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            sprintf('The Entity to validate must be an instance of %s', Auction::class)
        );

        $this->validator->validate(new Bid());
    }

    public function testValidateNotValid()
    {
        $this->assertFalse($this->validator->validate(new Auction()));

        $this->assertEquals([
            'key' => ['The key cannot be empty'],
            'startAt' => ['The auction start date time cannot be empty'],
            'endAt' => ['The auction end date time cannot be empty'],
            'minimalBid' => ['The auction minimal bid cannot be empty'],
            'bidStep' => ['The auction bid step cannot be empty'],
            'auctionInterval' => ['The start and end auction date time cannot be empty']
        ], $this->validator->getErrors());
    }

    public function testValidateValid()
    {
        $this->assertTrue(
            $this->validator->validate(
                (new Auction())
                    ->setKey('a key')
                    ->setStartAt(new \DateTime())
                    ->setEndAt(new \DateTime('+1 day'))
                    ->setMinimalBid(100)
                    ->setBidStep(10)
                    ->setBidStepStrategy(Auction::PERCENT_STRATEGY)
                    ->setContexts(['key' => 'value'])
            )
        );
    }
}
