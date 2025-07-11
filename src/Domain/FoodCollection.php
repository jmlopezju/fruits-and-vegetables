<?php

declare(strict_types=1);

namespace App\Domain;

class FoodCollection implements Collection
{
    /** @var Food[] */
    private array $items = [];

    public function add(Food $item): void
    {
        $this->items[] = $item;
    }

    public function remove(Food $item): void
    {
        $this->items = array_filter(
            $this->items,
            fn(Food $i) => $i->id !== $item->id
        );
    }

    public function list(string $unit = Food::GRAMS, array $filters = []): array
    {
        $items = $this->items;
        if (isset($filters['minWeight'])) {
            $items = array_filter($items, fn(Food $food) => $food->weight >= $filters['minWeight']);
        }

        return array_map(function (Food $item) use ($unit) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'weight' => $unit === Food::KILOGRAMS ? $item->weight / 1000 : $item->weight,
            ];
        }, $items);
    }
}