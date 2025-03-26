<?php
require __DIR__ . '/lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo generateQuestions();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Questions</title>
</head>
<body>
    <form method="POST" action="api.php">
        <button type="submit">Generate Questions</button>
    </form>
</body>
</html>