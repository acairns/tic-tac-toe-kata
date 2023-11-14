<?php

namespace AndrewCairns\Tictactoe\Domain;

class Board
{
    private const SIZE = 3;

    private \SplFixedArray $squares;

    public function __construct()
    {
        $this->squares = new \SplFixedArray(3);

        $this->squares[0] = new \SplFixedArray(3);
        $this->squares[1] = new \SplFixedArray(3);
        $this->squares[2] = new \SplFixedArray(3);

        $this->squares[0][0] = new Square();
        $this->squares[0][1] = new Square();
        $this->squares[0][2] = new Square();
        $this->squares[1][0] = new Square();
        $this->squares[1][1] = new Square();
        $this->squares[1][2] = new Square();
        $this->squares[2][0] = new Square();
        $this->squares[2][1] = new Square();
        $this->squares[2][2] = new Square();
    }

    public function placeMarker(int $row, int $column, Marker $marker): void
    {
        if ($row >= $this->squares->getSize()) {
            throw new \OutOfBoundsException();
        }

        if ($column >= $this->squares[$row]->getSize()) {
            throw new \OutOfBoundsException();
        }

        if ($this->getWinner()) {
            throw new GameIsOver();
        }

        if (! $this->hasFreeSquare()) {
            throw new GameIsOver();
        }

        /** @var Square $square */
        $square = $this->squares[$row][$column];
        $square->placeMarker($marker);

        // throw exception if there is a winner
        // no new makers once the game is over...
    }

    private function hasFreeSquare(): bool
    {
        foreach ($this->squares as $row) {
            foreach ($row as $square) {
                /** @var Square $square */
                if (is_null($square->getMarker())) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getWinner(): ?Marker
    {
        $checks = [

            // Rows
            [
                [0,0], [0,1], [0,2]
            ],
            [
                [1,0], [1,1], [1,2]
            ],
            [
                [2,0], [2,1], [2,2]
            ],

            // Columns
            [
                [0,0], [1,0], [2,0]
            ],
            [
                [0,1], [1,1], [2,1]
            ],
            [
                [0,2], [1,2], [2,2]
            ],

            // Diagonal
            [
                [0,0], [1,1], [2,2]
            ],
            [
                [0,2], [1,1], [2,0]
            ]
        ];

        foreach($checks as $coordinates) {
            $winner = $this->checkMarkerMatchesByCoordinates($coordinates);

            if ($winner) {
                return $winner;
            }
        }

        return null;
    }

    private function getSquare(int $row, int $column): Square
    {
        return $this->squares[$row][$column];
    }

    private function checkMarkerMatchesByCoordinates(array $coordinates): ?Marker
    {
        $markers = [];

        foreach ($coordinates as $coordinate) {
            $markers[] = $this->getSquare($coordinate[0], $coordinate[1])->getMarker();
        }

        if ($markers[0] === $markers[1] && $markers[0] === $markers[2]) {
            return $markers[0];
        }

        return null;
    }
}
