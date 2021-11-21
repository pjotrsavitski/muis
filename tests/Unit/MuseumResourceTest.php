<?php

beforeEach(function() {
    $this->uri = 'http://opendata.muis.ee/object/3954847';
    $this->csv = 'http://opendata.muis.ee/object/3954847,"EKM j 61582 FK 4700","Kunstnik Paul Allik",paber,"laius: 14.8 cm; kõrgus: 11.2 cm",25-08-2020,"valmistamine: 1980","role: kujutatu; name: Allik, Paul; was born: 23.12.1946; died in: 14.12.2003"';
    $this->resource = new \Pjotr\Muis\MuseumResource($this->uri);
});

test('assert custom namespaces are set', function () {
    expect(\EasyRdf\RdfNamespace::get('crm'))->toBe('http://www.cidoc-crm.org/cidoc-crm/');
    expect(\EasyRdf\RdfNamespace::get('muis'))->toBe('http://opendata.muis.ee/rdf-schema/muis.rdfs#');
});

test('assert data is available', function () {
    $data = $this->resource->getData();

    expect($data['uri'])->toBe($this->uri);
});

test('assert csv is written', function() {
    $fp = fopen('php://memory', 'rw+');

    $this->resource->writeCsv($fp);

    rewind($fp);

    expect(trim(stream_get_contents($fp)))->toBe($this->csv);

    fclose($fp);
});
