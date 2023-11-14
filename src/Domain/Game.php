<?php

namespace AndrewCairns\Tictactoe\Domain;

class Game
{
    private Board $board;
    private Marker $turn;

    public function __construct()
    {
        $this->board = new Board();
        $this->turn = Marker::X;
    }

    public function takeTurn(int $row, int $column): bool
    {
        $this->board->placeMarker($row, $column, $this->turn);

        if ($this->board->getWinner() === $this->turn) {
            return true;
        }

        $this->rotateTurn();

        return false;
    }

    private function rotateTurn(): void
    {
        $this->turn = $this->turn === Marker::X ? Marker::O : Marker::X;
    }
}
