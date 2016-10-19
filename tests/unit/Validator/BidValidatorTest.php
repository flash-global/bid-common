<?php

namespace Tests\Fei\Service\Bid\Entity;

use Codeception\Test\Unit;
use Fei\Entity\Validator\Exception;
use Fei\Service\Bid\Entity\Auction;
use Fei\Service\Bid\Entity\Bid;
use Fei\Service\Bid\Validator\BidValidator;

/**
 * Class BidValidatorTest
 *
 * @package Tests\Fei\Service\Bid\Entity
 */
class BidValidatorTest extends Unit
{
    /**
     * @var BidValidator
     */
    protected $validator;

    public function _before()
    {
        $this->validator = new BidValidator();
    }

    public function testValidateCreatedAtNotEmpty()
    {
        $this->assertFalse($this->validator->validateCreatedAt(''));
        $this->assertFalse($this->validator->validateCreatedAt(0));
        $this->assertFalse($this->validator->validateCreatedAt(null));

        $this->assertCount(3, $this->validator->getErrors()['createdAt']);
        $this->assertEquals(
            'The bid creation date time cannot be empty',
            $this->validator->getErrors()['createdAt'][0]
        );
        $this->assertEquals(
            'The bid creation date time cannot be empty',
            $this->validator->getErrors()['createdAt'][1]
        );
        $this->assertEquals(
            'The bid creation date time cannot be empty',
            $this->validator->getErrors()['createdAt'][2]
        );

        $this->assertTrue($this->validator->validateCreatedAt(new \DateTime()));
    }

    public function testValidateCreatedAtIsDateTime()
    {
        $this->assertFalse($this->validator->validateCreatedAt('notadatetime'));

        $this->assertCount(1, $this->validator->getErrors()['createdAt']);
        $this->assertEquals(
            'The bid creation date time must be a \DateTime instance',
            $this->validator->getErrors()['createdAt'][0]
        );

        $this->assertTrue($this->validator->validateCreatedAt(new \DateTime()));
    }

    public function testValidateAmountNotEmpty()
    {
        $this->assertFalse($this->validator->validateAmount(''));
        $this->assertFalse($this->validator->validateAmount(0));
        $this->assertFalse($this->validator->validateAmount(null));

        $this->assertCount(3, $this->validator->getErrors()['amount']);
        $this->assertEquals(
            'The bid amount cannot be empty',
            $this->validator->getErrors()['amount'][0]
        );
        $this->assertEquals(
            'The bid amount must be greater than 0',
            $this->validator->getErrors()['amount'][1]
        );
        $this->assertEquals(
            'The bid amount cannot be empty',
            $this->validator->getErrors()['amount'][2]
        );

        $this->assertTrue($this->validator->validateAmount(100));
    }

    public function testValidateAmountIsNumeric()
    {
        $this->assertFalse($this->validator->validateAmount('notadatetime'));

        $this->assertCount(1, $this->validator->getErrors()['amount']);
        $this->assertEquals(
            'The bid amount must be numeric',
            $this->validator->getErrors()['amount'][0]
        );

        $this->assertTrue($this->validator->validateAmount(120));
        $this->assertTrue($this->validator->validateAmount(120.120));
        $this->assertTrue($this->validator->validateAmount('120.120'));
    }

    public function testValidateAmountGreaterThanZero()
    {
        $this->assertFalse($this->validator->validateAmount(-1));
        $this->assertFalse($this->validator->validateAmount(0));

        $this->assertCount(2, $this->validator->getErrors()['amount']);
        $this->assertEquals(
            'The bid amount must be greater than 0',
            $this->validator->getErrors()['amount'][0]
        );
        $this->assertEquals(
            'The bid amount must be greater than 0',
            $this->validator->getErrors()['amount'][1]
        );
    }

    public function testValidateBidderNotEmpty()
    {
        $this->assertFalse($this->validator->validateBidder(''));
        $this->assertFalse($this->validator->validateBidder(0));
        $this->assertFalse($this->validator->validateBidder(null));

        $this->assertCount(3, $this->validator->getErrors()['bidder']);
        $this->assertEquals('The bidder identification cannot be empty', $this->validator->getErrors()['bidder'][0]);
        $this->assertEquals('The bidder identification cannot be empty', $this->validator->getErrors()['bidder'][1]);
        $this->assertEquals('The bidder identification cannot be empty', $this->validator->getErrors()['bidder'][2]);

        $this->assertTrue($this->validator->validateBidder('This is a bidder'));
    }

    public function testValidateBidderIsString()
    {
        $this->assertFalse($this->validator->validateBidder(1));

        $this->assertCount(1, $this->validator->getErrors()['bidder']);
        $this->assertEquals('The bidder identification must be a string', $this->validator->getErrors()['bidder'][0]);

        $this->assertTrue($this->validator->validateBidder('This is a bidder'));
    }

    public function testValidateBidderLengthLessOrEqualTo255()
    {
        $this->assertFalse($this->validator->validateBidder(str_repeat('☃', 256)));
        $this->assertEquals(
            'The bidder identification length has to be less or equal to 255',
            $this->validator->getErrors()['bidder'][0]
        );

        $this->assertTrue($this->validator->validateBidder(str_repeat('☃', 255)));
        $this->assertTrue($this->validator->validateBidder(str_repeat('a', 255)));
    }

    public function testValidateEntityType()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            sprintf('The Entity to validate must be an instance of %s', Bid::class)
        );

        $this->validator->validate(new Auction());
    }

    public function testValidateNotValid()
    {
        $this->assertFalse($this->validator->validate(new Bid()));

        $this->assertEquals([
            'amount' => ['The bid amount cannot be empty'],
            'bidder' => ['The bidder identification cannot be empty']
        ], $this->validator->getErrors());
    }

    public function testValidateValid()
    {
        $this->assertTrue(
            $this->validator->validate(
                (new Bid())
                    ->setAmount(120)
                    ->setBidder('a bidder')
                    ->setContext(['key' => 'value'])
            )
        );
    }
}
