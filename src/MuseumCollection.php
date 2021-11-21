<?php

namespace Pjotr\Muis;

class MuseumCollection
{
    const PATTERN = '/<crm:P46_is_composed_of rdf:resource="(.*)"\/>/';

    protected array $resources = [];

    public function __construct(string $filename)
    {
        $data = file_get_contents($filename);

        $objects = [];

        preg_match_all(self::PATTERN, $data, $objects);

        if (isset($objects[1]) && is_array($objects[1])) {
            $this->resources = $objects[1];
        }
    }

    /**
     * @return array
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    public function getResourcesCount(): int
    {
        return count($this->resources);
    }
}