<?php

declare(strict_types=1);

namespace App\Domain\Storage;

use App\Domain\FoodCollection;

interface FoodStorage
{
    public function getFruits(): FoodCollection;

    public function getVegetables(): FoodCollection;

    public function saveFruits(FoodCollection $collection): void;

    public function saveVegetables(FoodCollection $collection): void;
}