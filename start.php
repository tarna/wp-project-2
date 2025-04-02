<html> 
<head> 
<title>Jeopardy!</title> 

<style>
    body{
        margin: 0;
        padding: 0;
        width: 100vw;
        height: 100vh;
        background-color: blue;
        font-family: "Times New Roman", Times, serif;
    }

    .login{
        display:flex;
        flex-direction: column;
        flex-wrap: nowrap;
        border:2px solid lightslategray;
        width:35%;
        background-color: lightskyblue;
    }

    .leaderboard{
        float:right;
        border:2px solid lightslategray;
        width:35%;
        background-color: lightskyblue;
    }

    .page{
        display: flex;
        flex-direction:row;
        justify-content: space-evenly;
        align-items: center;
    }

    h1{
        text-align: center;
        font-weight: bold;
    }
</style>
</head> 
<body> 
    <h1>Welcome to Jeopardy!</h1>
    <div class="page">
    <div class="login">
        <div>
            <h1>Login</h1>
        </div>

        <form action="https://codd.cs.gsu.edu/~ndermer1/WP/Project/02/GameBoard.php" method="post">
            <div>
                User 1
                <input type="text" id="user1" name="user1">
            </div>
            
            <br>

            <div>
                User 2
                <input type="text" id="user2" name="user2">
            </div>

            <br>
            
            <div>
                <input type="submit" value="Play!">
            </div>
        </form>
    </div>

    <?php
    $lines = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $users = [];
    
    //Seperate user and score
    foreach ($lines as $line){
        // Use regex to extract user and score
        if(preg_match('/User (\d+): (\d+)/', $line, $matches)){
            $user = 'User ' . $matches[1];
            $score = (int)$matches[2];
            $users[$user] = $score;
        }
    }

    //Sort array by scores in descending order
    arsort($users);

    //Output sorted useres
    echo "<div class=leaderboard>";
    echo "<h1>Leaderboard</h1>";
    echo "<ol>";
    foreach ($users as $user => $score) {
        echo "<li> $user: $score </li>\n";
    }
    echo "</ol>";
    echo "</div>";
    ?>
    </div>


</body> 
</html> 
