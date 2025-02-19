<?php

declare(strict_types=1);

namespace Henrypark\Bid13;

interface ScatterPlotGeneratorInterface
{
    public function generate(array $data): mixed;
}
