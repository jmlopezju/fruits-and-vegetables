<?php

declare(strict_types=1);

namespace App\Domain;

abstract class Food
{
    public const string FRUIT = 'fruit';
    public const string VEGETABLE = 'vegetable';
    public const string GRAMS = 'g';
    public const string KILOGRAMS = 'kg';

    public function __construct(
        public int $id,
        public string $name,
        public int $weight
    ) {}
}
