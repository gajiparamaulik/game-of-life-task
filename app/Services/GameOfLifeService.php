<?php

namespace App\Services;

class GameOfLifeService
{
    private const BOARD_SIZE = 25;

    /**
     * Generate a list of board states, one per generation,
     * starting with a Glider placed in the centre of the board.
     *
     * @return array<int, array<int, array<int, bool>>>
     */
    public function generateGenerations(int $totalGenerations): array
    {
        $board = $this->createBoardWithCenteredGlider();

        $generations = [$board];

        for ($i = 1; $i < $totalGenerations; $i++) {
            $board = $this->nextGeneration($board);
            $generations[] = $board;
        }

        return $generations;
    }

    /**
     * Build an empty 25x25 board with a Glider pattern placed in the centre.
     *
     * @return array<int, array<int, bool>>
     */
    private function createBoardWithCenteredGlider(): array
    {
        $board = $this->createEmptyBoard();

        // Glider shape, relative to its top-left corner:
        // . X .
        // . . X
        // X X X
        $glider = [
            [0, 1],
            [1, 2],
            [2, 0], [2, 1], [2, 2],
        ];

        $centerOffset = intdiv(self::BOARD_SIZE, 2) - 1;

        foreach ($glider as [$rowOffset, $colOffset]) {
            $row = $centerOffset + $rowOffset;
            $col = $centerOffset + $colOffset;
            $board[$row][$col] = true;
        }

        return $board;
    }

    /**
     * Create an empty board where every cell is dead.
     *
     * @return array<int, array<int, bool>>
     */
    private function createEmptyBoard(): array
    {
        $board = [];

        for ($row = 0; $row < self::BOARD_SIZE; $row++) {
            for ($col = 0; $col < self::BOARD_SIZE; $col++) {
                $board[$row][$col] = false;
            }
        }

        return $board;
    }

    /**
     * Apply Conway's Game of Life rules to produce the next generation.
     *
     * @param  array<int, array<int, bool>>  $board
     * @return array<int, array<int, bool>>
     */
    private function nextGeneration(array $board): array
    {
        $newBoard = $this->createEmptyBoard();

        for ($row = 0; $row < self::BOARD_SIZE; $row++) {
            for ($col = 0; $col < self::BOARD_SIZE; $col++) {
                $aliveNeighbours = $this->countAliveNeighbours($board, $row, $col);
                $isAlive = $board[$row][$col];

                $newBoard[$row][$col] = $this->willBeAlive($isAlive, $aliveNeighbours);
            }
        }

        return $newBoard;
    }

    /**
     * Decide whether a cell will be alive in the next generation,
     * based on Conway's four rules.
     */
    private function willBeAlive(bool $isAlive, int $aliveNeighbours): bool
    {
        if ($isAlive) {
            return $aliveNeighbours === 2 || $aliveNeighbours === 3;
        }

        return $aliveNeighbours === 3;
    }

    /**
     * Count the number of alive neighbours surrounding a cell.
     * Cells outside the board are treated as dead (no wrap-around).
     *
     * @param  array<int, array<int, bool>>  $board
     */
    private function countAliveNeighbours(array $board, int $row, int $col): int
    {
        $aliveCount = 0;

        for ($rowOffset = -1; $rowOffset <= 1; $rowOffset++) {
            for ($colOffset = -1; $colOffset <= 1; $colOffset++) {
                if ($rowOffset === 0 && $colOffset === 0) {
                    continue;
                }

                $neighbourRow = $row + $rowOffset;
                $neighbourCol = $col + $colOffset;

                if ($this->isWithinBoard($neighbourRow, $neighbourCol) && $board[$neighbourRow][$neighbourCol]) {
                    $aliveCount++;
                }
            }
        }

        return $aliveCount;
    }

    private function isWithinBoard(int $row, int $col): bool
    {
        return $row >= 0 && $row < self::BOARD_SIZE && $col >= 0 && $col < self::BOARD_SIZE;
    }
}
