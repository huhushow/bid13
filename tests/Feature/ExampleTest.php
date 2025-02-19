<?php

use Henrypark\Bid13\FileParserFactory;
use Henrypark\Bid13\DataLoader;
use Henrypark\Bid13\ScatterPlotFactory;

test('load csv', function () {
    $fileType = 'csv';
    $filePath = 'data.csv';

    $parser = FileParserFactory::createParser($fileType);
    $loader = new DataLoader($parser);
    $data = $loader->load($filePath);
    expect($data)->toBeArray();
    expect($data[0])->toBeArray();
    expect($data[0])->toHaveKeys(['x', 'y']);
    expect($data[0])->toMatchArray([
        'x' => 147,
        'y' => -519,
    ]);
});

test('generate image', function () {
    $fileType = 'csv';
    $filePath = 'data.csv';

    $parser = FileParserFactory::createParser($fileType);
    $loader = new DataLoader($parser);
    
    $generator = ScatterPlotFactory::createGenerator('image');
    
    $data = $loader->load($filePath);

    $result = $generator->generate($data);
    expect($result)->toBeResource();
});
