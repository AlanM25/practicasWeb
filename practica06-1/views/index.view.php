<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Práctica 06: APIs</title>
</head>
<body>
    <h1>Práctica 06: APIs</h1>
    <h2>Games:</h2>
    <ul>
        <?php foreach ($games as $game): ?>
            <li>
                <a href="ver-scores.php?game=<?php echo urlencode($game)?>"><?=$game?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
