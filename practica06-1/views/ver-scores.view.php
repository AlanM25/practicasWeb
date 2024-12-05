<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Practica 06</title>
</head>
<body>
    <h1>Puntajes de <?=$game?></h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Player</th>
                <th>Score</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($scores as $score): ?>
                <tr>
                    <td><?=$score['id']?></td>
                    <td><?=$score['player']?></td>
                    <td><?=$score['score']?></td>
                    <td><?=$score['date']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
