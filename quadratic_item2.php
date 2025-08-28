<?php

class QuadraticEquation
{
    private $a;
    private $b;
    private $c;

    public function __construct($a, $b, $c)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function getA()
    {
        return $this->a;
    }

    public function getB()
    {
        return $this->b;
    }

    public function getC()
    {
        return $this->c;
    }

    public function getDiscriminant()
    {
        return ($this->b * $this->b) - (4 * $this->a * $this->c);
    }

    public function getRoot1()
    {
        $d = $this->getDiscriminant();
        if ($d < 0) {
            return null;
        }
        return (-$this->b + sqrt($d)) / (2 * $this->a);
    }

    public function getRoot2()
    {
        $d = $this->getDiscriminant();
        if ($d < 0) {
            return null;
        }
        return (-$this->b - sqrt($d)) / (2 * $this->a);
    }
}

$eq = new QuadraticEquation(1, -3, 2);

echo "a = " . $eq->getA() . PHP_EOL;
echo "b = " . $eq->getB() . PHP_EOL;
echo "c = " . $eq->getC() . PHP_EOL;

echo "Discriminant = " . $eq->getDiscriminant() . PHP_EOL;
echo "Root 1 = " . $eq->getRoot1() . PHP_EOL;
echo "Root 2 = " . $eq->getRoot2() . PHP_EOL;
