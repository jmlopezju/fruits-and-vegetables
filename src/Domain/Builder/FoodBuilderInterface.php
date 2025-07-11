<?php

declare(strict_types=1);

namespace App\Domain\Builder;

use App\Domain\Food;

interface FoodBuilderInterface
{
    public function build(int $id, string $name, int $weight): Food;
}