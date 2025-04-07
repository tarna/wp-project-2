<?php
session_start();
require_once("lib.php");

$category = $_GET['category'] ?? '';
$index = $_GET['index'] ?? '';

$questions = getQuestions();
$questionText = $questions[$category][$index]['question'];
$correctAnswer = strtolower(trim($questions[$category][$index]['answer']));
$boxKey = $category . '_' . $index;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userAnswer = strtolower(trim($_POST['answer']));
    $currentUser = getCurrentUser();

    if ($userAnswer === $correctAnswer) {
        updateScore($currentUser, 100);
        $message = "Correct! +100 points to $currentUser.";
    } else {
        $message = "Incorrect! The correct answer was: $correctAnswer.";
    }

    // Mark question as answered
    if (!isset($_SESSION['answered'])) {
        $_SESSION['answered'] = [];
    }
    if (!in_array($boxKey, $_SESSION['answered'])) {
        $_SESSION['answered'][] = $boxKey;
    }

    switchTurn();

    echo "<p>$message</p>";
    echo "<a href='GameBoard.php'>Return to Board</a>";
    exit;
}

function getCurrentUser() {
    return file_exists("turn.txt") ? trim(file_get_contents("turn.txt")) : "User 1";
}

function switchTurn() {
    $users = ["User 1", "User 2", "User 3", "User 4"];
    $current = getCurrentUser();
    $nextIndex = (array_search($current, $users) + 1) % count($users);
    file_put_contents("turn.txt", $users[$nextIndex]);
}

// ✅ Your score update function added below:
function updateScore($user, $points) {
    $lines = file("users.txt");
    foreach ($lines as &$line) {
        if (strpos($line, $user) !== false) {
            preg_match('/(\d+)/', $line, $matches);
            $currentScore = (int)$matches[0];
            $newScore = $currentScore + $points;
            $line = "<li> $user: $newScore </li>\n";
            break;
        }
    }
    file_put_contents("users.txt", implode("", $lines));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Question</title>
</head>
<body>
    <h2><?= htmlspecialchars($questionText) ?></h2>
    <form method="post">
        <label>Your Answer:</label>
        <input type="text" name="answer" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
