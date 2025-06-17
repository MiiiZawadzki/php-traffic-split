<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Traffic Distribution Simulation</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 2rem;
        }

        h1, h3 {
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #343434;
        }

        h3 {
            margin-bottom: 1em;
            font-family: monospace;
            color: #646464;
        }

        p {
            margin: 0 0 5px;
            padding: 0;
            font-weight: bold;
            color: #313a30;
        }

        hr {
            margin: 2em 0;
        }

        .gateway {
            margin-bottom: 1rem;
        }

        .bar-container {
            width: 100%;
            background-color: #ddd;
            border-radius: 6px;
            overflow: hidden;
        }

        .bar {
            height: 24px;
            color: white;
            padding-left: 10px;
            line-height: 24px;
            background-color: #95a994;
        }
    </style>
</head>
<body>
<?php foreach ($results as $strategyName => $strategyResults): ?>
    <h1>Traffic Distribution</h1>
    <h3><?= htmlspecialchars($strategyName) ?></h3>
    <?php foreach ($strategyResults as $result): ?>
        <div class="gateway">
            <p><?= htmlspecialchars($result['name']) ?> (<?= $result['percent'] ?>)</p>
            <div class="bar-container">
                <div class="bar" style="width: <?= $result['percent'] ?>;">
                    <?= $result['percent'] ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <hr>
<?php endforeach; ?>
</body>
</html>
