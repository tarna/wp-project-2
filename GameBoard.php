<?php
require_once("lib.php");
session_start();
$questions = getQuestions();

// Track answered questions in session
if (!isset($_SESSION['answered'])) {
    $_SESSION['answered'] = [];
}
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
                    <?php
                        $boxKey = $category . '_' . $i;
                        $points = ($i + 1) * 100;
                        if (in_array($boxKey, $_SESSION['answered'])) {
                            echo "<div class='cell' style='background-color: gray;'></div>";
                        } else {
                            echo "<div class='cell cell-unanswered'>
                                    <a href='question.php?category=" . urlencode($category) . "&index=$i' 
                                       style='color: black; text-decoration: none; display: block; height: 100%; width: 100%; display: flex; align-items: center; justify-content: center;'>
                                        $points
                                    </a>
                                  </div>";
                        }
                    ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
