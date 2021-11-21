<?php

beforeEach(function () {
    $this->artists = new \Pjotr\Muis\Resources\Arrays\ArtistsArray();
});

test('assert implements ArrayAccess', function () {
    expect($this->artists)->toBeInstanceOfAbstractArray();
});

test('assert throws exception ', function () {
    $this->artists[] = 'Wrong value type';
})->throws(\Exception::class, 'Value must be an instance of '.\Pjotr\Muis\Resources\Artist::class);

test('check behaviour inherited from AbstractArray', function () {
    expect(count($this->artists))->toBe(0);

    $this->artists[] = new \Pjotr\Muis\Resources\Artist();

    expect(count($this->artists))->toBe(1);

    $this->assertTrue($this->artists->offsetExists(0));
    expect($this->artists->offsetGet(0))->toBeInstanceOf(\Pjotr\Muis\Resources\Artist::class);
    expect($this->artists->offsetGet(1))->toBeNull();

    $this->artists->offsetUnset(0);
    expect(count($this->artists))->toBe(0);

    $this->artists[0] = new \Pjotr\Muis\Resources\Artist();

    expect(count($this->artists))->toBe(1);
});

test('assert __toString() behaves as expected', function () {
    expect((string) $this->artists)->toBeString()->toBe('');

    $this->artists[] = new \Pjotr\Muis\Resources\Artist();
    $this->artists[0]->setRole('author1');
    $this->artists[0]->setName('name1');
    $this->artists[0]->setWasBorn('19.05.1940');
    $this->artists[0]->setDiedIn('20.02.1980');

    expect((string) $this->artists)->toBeString()->toBe((string) $this->artists[0]);

    $this->artists[] = new \Pjotr\Muis\Resources\Artist();

    expect((string) $this->artists)->toBeString()->toBe($this->artists[0] .'; '. $this->artists[1]);
});
