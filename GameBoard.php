<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process the form data
        	$user1 = $_POST['user1'];
        	$user2 = $_POST['user2'];
		}
?>

<html> 
<head> 
<title>Jeopardy!</title> 
<link rel="stylesheet" type="text/css" href="boardstyle.css">
</head> 
<body> 

    <form action="https://codd.cs.gsu.edu/~ndermer1/WP/Project/02/question.php" method="post">
        <div class="row">
            <!-- Column 1 -->
            <div class="column">
                <div class="cell">
                    <h1>Title 1</h1>
                </div>
                <div class="cell">
                    <h1>$100</h1>
                </div>
                <div class="cell">
                    <h1>$200</h1>
                </div>
                <div class="cell">
                    <h1>$300</h1>
                </div>
                <div class="cell">
                    <h1>$400</h1>
                </div>
            </div>

            <!-- Column 2 -->
            <div class="column">
                <div class="cell">
                    <h1>Title 2</h1>
                </div>
                <div class="cell">
                    <h1>$100</h1>
                </div>
                <div class="cell">
                    <h1>$200</h1>
                </div>
                <div class="cell">
                    <h1>$300</h1>
                </div>
                <div class="cell">
                    <h1>$400</h1>
                </div>
            </div>

            <!-- Column 3 -->
            <div class="column">
                <div class="cell">
                    <h1>Title 3</h1>
                </div>
                <div class="cell">
                    <h1>$100</h1>
                </div>
                <div class="cell">
                    <h1>$200</h1>
                </div>
                <div class="cell">
                    <h1>$300</h1>
                </div>
                <div class="cell">
                    <h1>$400</h1>
                </div>
            </div>

            <!-- Column 3 -->
            <div class="column">
                <div class="cell">
                    <h1>Title 3</h1>
                </div>
                <div class="cell">
                    <h1>$100</h1>
                </div>
                <div class="cell">
                    <h1>$200</h1>
                </div>
                <div class="cell">
                    <h1>$300</h1>
                </div>
                <div class="cell">
                    <h1>$400</h1>
                </div>
            </div>

            <!-- Column 4 -->
            <div class="column">
                <div class="cell">
                    <h1>Title 4</h1>
                </div>
                <div class="cell">
                    <h1>$100</h1>
                </div>
                <div class="cell">
                    <h1>$200</h1>
                </div>
                <div class="cell">
                    <h1>$300</h1>
                </div>
                <div class="cell">
                    <h1>$400</h1>
                </div>
            </div>

            <!-- Column 5 -->
            <div class="column">
                <div class="cell">
                    <h1>Title 5</h1>
                </div>
                <div class="cell">
                    <h1>$100</h1>
                </div>
                <div class="cell">
                    <h1>$200</h1>
                </div>
                <div class="cell">
                    <h1>$300</h1>
                </div>
                <div class="cell">
                    <h1>$400</h1>
                </div>
            </div>
        </div>
    </form>

    <div class="bottom">
        <?php echo "<div>$user1's Points: $300</div>"?>
        <div>User 1's Turn</div>
        <?php echo "<div>$user2's Points: $300</div>"?>

</body> 
</html> 