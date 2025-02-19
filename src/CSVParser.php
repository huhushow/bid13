<?php

declare(strict_types=1);

namespace Henrypark\Bid13;

class CSVParser implements FileParserInterface
{
    public function parse(string $filePath): array
    {
        $data = [];
        if (($handle = fopen($filePath, "r")) !== false) {
            $header = fgetcsv($handle, escape: '\\');
            while (($row = fgetcsv($handle, escape: '\\')) !== false) {
                $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }
}
