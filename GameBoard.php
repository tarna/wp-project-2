<?php
require_once("lib.php");
session_start();

// Track answered questions in session
if (!isset($_SESSION['answered'])) {
    $_SESSION['answered'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data
    $user1 = $_POST['user1'];
    $user2 = $_POST['user2'];

    $_SESSION['user1'] = $user1;
    $_SESSION['user2'] = $user2;

    $questions = getQuestions(true);
    $_SESSION['answered'] = [];
    resetCurrentScores();
    setTurn($user1);
} else {
    $user1 = $_SESSION['user1'];
    $user2 = $_SESSION['user2'];
    $questions = getQuestions();
}

$currentUser = getCurrentUser();

$user1Score = getCurrentScore($user1);
$user2Score = getCurrentScore($user2);

if (sizeof($_SESSION['answered']) >= 20) {
    $_SESSION['answered'] = [];
    resetCurrentScores();

    if ($user1Score > getScore($user1)) {
        updateHighScore($user1, $user1Score);
    }
    if ($user2Score > getScore($user2)) {
        updateHighScore($user2, $user2Score);
    }

    header("Location: start.php");
    exit();
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
                <div class="cell" style="background-color: blue; color: black; font-weight: bold; display: flex; align-items: center; justify-content: center;">
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
    <div class="bottom">
        <?php echo "<div>$user1's Points: $$user1Score</div>"?>
        <?php echo "<div>$currentUser's Turn</div>" ?>
        <?php echo "<div>$user2's Points: $$user2Score</div>"?>
    </div>
</body>
</html>
