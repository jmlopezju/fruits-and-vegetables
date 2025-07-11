<?php

declare(strict_types=1);

namespace App\Application;

final class FoodsResponse
{
    private function __construct(
        public array $fruits,
        public array $vegetables
    ) {}

    public static function create(
        array $fruits,
        array $vegetables
    ): FoodsResponse {
        return new self(
            fruits: $fruits,
            vegetables: $vegetables
        );
    }
}