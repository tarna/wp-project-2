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
        $pointsToAdd = ($index + 1) * 100;
        addCurrentScore($currentUser, $pointsToAdd);
        $message = "Correct! +$pointsToAdd points to $currentUser.";
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

    // echo "<p>$message</p>";
    // echo "<a href=' GameBoard.php'>Return to Board</a>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Question</title>
    <link rel="stylesheet" type="text/css" href="question.css">

</head>
<body>
<?php 
if (isset($userAnswer)) {
    echo "<div class='info'><p>$message</p>";
    echo "<a href=' GameBoard.php'>Return to Board</a></div>";
} else {
    $text = htmlspecialchars($questionText);
    echo "<div class='info'>
        <div><h1>Question</h1></div>
        <div><h2>$text</h2></div>
        <div>
            <form method='post'>
                <label>Your Answer:</label>
                <input type='text' name='answer' required>
                <button type='submit'>Submit</button>
            </form>
        </div>
    </div>";
}
?>
</body>
</html>
