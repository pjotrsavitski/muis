<?php

require 'vendor/autoload.php';

use Pjotr\Muis\MuseumCollection;
use Pjotr\Muis\MuseumResource;

$collection = new MuseumCollection(__DIR__.'/26493.rdf');

$filename = 'results.csv';

$fp = fopen($filename, 'w+');

$count = 0;

foreach ($collection->getResources() as $uri) {
    print 'Processing '.$uri.PHP_EOL;

    $resource = new MuseumResource($uri);
    $resource->writeCsv($fp);

    $count++;
    sleep(3);
}

fclose($fp);

print sprintf('All done. Processed and stored data for %d resources out of total %d available. Please check %s for results', $count, $collection->getResourcesCount(), $filename);
