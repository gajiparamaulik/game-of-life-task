<<<<<<< HEAD
# Conway's Game of Life — Laravel Implementation

A simple, server-rendered implementation of Conway's Game of Life built with Laravel and Blade. No JavaScript, no database — the entire simulation is computed in PHP on the server and rendered as plain HTML/CSS.

## Project Overview

The application starts with a 25 × 25 board containing a single **Glider** pattern placed at the center, then simulates 20 generations forward using Conway's classic rules. All 20 generations are rendered on one page so you can see the Glider move diagonally across the board, generation by generation.

## Features

- 25 × 25 grid implementing the four standard Game of Life rules.
- Glider pattern seeded in the center of the board.
- Renders 20 consecutive generations on a single page.
- Alive cells shown in black, dead cells in white.
- Each board is labeled with its generation number.
- Pure PHP/Laravel/Blade — no JavaScript, no database.

## Technologies Used

- PHP 8.4
- Laravel 11
- Blade templating engine
- HTML & CSS (no JavaScript, no frontend build step)

## Folder Structure

Only the files relevant to this feature are listed — the rest is a standard Laravel skeleton.

```
app/
├── Http/Controllers/
│   └── GameOfLifeController.php   # Thin controller: calls the service, returns the view
└── Services/
    └── GameOfLifeService.php      # All Game of Life logic lives here

resources/views/game-of-life/
└── index.blade.php                # Renders every generation's board as a grid

routes/
└── web.php                        # Single route: GET / -> GameOfLifeController@index
```

- **`app/Services`** — holds business logic that is independent of HTTP concerns. `GameOfLifeService` knows nothing about requests, responses, or views — it just builds boards and computes the next generation. This keeps the logic reusable and easy to unit test.
- **`app/Http/Controllers`** — `GameOfLifeController` is intentionally thin. It only asks the service for data and hands it to the view.
- **`resources/views/game-of-life`** — Blade templates. The view's only job is to loop over the data it's given and render it as HTML/CSS — no business logic.

## Execution Flow

```
Route (web.php)
   │
   ▼
GameOfLifeController@index
   │  calls
   ▼
GameOfLifeService::generateGenerations()
   │  returns an array of board snapshots
   ▼
resources/views/game-of-life/index.blade.php
   │  loops over generations and cells, renders <div> grid
   ▼
HTML response (black/white grid per generation)
```

1. A `GET /` request hits the single route defined in `routes/web.php`.
2. The route is bound to `GameOfLifeController::index()`.
3. The controller asks `GameOfLifeService` for 20 generations of board data. The controller does **not** know how the boards are computed — it just receives an array.
4. The service builds the initial 25×25 board with a centered Glider, then repeatedly applies Conway's rules to produce each subsequent generation, returning all of them as a single array.
5. The controller passes that array to the Blade view.
6. The view iterates over each generation and renders a grid of `<div>` cells, coloring each one black (alive) or white (dead) via CSS classes.

## Algorithm Explanation

Each generation is computed independently from the previous board:

1. **Build/seed the board** — Generation 0 is an empty 25×25 grid with the Glider's 5 live cells placed at the center.
2. **For every cell**, count its alive neighbours among the 8 surrounding cells (cells outside the board are treated as dead — there is no wrap-around).
3. **Apply Conway's rules** to decide if the cell is alive in the next generation:
   - Alive with fewer than 2 live neighbours → dies (underpopulation).
   - Alive with 2 or 3 live neighbours → survives.
   - Alive with more than 3 live neighbours → dies (overpopulation).
   - Dead with exactly 3 live neighbours → becomes alive (reproduction).
4. **Repeat** this process for the requested number of generations, collecting each board snapshot along the way.

The Glider pattern is used because it is a well-known "moving" pattern — over 4 generations it shifts one cell diagonally, making it easy to visually verify the simulation is correct.

## Time Complexity

For a board of size `N × N` and `G` generations:

- Computing a single generation requires visiting every cell once and checking its 8 neighbours: **O(N²)**.
- Computing all `G` generations: **O(G × N²)**.

With `N = 25` and `G = 20`, this is a small, fast computation (well under 25 × 25 × 20 = 12,500 cell evaluations).

## Space Complexity

Each generation is stored as an `N × N` array of booleans, and all `G` generations are kept in memory to render the full history:

- **O(G × N²)** total space for storing all generations.

This is intentionally simple — for 25×25 boards and 20 generations, the memory footprint is negligible. A production system simulating much larger boards or longer histories might instead stream/discard old generations, but that's unnecessary complexity here.

## How to Run the Project

1. **Install dependencies** (if not already installed):
   ```bash
   composer install
   ```

2. **Copy the environment file and generate an app key** (if not already done):
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Start the development server**:
   ```bash
   php artisan serve
   ```

4. **Open the app** in your browser:
   ```
   http://127.0.0.1:8000
   ```

No database setup or migrations are required — this project does not use a database.

## Future Improvements

- Allow the board size, generation count, and starting pattern to be configured via query parameters or a simple form.
- Add a "step forward" button (would require minimal JavaScript or a form-based POST/redirect cycle) instead of pre-rendering all generations at once.
- Add automated tests (PHPUnit) covering `GameOfLifeService` rules, edge cases (corners/edges of the board), and the Glider's known movement pattern.
- Support toggleable wrap-around (toroidal) board edges as an alternative ruleset.
- Allow other classic patterns (Blinker, Block, Pulsar) to be selected instead of only the Glider.
=======
# game-of-life-task
>>>>>>> a30435e058c2271cff057276a5c319d10def8b87
