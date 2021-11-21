<?php

test('assert __toString() behaves as expected', function () {
    $date = new \Pjotr\Muis\Resources\Date(null, null);

    expect((string) $date)->toBe('');

    $date = new \Pjotr\Muis\Resources\Date(null, 'painting');

    expect((string) $date)->toBe('painting');

    $date = new \Pjotr\Muis\Resources\Date('19.02.1953', null);

    expect((string) $date)->toBe(': 19.02.1953');

    $date = new \Pjotr\Muis\Resources\Date('19.02.1953', 'painting');

    expect((string) $date)->toBe('painting: 19.02.1953');
});
