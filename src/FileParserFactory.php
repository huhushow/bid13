<?php

declare(strict_types=1);

namespace Henrypark\Bid13;

class FileParserFactory 
{
    public static function createParser(string $fileType): FileParserInterface 
    {
        return match (strtolower($fileType)) {
            'csv' => new CSVParser(),
            default => throw new \InvalidArgumentException("Unsupported file type: $fileType"),
        };
    }
}
