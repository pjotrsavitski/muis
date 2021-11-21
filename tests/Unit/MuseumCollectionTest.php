<?php

beforeEach(function() {
    $this->collection = new \Pjotr\Muis\MuseumCollection(getCollectionFile());
});

test('assert collection has resources', function () {
    expect($this->collection->getResources())->not()->toBeEmpty();
});

test('assert collection has right resources count', function() {
    expect(count($this->collection->getResources()))->toBe(61204);
    expect($this->collection->getResourcesCount())->toBe(61204);
});