<?php

declare(strict_types=1);

namespace App\Domain\Builder;

use InvalidArgumentException;

final readonly class FoodBuilderFactory implements FoodBuilderFactoryInterface
{
    public function builder(string $type): FoodBuilderInterface
    {
        return match ($type) {
            'fruit' => new FruitBuilder(),
            'vegetable' => new VegetableBuilder(),
            default => throw new InvalidArgumentException("Unsupported item type: $type"),
        };
    }
}