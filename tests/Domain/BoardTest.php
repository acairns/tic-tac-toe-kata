<?php

namespace Tests\AndrewCairns\Tictactoe\Domain;

use AndrewCairns\Tictactoe\Domain\Board;
use AndrewCairns\Tictactoe\Domain\CantReplaceMarker;
use AndrewCairns\Tictactoe\Domain\GameIsOver;
use AndrewCairns\Tictactoe\Domain\Marker;
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
        $board->placeMarker(1,1, Marker::O);
    }

    public function test_it_throws_exception_if_placing_marker_on_existing_marker(): void
    {
        $this->expectException(CantReplaceMarker::class);

        $board = new Board();
        $board->placeMarker(1, 1, Marker::O);
        $board->placeMarker(1, 1, Marker::X);
    }

    public function test_it_throws_out_of_bounds_for_invalid_row(): void
    {
        $this->expectException(\OutOfBoundsException::class);

        $board = new Board();
        $board->placeMarker(10, 10, Marker::O);
    }

    public function test_it_throws_out_of_bounds_for_invalid_columns(): void
    {
        $this->expectException(\OutOfBoundsException::class);

        $board = new Board();
        $board->placeMarker(1, 10, Marker::O);
    }

    public function test_it_can_detect_a_winner(): void
    {
        $board = new Board();
        $board->placeMarker(0, 0, Marker::O);
        $board->placeMarker(1, 1, Marker::O);

        $this->assertNull(
            $board->getWinner()
        );

        $board->placeMarker(2, 2, Marker::O);

        $this->assertEquals(
            Marker::O,
            $board->getWinner()
        );
    }

    public function test_it_prevents_turns_once_game_is_over(): void
    {
        $this->expectException(GameIsOver::class);

        $board = new Board();
        $board->placeMarker(0, 0, Marker::O); // top left
        $board->placeMarker(0, 2, Marker::X); // top right
        $board->placeMarker(1, 1, Marker::O); // middle
        $board->placeMarker(2, 0, Marker::X); // bottom left
        $board->placeMarker(2, 2, Marker::O); // bottom right

        $board->placeMarker(0, 1, Marker::X); // game should be over
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
        $board->placeMarker(0, 0, Marker::O);
        $board->placeMarker(0, 1, Marker::X);
        $board->placeMarker(0, 2, Marker::O);
        $board->placeMarker(1, 0, Marker::X);
        $board->placeMarker(1, 2, Marker::O);
        $board->placeMarker(1, 1, Marker::X);
        $board->placeMarker(2, 0, Marker::O);
        $board->placeMarker(2, 2, Marker::X);
        $board->placeMarker(2, 1, Marker::O);

        $this->assertNull(
            $board->getWinner()
        );

        $board->placeMarker(0, 0, Marker::X);
    }
}