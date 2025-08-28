<?php

class Rectangle
{
    private $width;
    private $height;

    public function __construct($width = 1, $height = 1)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function getArea()
    {
        return $this->width * $this->height;
    }

    public function getPerimeter()
    {
        return 2 * ($this->width + $this->height);
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }
}

$rect = new Rectangle(5, 3);

echo "Width: " . $rect->getWidth() . PHP_EOL;
echo "Height: " . $rect->getHeight() . PHP_EOL;
echo "Area: " . $rect->getArea() . PHP_EOL;
echo "Perimeter: " . $rect->getPerimeter() . PHP_EOL;
