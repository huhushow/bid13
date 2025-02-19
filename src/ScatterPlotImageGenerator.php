<?php

declare(strict_types=1);

namespace Henrypark\Bid13;

use Exception;

class ScatterPlotImageGenerator implements ScatterPlotGeneratorInterface
{
    public function __construct(private int $width = 800, private int $height = 600)
    {}

    public function generate(array $data): mixed
    {
        $image = imagecreatetruecolor($this->width, $this->height);
        $bgColor = imagecolorallocate($image, 255, 255, 255);
        $pointColor = imagecolorallocate($image, 0, 0, 255);

        imagefill($image, 0, 0, $bgColor);

        $minX = PHP_INT_MAX;
        $maxX = PHP_INT_MIN;
        $minY = PHP_INT_MAX;
        $maxY = PHP_INT_MIN;
        foreach ($data as $row) {
            $maxX = max($maxX, $row['x']);
            $minX = min($minX, $row['x']);
            $maxY = max($maxY, $row['y']);
            $minY = min($minY, $row['y']);
        }
        $rangeX = $maxX - $minX ?: 1;
        $rangeY = $maxY - $minY ?: 1;

        foreach ($data as $row) {
            $scaledX = (int)(($row['x'] - $minX) / $rangeX * $this->width);
            $scaledY = (int)(($row['y'] - $minY) / $rangeY * $this->height);
            imagesetpixel($image, $scaledX, $scaledY, $pointColor);
        }

        $file = tmpfile();

        if ($file === false) {
            throw new Exception();
        }

        imagepng($image, $file);

        return $file;
    }
}