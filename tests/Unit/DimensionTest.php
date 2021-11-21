<?php

test('assert __toString() behaves as expected', function () {
    $dimension = new \Pjotr\Muis\Resources\Dimension(null, null, null, null);

    expect((string) $dimension)->toBe(':  ');

    $dimension = new \Pjotr\Muis\Resources\Dimension('cm', 'width', '10', null);

    expect((string) $dimension)->toBe('width: 10 cm');

    $dimension = new \Pjotr\Muis\Resources\Dimension('cm', 'width', '10', 'note');

    expect((string) $dimension)->toBe('width: 10 cm (note)');
});