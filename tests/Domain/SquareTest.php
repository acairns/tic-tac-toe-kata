<?php

namespace Tests\AndrewCairns\Tictactoe\Domain;

use AndrewCairns\Tictactoe\Domain\CantReplaceMarker;
use AndrewCairns\Tictactoe\Domain\Marker;
use AndrewCairns\Tictactoe\Domain\Square;
use PHPUnit\Framework\TestCase;

class SquareTest extends TestCase
{
    public function test_it_knows_when_its_empty(): void
    {
        $square = new Square();

        $this->assertFalse(
            $square->has(Marker::O)
        );

        $this->assertFalse(
            $square->has(Marker::X)
        );
    }

    public function test_it_can_have_a_marker_placed_inside(): void
    {
        $square = new Square();
        $square->placeMarker(Marker::O);

        $this->assertTrue(
            $square->has(Marker::O)
        );

        $this->assertFalse(
            $square->has(Marker::X)
        );
    }

    public function test_it_cant_replace_a_previous_marker(): void
    {
        $this->expectException(CantReplaceMarker::class);

        $square = new Square();
        $square->placeMarker(Marker::O);
        $square->placeMarker(Marker::X);
    }
}