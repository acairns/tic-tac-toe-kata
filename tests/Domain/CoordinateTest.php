<?php

namespace Tests\AndrewCairns\Tictactoe\Domain;

use AndrewCairns\Tictactoe\Domain\Coordinate;
use PHPUnit\Framework\TestCase;

class CoordinateTest extends TestCase
{
    public function test_it_validates_coordinates(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Coordinate(-1, -9);
    }

    public function test_it_creates_coordinates(): void
    {
        $this->expectNotToPerformAssertions();

        new Coordinate(1, 1);
    }

    public function test_it_returns_row_by_row_index(): void
    {
        $row = Coordinate::row(0);

        $this->assertEquals(0, $row[0]->getColumn());
        $this->assertEquals(0, $row[0]->getRow());
        $this->assertEquals(1, $row[1]->getColumn());
        $this->assertEquals(0, $row[1]->getRow());
        $this->assertEquals(2, $row[2]->getColumn());
        $this->assertEquals(0, $row[2]->getRow());
    }
}