<?php

namespace Pjotr\Muis\Resources;

class Artist
{
    protected ?string $role = null;
    protected ?string $name = null;
    protected ?string $wasBorn = null;
    protected ?string $diedIn = null;


    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string|null $role
     */
    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getWasBorn(): ?string
    {
        return $this->wasBorn;
    }

    /**
     * @param string|null $wasBorn
     */
    public function setWasBorn(?string $wasBorn): void
    {
        $this->wasBorn = $wasBorn;
    }

    /**
     * @return string|null
     */
    public function getDiedIn(): ?string
    {
        return $this->diedIn;
    }

    /**
     * @param string|null $diedIn
     */
    public function setDiedIn(?string $diedIn): void
    {
        $this->diedIn = $diedIn;
    }

    public function __toString(): string
    {
        $parts = [];

        foreach ($this as $key => $value) {
            if ($value) {
                // Source: https://stackoverflow.com/a/9105079
                $parts[] = strtolower(preg_replace('/([a-z0-9])([A-Z])/', "$1 $2", $key)).': '.$value;
            }
        }

        return implode('; ', $parts);
    }
}