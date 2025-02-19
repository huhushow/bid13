<?php

declare(strict_types=1);

namespace Henrypark\Bid13;

class ScatterPlotDataGenerator implements ScatterPlotGeneratorInterface
{
    public function generate(array $data): array
    {
        return [
            'type' => 'scatter',
            'data' => $data
        ];
    }
}