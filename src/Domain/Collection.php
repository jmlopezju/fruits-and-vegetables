<?php

declare(strict_types=1);

namespace App\Domain;

interface Collection
{
    public function add(Food $item): void;

    public function remove(Food $item): void;

    public function list(string $unit = Food::GRAMS, array $filters = []): array;
}