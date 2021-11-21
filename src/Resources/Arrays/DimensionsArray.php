<?php

namespace Pjotr\Muis\Resources\Arrays;

use Pjotr\Muis\Resources\Dimension;

class DimensionsArray extends AbstractArray
{

    protected function getItemClass(): string
    {
        return Dimension::class;
    }
}