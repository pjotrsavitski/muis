<?php

namespace Pjotr\Muis\Resources;

class Material
{
    protected ?string $material;
    protected ?string $note;

    public function __construct(?string $material, ?string $note = null)
    {
        $this->material = $material;
        $this->note = $note;
    }

    /**
     * @return string|null
     */
    public function getMaterial(): ?string
    {
        return $this->material;
    }

    /**
     * @param string|null $material
     */
    public function setMaterial(?string $material): void
    {
        $this->material = $material;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string|null $note
     */
    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function __toString(): string
    {
        return (string) $this->material;
    }
}