<?php

declare(strict_types=1);

namespace Henrypark\Bid13;

interface FileParserInterface
{
    public function parse(string $filePath): array;
}
