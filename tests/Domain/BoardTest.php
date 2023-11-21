<?php

namespace Tests\AndrewCairns\Tictactoe\Domain;

use AndrewCairns\Tictactoe\Domain\Board;
use AndrewCairns\Tictactoe\Domain\CantReplaceMarker;
use AndrewCairns\Tictactoe\Domain\GameIsOver;
use AndrewCairns\Tictactoe\Domain\Marker;
use AndrewCairns\Tictactoe\Domain\Coordinate;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function test_it_can_be_created(): void
    {
        $this->expectNotToPerformAssertions();

        new Board();
    }

    public function test_it_can_place_marker_on_square(): void
    {
        $this->expectNotToPerformAssertions();

        $board = new Board();
        $board->placeMarker(new Coordinate(1, 1), Marker::O);
    }

    public function test_it_throws_exception_if_placing_marker_on_existing_marker(): void
    {
        $this->expectException(CantReplaceMarker::class);

        $board = new Board();
        $board->placeMarker(new Coordinate(1, 1), Marker::O);
        $board->placeMarker(new Coordinate(1, 1), Marker::X);
    }

    public function test_it_can_detect_a_winner(): void
    {
        $board = new Board();
        $board->placeMarker(new Coordinate(0, 0), Marker::O);
        $board->placeMarker(new Coordinate(1, 1), Marker::O);

        $this->assertNull(
            $board->getWinner()
        );

        $board->placeMarker(new Coordinate(2, 2), Marker::O);

        $this->assertEquals(
            Marker::O,
            $board->getWinner()
        );
    }

    public function test_it_prevents_turns_once_game_is_over(): void
    {
        $this->expectException(GameIsOver::class);

        $board = new Board();
        $board->placeMarker(new Coordinate(0, 0), Marker::O); // top left
        $board->placeMarker(new Coordinate(0, 2), Marker::X); // top right
        $board->placeMarker(new Coordinate(1, 1), Marker::O); // middle
        $board->placeMarker(new Coordinate(2, 0), Marker::X); // bottom left
        $board->placeMarker(new Coordinate(2, 2), Marker::O); // bottom right

        $board->placeMarker(new Coordinate(0, 1), Marker::X); // game should be over
    }

    public function test_it_prevents_turns_when_board_is_full(): void
    {
        $this->expectException(GameIsOver::class);

        /**
         * O | X | O
         * X | X | O
         * O | O | X
         */

        $board = new Board();
        $board->placeMarker(new Coordinate(0, 0), Marker::O);
        $board->placeMarker(new Coordinate(0, 1), Marker::X);
        $board->placeMarker(new Coordinate(0, 2), Marker::O);
        $board->placeMarker(new Coordinate(1, 0), Marker::X);
        $board->placeMarker(new Coordinate(1, 2), Marker::O);
        $board->placeMarker(new Coordinate(1, 1), Marker::X);
        $board->placeMarker(new Coordinate(2, 0), Marker::O);
        $board->placeMarker(new Coordinate(2, 2), Marker::X);
        $board->placeMarker(new Coordinate(2, 1), Marker::O);

        $this->assertNull(
            $board->getWinner()
        );

        $board->placeMarker(new Coordinate(0, 0), Marker::X);
    }
}