<?php

use App\ValueObjects\Price;

test('all', function () {
    $price = Price::make(10000);

    $this->assertInstanceOf(Price::class, $price);
    $this->assertEquals(100, $price->value());
    $this->assertEquals(10000, $price->raw());
    $this->assertEquals('RUB', $price->currency());
    $this->assertEquals('₽', $price->symbol());
    $this->assertEquals('100 ₽', $price);

    $this->expectException(InvalidArgumentException::class);

    Price::make(-1000);
    Price::make(1000, 'USD');
});
