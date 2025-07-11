<?php

declare(strict_types=1);

namespace App\Application\Create;

use App\Domain\Builder\FoodBuilderFactoryInterface;
use App\Domain\Food;
use App\Domain\Storage\FoodStorage;
use InvalidArgumentException;

final readonly class CreateUseCase
{
    public function __construct(
        private FoodBuilderFactoryInterface $factory,
        private FoodStorage $storage,
    ) {}

    public function __invoke(array $data): void
    {
        $fruits = $this->storage->getFruits();
        $vegetables = $this->storage->getVegetables();

        foreach ($data as $item) {
            $type = strtolower($item['type']);
            $builder = $this->factory->builder($type);
            $item = $builder->build(
                id: (int) $item['id'],
                name: $item['name'],
                weight: $this->getWeight($item),
            );

            match ($type) {
                Food::FRUIT => $fruits->add($item),
                Food::VEGETABLE => $vegetables->add($item),
            };
        }

        $this->storage->saveFruits($fruits);
        $this->storage->saveVegetables($vegetables);
    }

    private function getWeight(array $item): int
    {
        $unit = $item['unit'];

        return match ($unit) {
            Food::GRAMS => $item['quantity'],
            Food::KILOGRAMS => $item['quantity'] * 1000,
            default => throw new InvalidArgumentException("Unsupported item unit: $unit"),
        };
    }
}