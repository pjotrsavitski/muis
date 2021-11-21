<?php

namespace Pjotr\Muis\Resources\Arrays;

use Pjotr\Muis\Resources\Date;

class DatesArray extends AbstractArray
{

    protected function getItemClass(): string
    {
        return Date::class;
    }
}