<html> 
<head> 
<title>Jeopardy!</title> 

<style>
    .login{
        display:flex;
        flex-direction: column;
        flex-wrap: nowrap;
        border:2px solid lightslategray;
        width:35%;
    }

    .leaderboard{
        float:right;
        border:2px solid lightslategray;
        width:35%;
    }
</style>
</head> 
<body> 
    <h1>Welcome to Jeopardy!</h1>

    <div class="login">
        <div>
            <h1>Login</h1>
        </div>

        <form action="https://codd.cs.gsu.edu/~ndermer1/WP/Project/02/GameBoard.php" method="post">
            <div>
                Input User Name 1
                <input type="text" id="user1" name="user1">
            </div>

            <div>
                Input User Name 2
                <input type="text" id="user2" name="user2">
            </div>

            <div>
                <input type="submit" value="Play!">
            </div>
        </form>
    </div>

    <?php
        $homepage = file_get_contents('users.txt' );
        echo "<div class=leaderboard>";
            echo "<h1>Leaderboard</h1>";
            echo "<ol>";
                echo "$homepage";
            "</ol>";
        "</div>";
    ?>


</body> 
</html> 
