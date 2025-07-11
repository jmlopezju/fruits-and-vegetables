<?php

declare(strict_types=1);

namespace App\Tests\Application\Search;

use App\Application\Search\SearchUseCase;
use App\Domain\FoodCollection;
use App\Domain\Storage\FoodStorage;
use App\Domain\Food;
use PHPUnit\Framework\TestCase;

class SearchUseCaseTest extends TestCase
{
    public function testReturnsOnlyFruitsWhenTypeIsFruit(): void
    {
        $filters = ['type' => Food::FRUIT];
        $unit = 'kg';

        $fruitsList = [['name' => 'Apple', 'weight' => 1.2, 'unit' => 'kg']];

        $fruitCollection = $this->createMock(FoodCollection::class);
        $fruitCollection->expects($this->once())
            ->method('list')
            ->with($unit, $filters)
            ->willReturn($fruitsList);

        $vegetableCollection = $this->createMock(FoodCollection::class);
        $vegetableCollection->expects($this->never())->method('list');

        $storage = $this->createMock(FoodStorage::class);
        $storage->method('getFruits')->willReturn($fruitCollection);
        $storage->method('getVegetables')->willReturn($vegetableCollection);

        $useCase = new SearchUseCase($storage);
        $response = $useCase->__invoke($unit, $filters);

        $this->assertEquals($fruitsList, $response->fruits);
        $this->assertEquals([], $response->vegetables);
    }

    public function testReturnsOnlyVegetablesWhenTypeIsVegetable(): void
    {
        $filters = ['type' => Food::VEGETABLE];
        $unit = 'g';

        $vegetablesList = [['name' => 'Carrot', 'weight' => 300, 'unit' => 'g']];

        $fruitCollection = $this->createMock(FoodCollection::class);
        $fruitCollection->expects($this->never())->method('list');

        $vegetableCollection = $this->createMock(FoodCollection::class);
        $vegetableCollection->expects($this->once())
            ->method('list')
            ->with($unit, $filters)
            ->willReturn($vegetablesList);

        $storage = $this->createMock(FoodStorage::class);
        $storage->method('getFruits')->willReturn($fruitCollection);
        $storage->method('getVegetables')->willReturn($vegetableCollection);

        $useCase = new SearchUseCase($storage);
        $response = $useCase->__invoke($unit, $filters);

        $this->assertEquals([], $response->fruits);
        $this->assertEquals($vegetablesList, $response->vegetables);
    }

    public function testReturnsBothFruitsAndVegetablesWhenNoTypeFilter(): void
    {
        $filters = ['type' => ''];
        $unit = 'g';

        $fruitsList = [['name' => 'Apple', 'weight' => 500, 'unit' => 'g']];
        $vegetablesList = [['name' => 'Cucumber', 'weight' => 800, 'unit' => 'g']];

        $fruitCollection = $this->createMock(FoodCollection::class);
        $fruitCollection->expects($this->once())
            ->method('list')
            ->with($unit, $filters)
            ->willReturn($fruitsList);

        $vegetableCollection = $this->createMock(FoodCollection::class);
        $vegetableCollection->expects($this->once())
            ->method('list')
            ->with($unit, $filters)
            ->willReturn($vegetablesList);

        $storage = $this->createMock(FoodStorage::class);
        $storage->method('getFruits')->willReturn($fruitCollection);
        $storage->method('getVegetables')->willReturn($vegetableCollection);

        $useCase = new SearchUseCase($storage);
        $response = $useCase->__invoke($unit, $filters);

        $this->assertEquals($fruitsList, $response->fruits);
        $this->assertEquals($vegetablesList, $response->vegetables);
    }
}
