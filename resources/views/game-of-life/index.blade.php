<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Conway's Game of Life</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            text-align: center;
            padding: 20px;
        }

        h1 {
            margin-bottom: 5px;
        }

        .generation {
            margin-bottom: 50px;
        }

        .generation h2 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .board {
            display: inline-block;
            border: 2px solid #333;
        }

        .row {
            display: flex;
        }

        .cell {
            width: 16px;
            height: 16px;
            border: 1px solid #ccc;
        }

        .cell.alive {
            background-color: #000;
        }

        .cell.dead {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <h1>Conway's Game of Life</h1>
    <p>25 x 25 board &mdash; Glider pattern &mdash; {{ count($generations) }} generations</p>

    @foreach ($generations as $generationNumber => $board)
        <div class="generation">
            <h2>Generation {{ $generationNumber }}</h2>
            <div class="board">
                @foreach ($board as $row)
                    <div class="row">
                        @foreach ($row as $isAlive)
                            <div class="cell {{ $isAlive ? 'alive' : 'dead' }}"></div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</body>
</html>
