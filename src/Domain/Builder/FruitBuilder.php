<?php

declare(strict_types=1);

namespace App\Domain\Builder;

use App\Domain\Food;
use App\Domain\Fruit;

final class FruitBuilder implements FoodBuilderInterface
{
    public function build(int $id, string $name, int $weight): Food
    {
        return new Fruit(
            id: $id,
            name: $name,
            weight: $weight
        );
    }
}