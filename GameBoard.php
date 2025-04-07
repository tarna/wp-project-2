<?php
require_once("lib.php");
$questions = getQuestions();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jeopardy Game Board</title>
    <link rel="stylesheet" type="text/css" href="boardstyle.css">
</head>
<body>
    <h1 style="color:white;">Jeopardy</h1>
    <div class="row">
        <?php foreach ($questions as $category => $qs): ?>
            <div class="column">
                <div class="cell" style="background-color: darkblue; color: black; font-weight: bold; display: flex; align-items: center; justify-content: center;">
                    <?= htmlspecialchars($category) ?>
                </div>
                <?php foreach ($qs as $i => $q): ?>
                    <div class="cell">
                        <a href="question.php?category=<?= urlencode($category) ?>&index=<?= $i ?>" style="color: black; text-decoration: none; display: block; height: 100%; width: 100%; display: flex; align-items: center; justify-content: center;">
                            <?= ($i + 1) * 100 ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="bottom">
        <div style="padding: 10px;">Current Turn: <?= file_exists("turn.txt") ? htmlspecialchars(trim(file_get_contents("turn.txt"))) : "User 1" ?></div>
        <div style="padding: 10px;"><a href="start.php" style="color:white;">Start New Game</a></div>
    </div>
</body>
</html>