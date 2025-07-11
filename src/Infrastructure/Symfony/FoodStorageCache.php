<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony;

use App\Domain\FoodCollection;
use App\Domain\Storage\FoodStorage;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

readonly class FoodStorageCache implements FoodStorage
{
    public const string FRUITS_KEY = 'collection.fruits';
    public const string VEGETABLES_KEY = 'collection.vegetables';

    public function __construct(private CacheInterface $cache) {}

    public function getFruits(): FoodCollection
    {
        return $this->cache->get(self::FRUITS_KEY, function (ItemInterface $item) {
            return new FoodCollection();
        });
    }

    public function getVegetables(): FoodCollection
    {
        return $this->cache->get(self::VEGETABLES_KEY, function (ItemInterface $item) {
            return new FoodCollection();
        });
    }

    public function saveFruits(FoodCollection $collection): void
    {
        $this->cache->delete(self::FRUITS_KEY);
        $this->cache->get(self::FRUITS_KEY, fn() => $collection);
    }

    public function saveVegetables(FoodCollection $collection): void
    {
        $this->cache->delete(self::VEGETABLES_KEY);
        $this->cache->get(self::VEGETABLES_KEY, fn() => $collection);
    }
}
