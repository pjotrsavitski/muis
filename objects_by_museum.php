<?php

require 'vendor/autoload.php';

use Pjotr\Muis\MuseumCollection;
use Pjotr\Muis\MuseumResource;

$collection = new MuseumCollection(__DIR__.'/26493.rdf');

$filename = 'results.csv';

$fp = fopen($filename, 'w+');

$count = 0;

function store_last_processed_uri(string $uri)
{
    $fp = fopen('resource_uri', 'w+');
    fwrite($fp, $uri);
    fclose($fp);
}

function get_last_processed_uri(): bool|string|null
{
    if (file_exists('resource_uri')) {
        return file_get_contents('resource_uri');
    }

    return null;
}

function delete_last_processed_uri(): ?bool
{
    if (file_exists('resource_uri')) {
        return unlink('resource_uri');
    }

    return null;
}

// TODO Need to make sure that processing starts from where we left off
foreach ($collection->getResources() as $uri) {
    print 'Processing '.$uri.PHP_EOL;

    // TODO It makes sense to have a resume functionality that would store the URI of the latest processed resource and skip to it without making all the same requests again
    $resource = new MuseumResource($uri);
    $resource->writeCsv($fp);
    store_last_processed_uri($uri);


    $count++;
    sleep(3);
}

fclose($fp);

delete_last_processed_uri();

print sprintf('All done. Processed and stored data for %d resources out of total %d available. Please check %s for results', $count, $collection->getResourcesCount(), $filename);
