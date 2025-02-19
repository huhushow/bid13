<?php

declare(strict_types=1);

namespace Henrypark\Bid13;

class ScatterPlotFactory
{
    public static function createGenerator(string $type): ScatterPlotGeneratorInterface {
        return match ($type) {
            'image' => new ScatterPlotImageGenerator(),
            'data'  => new ScatterPlotDataGenerator(),
            default => throw new \InvalidArgumentException("Unsupported output type: $type"),
        };
    }
}