<?php

namespace AndrewCairns\Tictactoe\Domain;

class Board
{
    public const SIZE = 3;

    private \SplFixedArray $squares;

    public function __construct()
    {
        $this->squares = new \SplFixedArray(self::SIZE);

        foreach (range(0, Board::SIZE - 1) as $rowIndex)
        {
            $this->squares[$rowIndex] = new \SplFixedArray(self::SIZE);

            foreach (range(0, Board::SIZE - 1) as $columnIndex) {
                $this->squares[$rowIndex][$columnIndex] = new Square();
            }
        }
    }

    public function placeMarker(Coordinate $coordinate, Marker $marker): void
    {
        if ($this->getWinner()) {
            throw new GameIsOver();
        }

        if (! $this->hasFreeSquare()) {
            throw new GameIsOver();
        }

        /** @var Square $square */
        $square = $this->getSquare($coordinate);
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
            ...Coordinate::rows(),
            ...Coordinate::columns(),
            ...Coordinate::diagonals(),
        ];

        foreach($checks as $coordinates) {
            $winner = $this->checkMarkerMatchesByCoordinates($coordinates);

            if ($winner) {
                return $winner;
            }
        }

        return null;
    }

    private function getSquare(Coordinate $coordinates): Square
    {
        return $this->squares[$coordinates->getRow()][$coordinates->getColumn()];
    }

    private function checkMarkerMatchesByCoordinates(array $coordinates): ?Marker
    {
        $markers = [];

        foreach ($coordinates as $coordinate) {
            $markers[] = $this->getSquare($coordinate)->getMarker();
        }

        if ($markers[0] === $markers[1] && $markers[0] === $markers[2]) {
            return $markers[0];
        }

        return null;
    }
}
