<?php

beforeEach(function () {
    $this->dates = new \Pjotr\Muis\Resources\Arrays\DatesArray();
});

test('assert implements ArrayAccess', function () {
    expect($this->dates)->toBeInstanceOfAbstractArray();
});

test('assert throws exception ', function () {
    $this->dates[] = 'Wrong value type';
})->throws(\Exception::class, 'Value must be an instance of '.\Pjotr\Muis\Resources\Date::class);