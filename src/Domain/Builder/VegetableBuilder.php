<?php

declare(strict_types=1);

namespace App\Domain\Builder;

use App\Domain\Food;
use App\Domain\Vegetable;

class VegetableBuilder implements FoodBuilderInterface
{
    public function build(int $id, string $name, int $weight): Food
    {
        return new Vegetable(
            id: $id,
            name: $name,
            weight: $weight
        );
    }
}