<?php

namespace Tests\AndrewCairns\Tictactoe\Domain;

use AndrewCairns\Tictactoe\Domain\Game;
use AndrewCairns\Tictactoe\Domain\Marker;
use PHPUnit\Framework\TestCase;
use Tests\AndrewCairns\Tictactoe\CanAssertAttributes;

class GameTest extends TestCase
{
    use CanAssertAttributes;

    public function test_turn_is_rotated(): void
    {
        $game = new Game();

        $this->assertTurn($game, Marker::X);

        $game->takeTurn(1, 1);

        $this->assertTurn($game, Marker::O);
    }

    public function test_game_can_be_won(): void
    {
        $game = new Game();

        $this->assertFalse(
            $game->takeTurn(0, 0)
        );

        $this->assertFalse(
            $game->takeTurn(1, 0)
        );

        $this->assertFalse(
            $game->takeTurn(0, 1)
        );

        $this->assertFalse(
            $game->takeTurn(1, 1)
        );

        $this->assertTrue(
            $game->takeTurn(0, 2)
        );
    }

    private function assertTurn(Game $game, Marker $marker): void
    {
        $this->assertEquals($marker, $this->getObjectAttribute($game, 'turn'));
    }
}