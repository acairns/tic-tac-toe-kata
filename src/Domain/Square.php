<?php

namespace AndrewCairns\Tictactoe\Domain;

class Square
{
    private ?Marker $marker = null;

    public function placeMarker(Marker $marker): void
    {
        if (! is_null($this->marker)) {
            throw new CantReplaceMarker();
        }

        $this->marker = $marker;
    }

    public function has(Marker $marker): bool
    {
        return $marker === $this->marker;
    }

    public function getMarker(): ?Marker
    {
        return $this->marker;
    }
}
