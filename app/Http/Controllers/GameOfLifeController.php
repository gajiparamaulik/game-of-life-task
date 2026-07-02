<?php

namespace App\Http\Controllers;

use App\Services\GameOfLifeService;
use Illuminate\View\View;

class GameOfLifeController extends Controller
{
    private const TOTAL_GENERATIONS = 20;
    protected GameOfLifeService $gameOfLifeService;

    public function __construct(GameOfLifeService $gameOfLifeService)
    {
        $this->gameOfLifeService = $gameOfLifeService;
    }

    /**
     * Display the Game of Life board across multiple generations.
     */
    public function index(): View
    {
        $generations = $this->gameOfLifeService->generateGenerations(self::TOTAL_GENERATIONS);

        return view('game-of-life.index', [
            'generations' => $generations,
        ]);
    }
}
