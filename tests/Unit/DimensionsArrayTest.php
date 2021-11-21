<?php

beforeEach(function () {
    $this->dimensions = new \Pjotr\Muis\Resources\Arrays\DimensionsArray();
});

test('assert implements ArrayAccess', function () {
    expect($this->dimensions)->toBeInstanceOfAbstractArray();
});

test('assert throws exception ', function () {
    $this->dimensions[] = 'Wrong value type';
})->throws(\Exception::class, 'Value must be an instance of '.\Pjotr\Muis\Resources\Dimension::class);