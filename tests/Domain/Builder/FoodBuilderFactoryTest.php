<?php

declare(strict_types=1);

namespace App\Tests\Domain\Builder;

use App\Domain\Builder\FoodBuilderFactory;
use App\Domain\Builder\FruitBuilder;
use App\Domain\Builder\VegetableBuilder;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FoodBuilderFactoryTest extends TestCase
{
    public function testReturnsFruitBuilder(): void
    {
        $factory = new FoodBuilderFactory();
        $builder = $factory->builder('fruit');

        $this->assertInstanceOf(FruitBuilder::class, $builder);
    }

    public function testReturnsVegetableBuilder(): void
    {
        $factory = new FoodBuilderFactory();
        $builder = $factory->builder('vegetable');

        $this->assertInstanceOf(VegetableBuilder::class, $builder);
    }

    public function testThrowsExceptionForInvalidType(): void
    {
        $factory = new FoodBuilderFactory();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported item type: meat');

        $factory->builder('meat');
    }
}
