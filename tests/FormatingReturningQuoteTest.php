<?php
use PHPUnit\Framework\TestCase;
use QuotesApi\DataHelper;

class FormatingReturningQuoteTest extends TestCase
{
    public function testRemovingEmptySpaces(): void
    {
        $this->assertEquals(
            'THIS IS MY QUOTE!',
            DataHelper::formatReturningQuote(' this is my quote ')
        );
    }

    public function testUpperCases(): void
    {
        $this->assertEquals(
            'THIS IS MY QUOTE!',
            DataHelper::formatReturningQuote('this is my quote')
        );
    }  

    public function testExclamationMarkOnTheEndOfQuote(): void
    {
        $this->assertEquals(
            'THIS IS MY QUOTE!',
            DataHelper::formatReturningQuote('this is my quote')
        );
    } 

    public function testExclamationMarkReplacingDot(): void
    {
        $this->assertEquals(
            'THIS IS MY QUOTE!',
            DataHelper::formatReturningQuote('this is my quote.')
        );
    }    

    public function testExclamationMarkKeptIfPresent(): void
    {
        $this->assertEquals(
            'THIS IS MY QUOTE!',
            DataHelper::formatReturningQuote('this is my quote!')
        );
    }      
}