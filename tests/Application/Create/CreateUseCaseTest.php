<?php

declare(strict_types=1);

namespace App\Tests\Application\Create;

use App\Application\Create\CreateUseCase;
use App\Domain\Builder\FoodBuilderFactoryInterface;
use App\Domain\Food;
use App\Domain\Builder\FoodBuilderInterface;
use App\Domain\FoodCollection;
use App\Domain\Storage\FoodStorage;
use PHPUnit\Framework\TestCase;

class CreateUseCaseTest extends TestCase
{
    public function testInvokeProcessesItemsAndSavesThem(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Banana',
                'type' => 'fruit',
                'quantity' => 2,
                'unit' => 'kg',
            ],
            [
                'id' => 2,
                'name' => 'Carrot',
                'type' => 'vegetable',
                'quantity' => 500,
                'unit' => 'g',
            ],
        ];

        $banana = $this->createMock(Food::class);
        $carrot = $this->createMock(Food::class);

        $fruitBuilder = $this->createMock(FoodBuilderInterface::class);
        $fruitBuilder->expects($this->once())
            ->method('build')
            ->with(1, 'Banana', 2000)
            ->willReturn($banana);

        $vegetableBuilder = $this->createMock(FoodBuilderInterface::class);
        $vegetableBuilder->expects($this->once())
            ->method('build')
            ->with(2, 'Carrot', 500)
            ->willReturn($carrot);

        $builderFactory = $this->createMock(FoodBuilderFactoryInterface::class);
        $builderFactory->expects($this->exactly(2))
            ->method('builder')
            ->withConsecutive(['fruit'], ['vegetable'])
            ->willReturnOnConsecutiveCalls($fruitBuilder, $vegetableBuilder);

        $fruitCollection = $this->createMock(FoodCollection::class);
        $fruitCollection->expects($this->once())
            ->method('add')
            ->with($banana);

        $vegetableCollection = $this->createMock(FoodCollection::class);
        $vegetableCollection->expects($this->once())
            ->method('add')
            ->with($carrot);

        $storage = $this->createMock(FoodStorage::class);
        $storage->expects($this->once())->method('getFruits')->willReturn($fruitCollection);
        $storage->expects($this->once())->method('getVegetables')->willReturn($vegetableCollection);
        $storage->expects($this->once())->method('saveFruits')->with($fruitCollection);
        $storage->expects($this->once())->method('saveVegetables')->with($vegetableCollection);

        $useCase = new CreateUseCase($builderFactory, $storage);
        $useCase->__invoke($data);
    }
}
