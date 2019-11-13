<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}
?>
<!doctype html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8" />
    <title>Level-0 -- <?php echo htmlspecialchars($_SESSION["gamingname"]); ?></title>
    <script src="assets/phaser11.js"></script>
    <style type="text/css">
        body {
            margin: 0;
        }
    </style>
</head>
<body>
<a href="osne.php" onclick="location.href='home.php';return false;">Home Screen</a>
<a href="osne.php" onclick="location.href='logout.php';return false;" style="float:right;">Log Out</a>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<script type="text/javascript">

var config = {
    type: Phaser.AUTO,
    width: 1370,
    height: 700,
    physics: {
        default: 'arcade',
        arcade: {
            gravity: { y: 500 },
            debug: false
        }
    },
    scene: {
        preload: preload,
        create: create,
        update: update
    }
};

var player;
var stars;
var platforms;
var base;
var cursors;
var score = 0;
var health = 100;
var life = 3;
var gameOver = false;
var scoreText;
var healthText;
var lifeText;
var gameText;
var checkpointX,checkpointY;

var game = new Phaser.Game(config);

function preload ()
{
    this.load.audio('background', 'assets/background.mp3');
    this.load.image('sky', 'assets/sky_.png');
    this.load.image('ground', 'assets/platform_.png');
    this.load.image('star', 'assets/star.png');
    this.load.image('groundbase', 'assets/groundbase.png');
    this.load.image('wall', 'assets/wall_.png');
    this.load.image('opendoor', 'assets/open_door.png');
    this.load.image('shutdoor', 'assets/shut_door.png');
    this.load.spritesheet('dude', 'assets/dude.png', { frameWidth: 32, frameHeight: 48 });
}

function create ()
{
    let backSound = this.sound.add('background');
    backSound.play();
    
    this.add.image(685, 350, 'sky');

    wall = this.physics.add.staticGroup();
    for(i=625;i>=150;i-=25){
        wall.create(655,i,'wall');
    }
    
    base = this.physics.add.staticGroup();
    base.create(675, 750, 'groundbase').setScale(2.1).refreshBody();

    platforms = this.physics.add.staticGroup();
    platforms.create(1200, 500, 'ground');
    platforms.create(1000, 400, 'ground');
    platforms.create(800, 300, 'ground');
    platforms.create(1100, 220, 'ground');
    platforms.create(1200, 100, 'ground');
    platforms.create(800, 100, 'ground');
    platforms.create(100, 500, 'ground');
    platforms.create(300, 400, 'ground');
    platforms.create(500, 300, 'ground');
    platforms.create(200, 220, 'ground');
    platforms.create(100, 100, 'ground');
    platforms.create(500, 100, 'ground');

    shutdoor = this.physics.add.staticGroup();
    shutdoor.create(1350, 600, 'shutdoor');

    player = this.physics.add.sprite(50, 550, 'dude');
    player.setBounce(0.1);
    player.setCollideWorldBounds(true);

    this.anims.create({
        key: 'left',
        frames: this.anims.generateFrameNumbers('dude', { start: 0, end: 3 }),
        frameRate: 10,
        repeat: -1
    });

    this.anims.create({
        key: 'turn',
        frames: [ { key: 'dude', frame: 4 } ],
        frameRate: 20
    });

    this.anims.create({
        key: 'right',
        frames: this.anims.generateFrameNumbers('dude', { start: 5, end: 8 }),
        frameRate: 10,
        repeat: -1
    });

    cursors = this.input.keyboard.createCursorKeys();

    stars = this.physics.add.group({
        key: 'star',
        repeat: 18,
        setXY: { x: 12, y: 125, stepX: 70}
    });

    stars.children.iterate(function (child) {

        child.setBounceY(Phaser.Math.FloatBetween(1, 1));

    });

    this.physics.add.collider(player, base);
    this.physics.add.collider(player, platforms);
    this.physics.add.collider(player, wall);
    this.physics.add.collider(stars, base);
    this.physics.add.collider(stars, platforms);
    this.physics.add.collider(stars, wall);
    this.physics.add.collider(shutdoor, base);  

    this.physics.add.overlap(player, stars, collectStar, null, this);

    this.physics.add.overlap(player, shutdoor, checkWin, null, this);

    scoreText = this.add.text(16, 16, 'Score: 0', { fontSize: '32px', fill: '#000' });
    healthText = this.add.text(526, 16, 'Health: 100%', { fontSize: '32px', fill: '#000' })
    lifeText = this.add.text(1186, 16, 'Lives: 3', { fontSize: '32px', fill: '#000' });
    gameText = this.add.text(481, 286, '', { fontSize: '64px', fill: '#fff' });
}

function update ()
{

    if (gameOver)
    {
        return;
    }

    if (cursors.left.isDown)
    {
        player.setVelocityX(-150);
        player.anims.play('left', true);
    }
    else if (cursors.right.isDown)
    {
        player.setVelocityX(150);
        player.anims.play('right', true);
    }
    else
    {
        player.setVelocityX(0);
        player.anims.play('turn');
    }

    if (cursors.up.isDown && player.body.touching.down)
    {
        player.setVelocityY(-375);
    }

        checkpointX=player.x;
        checkpointY=player.y-50;
}

function collectStar (player, star)
{
    star.disableBody(true, true);
    score += 10;
    scoreText.setText('Score: ' + score);
    if(stars.countActive(true) === 0)
    {
        opendoor = this.physics.add.staticGroup();
        opendoor.create(1354, 600, 'opendoor');
    }
}

function checkWin (player, shutdoor)
{
    if(stars.countActive(true) === 0)
    {
        scoreText.setText('Score: ' + score);
        this.physics.pause();
        player.setTint(0x00ff00);
        player.anims.play('turn');
        gameOver = true;
        gameText.setText('Next Level\nLoading...');
        score=score+health+(life*100)+100;
        scoreText.setText('Final Score: ' + score);
        window.setInterval(nextLevel,3000);
    }
}

function nextLevel()
{
    setCookie("score",score,100);
    setCookie("health",health,100);
    setCookie("life",life,100);
    window.open("bseg.php","_self");
}

function setCookie(cname, cvalue, exdays)
{
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
</script>

</body>
</html>