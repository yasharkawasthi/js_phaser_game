<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="assets/bootstrap.css">
    <style type="text/css">
        div{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["gamingname"]); ?></b>. Welcome to this game.</h1>
    </div>
    <div>
    <p>
        <a href="osne.php" class="btn btn-success">Start Game</a>
        <a href="chngpass.php" class="btn btn-warning">Reset Password</a>
        <a href="logout.php" class="btn btn-danger">Log Out</a>
    </p>
    </div>
    <p>
        <h2>Info : </h2>
        <h3>
        <ul style="list-style-type:square;">
        <li>OnionMan is a 2D Platformer Game.<br>
        <li>It is developed by using JavaScript Language with Phaser Library.<br>
        <li>In this game, you control a character called Dude which moves and jumps around the level to collect stars.<br>
        <li>There are different obstacles or enemies present to decrease your health or life.<br>
        <li>There are 6 levels in the game.<br>
        <li>The level is completed when you collect all the stars present in the level and move to the open door at the end.<br>
        <li>You can increase your score by picking up different items and killing enemies. Your health and lives will also affect your overall score.<br>
        </ul>
        </h3>
        <h2>You : </h2>
        <h3>
        <ul style="list-style-type:circle;">
        <li><img src="assets/dude2.png"> - Dude - Move by left and right arrow keys. Jump by up arrow key. Shoot by down arrow key.<br>You have 100 health and 3 lives at the start of the game.
        </ul>
        </h3>
        <h2>Items : </h2>
        <h3>
        <ul style="list-style-type:circle;">
        <li><img src="assets/star.png"> - Star - gives 10 points.
        <li><img src="assets/onions.png"> - Small Onion - gives 5 points and increases 5 health. Maximum Health = 100.
        <li><img src="assets/onions2.png"> - Big Onion - gives 25 points and increases 1 life. Maximum Life = 3.
        <li><img src="assets/gun.png"> - Gun - gives 50 points and gives the ability to shoot bullets.
        <li><img src="assets/goli.png"> - Bullet - gives 1 point when you hit the enemy and decreases 5 health of the enemy.
        </ul>
        </h3>
        <h2>Obstacles & Enemies : </h2>
        <h3>
        <ul style="list-style-type:circle;">
        <li><img src="assets/bomb.png"> - Bomb - decreases your health by 10.
        <li><img src="assets/cloud.png"> - Cloud - decreases your health by 2.
        <li><img src="assets/birds2.png"> - Bird - decreases your health by 4. It has 100 health. Gives 100 points when you kill it.
        <li><img src="assets/alien2.png"> - Alien - decreases your health by 100. It has 150 health. Gives 150 points when you kill it.
        </ul>
        </h3>
        <h2>Doors : </h2>
        <h3>
        <ul style="list-style-type:circle;">
        <li><img src="assets/shut_door.png"> - Closed Door - Collect all the stars in the level to open it.
        <li><img src="assets/open_door.png"> - Opened Door - You can move to it to go to the next level.
        </ul>
        </h3>
    </p>
</body>
</html>