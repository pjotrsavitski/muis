<?php

namespace Pjotr\Muis\Resources;

class Dimension
{
    protected ?string $unit;
    protected ?string $type;
    protected ?string $value;
    protected ?string $note;

    public function __construct(?string $unit, ?string $type, ?string $value, ?string $note)
    {
        $this->unit = $unit;
        $this->type = $type;
        $this->value = $value;
        $this->note = $note;
    }

    public function __toString(): string
    {
        $data = "$this->type: $this->value $this->unit";

        if ($this->note) {
            $data .= " ($this->note)";
        }

        return $data;
    }
}