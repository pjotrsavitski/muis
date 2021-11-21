<?php

namespace Pjotr\Muis\Resources\Arrays;

use Pjotr\Muis\Resources\Material;

class MaterialsArray extends AbstractArray
{
    protected function getItemClass(): string
    {
        return Material::class;
    }
}