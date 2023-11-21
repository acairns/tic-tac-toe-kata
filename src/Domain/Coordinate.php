<?php

namespace AndrewCairns\Tictactoe\Domain;

final class Coordinate
{
    private int $row;
    private int $column;

    public function __construct(int $row, int $column)
    {
        if (!$this->isWithinRange($row) || !$this->isWithinRange($column)) {
            throw new \InvalidArgumentException();
        }

        $this->row = $row;
        $this->column = $column;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public static function row(int $rowIndex): array
    {
        $columnIndices = range(0, Board::SIZE - 1);

        return array_map(
            function ($columnIndex) use ($rowIndex) {
                return new Coordinate($rowIndex, $columnIndex);
            },
            $columnIndices
        );
    }

    public static function rows(): array
    {
        $rowIndices = range(0, Board::SIZE - 1);

        return array_map(
            function ($rowIndex) use ($rowIndices) {
                return Coordinate::row($rowIndex);
            },
            $rowIndices
        );
    }

    public static function column(int $columnIndex): array
    {
        $rowIndices = range(0, Board::SIZE - 1);

        return array_map(
            function ($rowIndex) use ($columnIndex) {
                return new Coordinate($rowIndex, $columnIndex);
            },
            $rowIndices
        );
    }

    public static function columns(): array
    {
        $columnIndices = range(0, Board::SIZE - 1);

        return array_map(
            function ($columnIndex) use ($columnIndices) {
                return Coordinate::column($columnIndex);
            },
            $columnIndices
        );
    }

    public static function diagonals(): array
    {
        $indices = range(0, Board::SIZE - 1);

        return [
            array_map(
                function ($index) {
                    return new Coordinate($index, $index);
                },
                $indices
            ),
            array_map(
                function ($index) {
                    return new Coordinate($index, abs($index - (Board::SIZE - 1)));
                },
                $indices
            ),
        ];
    }

    private function isWithinRange(int $value): bool
    {
        return $value >= 0 && $value < Board::SIZE;
    }
}
