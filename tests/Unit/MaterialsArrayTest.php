<?php

beforeEach(function () {
    $this->materials = new \Pjotr\Muis\Resources\Arrays\MaterialsArray();
});

test('assert implements ArrayAccess', function () {
    expect($this->materials)->toBeInstanceOfAbstractArray();
});

test('assert throws exception ', function () {
    $this->materials[] = 'Wrong value type';
})->throws(\Exception::class, 'Value must be an instance of '.\Pjotr\Muis\Resources\Material::class);