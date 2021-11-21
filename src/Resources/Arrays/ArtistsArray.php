<?php

namespace Pjotr\Muis\Resources\Arrays;

use Pjotr\Muis\Resources\Artist;

class ArtistsArray extends AbstractArray
{

    protected function getItemClass(): string
    {
        return Artist::class;
    }
}