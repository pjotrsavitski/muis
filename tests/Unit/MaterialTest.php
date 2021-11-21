<?php

beforeEach(function() {
    $this->material = new \Pjotr\Muis\Resources\Material(null, null);
});

test('assert parameters can be set and fetched', function () {
    expect($this->material->getMaterial())->toBeNull();
    expect($this->material->getNote())->toBeNull();

    $this->material->setMaterial('paper');
    $this->material->setNote('note');

    expect($this->material->getMaterial())->toBeString()->toBe('paper');
    expect($this->material->getNote())->toBeString()->toBe('note');
});

test('assert __toString() behaves as expected', function () {
    expect((string) $this->material)->toBe('');

    $this->material->setNote('note');

    expect((string) $this->material)->toBe('');

    $this->material->setMaterial('paper');

    expect((string) $this->material)->toBe('paper');
});
