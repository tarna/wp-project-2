<?php

function generateQuestions() {
    $url = "http://cluebase.lukelav.in/clues?limit=1000&order_by=category&sort=desc";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(["error" => "cURL Error: " . curl_error($ch)]);
    } else {
        $data = json_decode($response, true);

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
                $requestedCategories = ["ZOO LAND", "x 2", "small countries", "poetry", "mini-mountains", "iPOD, YOUTUBE OR WII"];

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

                echo json_encode(["status" => "success", "data" => $result]);
            } else {
                echo json_encode(["error" => "Invalid response structure."]);
            }
        } else {
            echo json_encode(["error" => "Error decoding JSON: " . json_last_error_msg()]);
        }
    }

    curl_close($ch);
}

function readQuestions() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://localhost/api.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('action' => 'read')));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close ($ch);
    return json_decode($response, true);
}