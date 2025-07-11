<?php

declare(strict_types=1);

namespace App\Application\Search;

use App\Application\FoodsResponse;
use App\Domain\Food;
use App\Domain\Storage\FoodStorage;

final readonly class SearchUseCase
{
    public function __construct(private FoodStorage $storage) {}

    public function __invoke(string $unit, array $filters): FoodsResponse
    {
        $fruits = $this->storage->getFruits();
        $vegetables = $this->storage->getVegetables();

        if (Food::FRUIT === $filters['type']) {
            return FoodsResponse::create(
                fruits: $fruits->list($unit, $filters),
                vegetables: []
            );
        }

        if (Food::VEGETABLE === $filters['type']) {
            return FoodsResponse::create(
                fruits: [],
                vegetables: $vegetables->list($unit, $filters)
            );
        }

        return FoodsResponse::create(
            fruits: $fruits->list($unit, $filters),
            vegetables: $vegetables->list($unit, $filters)
        );
    }
}
