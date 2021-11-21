<?php

namespace Pjotr\Muis\Resources;

class Date
{
    protected ?string $date;
    protected ?string $type;

    public function __construct(?string $date, ?string $type)
    {
        $this->date = $date;
        $this->type = $type;
    }

    public function __toString(): string
    {
        if ($this->date) {
            return "$this->type: $this->date";
        }

        return "$this->type";
    }
}