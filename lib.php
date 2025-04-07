<?php

function getQuestions($generateNew = false) {
    if ($generateNew) {
        $url = "http://cluebase.lukelav.in/clues?limit=1000&order_by=category&sort=desc";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            echo json_encode(["error" => "cURL Error: " . curl_error($ch)]);
            return [];
        }

        $data = json_decode($response, true);
        curl_close($ch);

        if (json_last_error() === JSON_ERROR_NONE) {
            if (isset($data['status']) && $data['status'] === 'success' && isset($data['data'])) {
                $clues = $data['data'];
                $categories = [];

                // Group the clues by category
                foreach ($clues as $clue) {
                    if (isset($clue['category'])) {
                        $categories[$clue['category']][] = $clue;
                    }
                }

                // Only these categories will be chosen
                $requestedCategories = ["ZOO LAND", "“WH”AT IS IT?", "small countries", "poetry", "mini-mountains", "iPOD, YOUTUBE OR WII", "steve jobs|"];

                // Filter categories based on the requested categories
                if (!empty($requestedCategories)) {
                    $categories = array_filter($categories, function ($key) use ($requestedCategories) {
                        return in_array($key, $requestedCategories);
                    }, ARRAY_FILTER_USE_KEY);
                }

                // Filter out categories with "_" in their names because they have weird questions
                $filteredCategories = array_filter(array_keys($categories), function ($category) {
                    return strpos($category, '_') === false;
                });

                // Shuffle categories so it is randomized and select 5 from them categories
                shuffle($filteredCategories);
                $randomCategories = array_slice($filteredCategories, 0, 5);

                $result = [];

                // For each category, select 4 random questions
                foreach ($randomCategories as $category) {
                    $questions = $categories[$category];
                    shuffle($questions);
                    $randomQuestions = array_slice($questions, 0, 4);

                    $result[] = [
                        "category" => $category,
                        "questions" => array_map(function ($question) {
                            return [
                                "clue" => $question['clue'] ?? null,
                                "response" => $question['response'] ?? null
                            ];
                        }, $randomQuestions)
                    ];
                }

                // Write the result to a text file
                $fileContent = "";
                foreach ($result as $categoryData) {
                    $fileContent .= "Category: " . $categoryData['category'] . "\n";
                    foreach ($categoryData['questions'] as $question) {
                        $fileContent .= "  Question: " . $question['clue'] . "\n";
                        $fileContent .= "  Answer: " . $question['response'] . "\n";
                    }
                    $fileContent .= "\n";
                }

                file_put_contents('questions.txt', $fileContent);
            } else {
                echo json_encode(["error" => "Invalid response structure."]);
                return [];
            }
        } else {
            echo json_encode(["error" => "Error decoding JSON: " . json_last_error_msg()]);
            return [];
        }
    }

    // Read questions from the file
    $file = file("questions.txt");
    $questions = [];
    $currentCategory = "";

    for ($i = 0; $i < count($file); $i++) {
        $line = trim($file[$i]);

        if (str_starts_with($line, "Category:")) {
            $currentCategory = trim(substr($line, 9));
            $questions[$currentCategory] = [];
        } elseif (str_starts_with($line, "Question:")) {
            $questionText = trim(substr($line, 9));
            if ($i + 1 < count($file)) {
                $answerLine = trim($file[$i + 1]);
                if (str_starts_with($answerLine, "Answer:")) {
                    $answerText = trim(substr($answerLine, 7));
                    $questions[$currentCategory][] = [
                        'question' => $questionText,
                        'answer' => $answerText
                    ];
                    $i++;
                }
            }
        }
    }

    return $questions;
}

function getCurrentUser() {
    return file_exists("turn.txt") ? trim(file_get_contents("turn.txt")) : "User 1";
}

function switchTurn() {
    $current = getCurrentUser();
    $nextUser = ($current === $_SESSION['user1']) ? $_SESSION['user2'] : $_SESSION['user1'];
    file_put_contents("turn.txt", $nextUser);
}

function setTurn($user) {
    file_put_contents("turn.txt", $user);
}

function addCurrentScore($user, $points) {
    if (!isset($_SESSION['current_score'])) {
        $_SESSION['current_score'] = [];
    }

    if (!isset($_SESSION['current_score'][$user])) {
        $_SESSION['current_score'][$user] = 0;
    }

    $_SESSION['current_score'][$user] += $points;
}

function getCurrentScore($user) {
    if (isset($_SESSION['current_score']) && isset($_SESSION['current_score'][$user])) {
        return $_SESSION['current_score'][$user];
    }
    return 0;
}

function resetCurrentScores() {
    if (isset($_SESSION['current_score'])) {
        unset($_SESSION['current_score']);
    }
}

function updateHighScore($user, $points) {
    $lines = file("users.txt");
    $userExists = false;

    foreach ($lines as &$line) {
        if (strpos($line, $user) !== false) {
            preg_match('/(\d+)/', $line, $matches);
            $newScore = $points;
            $line = "<li> $user: $newScore </li>\n";
            $userExists = true;
            break;
        }
    }

    if (!$userExists) {
        $lines[] = "<li> $user: $points </li>\n";
    }

    file_put_contents("users.txt", implode("", $lines));
}

function getScore($user) {
    $lines = file("users.txt");
    foreach ($lines as $line) {
        if (strpos($line, $user) !== false) {
            preg_match('/(\d+)/', $line, $matches);
            return isset($matches[0]) ? (int)$matches[0] : 0;
        }
    }
    return 0;
}

function getLeaderboard() {
    $lines = file("users.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $users = [];

    foreach ($lines as $line) {
        if (preg_match('/<li>\s*(.+?):\s*(\d+)\s*<\/li>/', $line, $matches)) {
            $user = trim($matches[1]);
            $score = (int) $matches[2];
            $users[$user] = $score;
        }
    }

    arsort($users);
    return array_slice($users, 0, 5, true);
}