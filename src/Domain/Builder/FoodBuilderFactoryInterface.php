<?php

namespace App\Domain\Builder;

interface FoodBuilderFactoryInterface
{
    public function builder(string $type): FoodBuilderInterface;
}