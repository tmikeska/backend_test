<?php
use PHPUnit\Framework\TestCase;
use QuotesApi\DataHelper;

class UnifyingAuthorNameTest extends TestCase
{
    public function testConvertingToLowCaps(): void
    {
        $this->assertEquals(
            'steve jobs',
            DataHelper::unifyAuthorName('Steve Jobs')
        );
    }

    public function testRemovingDashes(): void
    {
        $this->assertEquals(
            'steve jobs',
            DataHelper::unifyAuthorName('Steve-Jobs')
        );
    }  

    public function testRemovingDots(): void
    {
        $this->assertEquals(
            'booker t washington',
            DataHelper::unifyAuthorName('Booker T. Washington')
        );
    } 
}