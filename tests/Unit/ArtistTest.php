<?php

beforeEach(function() {
    $this->artist = new \Pjotr\Muis\Resources\Artist();
});

test('assert parameters are initially empty', function () {
    expect($this->artist->getRole())->toBeNull();
    expect($this->artist->getName())->toBeNull();
    expect($this->artist->getWasBorn())->toBeNull();
    expect($this->artist->getDiedIn())->toBeNull();
});

test('assert parameters can be set and fetched', function () {
    $this->artist->setRole(null);
    $this->artist->setName(null);
    $this->artist->setWasBorn(null);
    $this->artist->setDiedIn(null);

    expect($this->artist->getRole())->toBeNull();
    expect($this->artist->getName())->toBeNull();
    expect($this->artist->getWasBorn())->toBeNull();
    expect($this->artist->getDiedIn())->toBeNull();

    $this->artist->setRole('painter');
    $this->artist->setName('John Doe');
    $this->artist->setWasBorn('19.02.1953');
    $this->artist->setDiedIn('21.03.2001');

    expect($this->artist->getRole())->toBeString()->toBe('painter');
    expect($this->artist->getName())->toBeString()->toBe('John Doe');
    expect($this->artist->getWasBorn())->toBeString()->toBe('19.02.1953');
    expect($this->artist->getDiedIn())->toBeString()->toBe('21.03.2001');
});

test('assert __toString() behaves as expected', function () {
    expect((string) $this->artist)->toBeString()->toBe('');

    $this->artist->setRole('painter');
    $this->artist->setName('John Doe');
    $this->artist->setWasBorn('19.02.1953');
    $this->artist->setDiedIn('21.03.2001');

    expect((string) $this->artist)->toBeString()->toBe('role: painter; name: John Doe; was born: 19.02.1953; died in: 21.03.2001');
});