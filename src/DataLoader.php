<?php

declare(strict_types=1);

namespace Henrypark\Bid13;

class DataLoader
{
    public function __construct(private FileParserInterface $parser)
    {}

    public function load(string $filePath): array 
    {
        return $this->parser->parse($filePath);
    }
}
