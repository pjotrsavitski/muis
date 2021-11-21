<?php

namespace Pjotr\Muis;

use EasyRdf\Graph;
use EasyRdf\RdfNamespace;
use Pjotr\Muis\Resources\Arrays\ArtistsArray;
use Pjotr\Muis\Resources\Arrays\DatesArray;
use Pjotr\Muis\Resources\Arrays\DimensionsArray;
use Pjotr\Muis\Resources\Arrays\MaterialsArray;
use Pjotr\Muis\Resources\Artist;
use Pjotr\Muis\Resources\Date;
use Pjotr\Muis\Resources\Dimension;
use Pjotr\Muis\Resources\Material;

class MuseumResource
{
    /**
     * @var string Resource API URL.
     */
    protected string $uri;

    /**
     * @var Graph Graph wth resource data.
     */
    protected Graph $graph;

    /**
     * Sets custom namespaces and loads EasyEdf Graph.
     *
     * @param string $uri API resource URL.
     */
    public function __construct(string $uri)
    {
        self::setCustomNamespaces();

        $this->uri = $uri;
        $this->graph = Graph::newAndLoad($uri);
    }

    /**
     * Adds crm and muis to EasyRdf namespaces if those are still missing.
     */
    public static function setCustomNamespaces()
    {
        if (! RdfNamespace::get('crm')) {
            RdfNamespace::set('crm', 'http://www.cidoc-crm.org/cidoc-crm/');
        }

        if (! RdfNamespace::get('muis')) {
            RdfNamespace::set('muis', 'http://opendata.muis.ee/rdf-schema/muis.rdfs#');
        }
    }

    /**
     * @return MaterialsArray
     */
    protected function getMaterials(): MaterialsArray
    {
        $materials = new MaterialsArray();

        foreach($this->graph->allOfType('http://www.cidoc-crm.org/cidoc-crm/E57_Material') as $resource) {
            if ($resource->hasProperty('crm:P130_shows_features_of')) {
                $resource->getResource('crm:P130_shows_features_of')->load();
                if ($resource->getResource('crm:P130_shows_features_of')->hasProperty('rdfs:label')) {
                    $material = new Material($resource->getResource('crm:P130_shows_features_of')->getLiteral('rdfs:label')->getValue());

                    if ($resource->hasProperty('crm:P3_has_note')) {
                        $material->setNote($resource->getLiteral('crm:P3_has_note')->getValue());
                    }

                    $materials[] = $material;
                }
            }
        }

        return $materials;
    }

    /**
     * @return DimensionsArray
     */
    protected function getDimensions(): DimensionsArray
    {
        $dimensions = new DimensionsArray();

        foreach($this->graph->allOfType('http://www.cidoc-crm.org/cidoc-crm/E54_Dimension') as $resource) {
            $resource->getResource('crm:P91_has_unit')->load();
            $resource->getResource('crm:P2_has_type')->load();

            $dimensions[] = new Dimension(
                $resource->getResource('crm:P91_has_unit')->getLiteral('rdfs:label')->getValue(),
                $resource->getResource('crm:P2_has_type')->getLiteral('rdfs:label')->getValue(),
                $resource->getLiteral('crm:P90_has_value')->getValue(),
                $resource->hasProperty('crm:P3_has_note') ? $resource->getLiteral('crm:P3_has_note')->getValue() : ''
            );
        }

        return $dimensions;
    }

    protected function getDates(): DatesArray
    {
        $dates = new DatesArray();

        foreach ($this->graph->allResources($this->uri, 'crm:P12_occurred_in_the_presence_of') as $resource) {
            $resource->load();

            if (!$resource->hasProperty('crm:P2_has_type')) {
                // This most probably means that resource could not be loaded for some reason
                // Example: https://www.muis.ee/rdf/event/3760800
                continue;
            }

            $resource->getResource('crm:P2_has_type')->load();

            $dates[] = new Date(
                $resource->hasProperty('dc:date') ? $resource->getLiteral('dc:date')->getValue() : '',
                $resource->getResource('crm:P2_has_type')->getLiteral('rdfs:label')->getValue()
            );
        }

        return $dates;
    }

    protected function getArtists(): ArtistsArray
    {
        $artists = new ArtistsArray();

        // The code is pretty bad and needs a lot of refactoring
        foreach ($this->graph->allResources($this->uri, 'crm:P12_occurred_in_the_presence_of') as $resource) {
            $resource->load();

            if (!$resource->hasProperty('crm:P2_has_type')) {
                // This most probably means that resource could not be loaded for some reason
                // Example: https://www.muis.ee/rdf/event/3760800
                continue;
            }

            $resource->getResource('crm:P2_has_type')->load();

            if ($resource->hasProperty('crm:P11_had_participant')) {
                $resource->getResource('crm:P11_had_participant')->getResource('owl:sameAs')->load();
                $resource->getResource('crm:P11_had_participant')->getResource('crm:P2_has_type')->load();
            }

            if ($resource->getResource('crm:P11_had_participant')) {
                $artist = new Artist;

                if ($resource->getResource('crm:P11_had_participant')->getResource('crm:P2_has_type')) {
                    $artist->setRole(
                        $resource->getResource('crm:P11_had_participant')->getResource('crm:P2_has_type')->getLiteral('rdfs:label')->getValue()
                    );
                }

                if ($resource->getResource('crm:P11_had_participant')->getResource('owl:sameAs')) {
                    $artist->setName(
                        $resource->getResource('crm:P11_had_participant')->getResource('owl:sameAs')->getLiteral('rdfs:label')->getValue()
                    );

                    if ($resource->getResource('crm:P11_had_participant')->getResource('owl:sameAs')->getResource('crm:P98i_was_born')) {
                        $artist->setWasBorn(
                            $resource->getResource('crm:P11_had_participant')->getResource('owl:sameAs')->getResource('crm:P98i_was_born')->getResource('crm:P4_has_time-span')->getLiteral('rdfs:label')->getValue()
                        );
                    }

                    if ($resource->getResource('crm:P11_had_participant')->getResource('owl:sameAs')->getResource('crm:P100i_died_in')) {
                        $artist->setDiedIn(
                            $resource->getResource('crm:P11_had_participant')->getResource('owl:sameAs')->getResource('crm:P100i_died_in')->getResource('crm:P4_has_time-span')->getLiteral('rdfs:label')->getValue()
                        );
                    }
                }

                $artists[] = $artist;
            }
        }

        return $artists;
    }

    public function getData()
    {
        return [
            'uri' => $this->uri,
            'name' => $this->graph->getLiteral($this->uri, 'rdfs:label')->getValue(),
            'id' => $this->graph->getLiteral($this->uri, 'dc:identifier')->getValue(),
            'medium' => $this->getMaterials(),
            'dimensions' => $this->getDimensions(),
            'dates of acquisition' => $this->graph->getLiteral($this->uri, 'dc:available')->getValue(),
            'dates' => $this->getDates(),
            'artists' => $this->getArtists(),
        ];
    }

    public function writeCsv($fp) {
        $data = $this->getData();

        fputcsv($fp, [
            $data['uri'],
            $data['id'],
            $data['name'],
            (string) $data['medium'],
            (string) $data['dimensions'],
            $data['dates of acquisition'],
            (string) $data['dates'],
            (string) $data['artists'],
        ]);
    }
}