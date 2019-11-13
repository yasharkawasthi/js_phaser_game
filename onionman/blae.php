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
    <title>Level-5 -- <?php echo htmlspecialchars($_SESSION["gamingname"]); ?></title>
    <script src="assets/phaser11.js"></script>
    <style type="text/css">
        body {
            margin: 0;
        }
    </style>
</head>
<body>
<a href="blae.php" onclick="location.href='home.php';return false;">Home Screen</a>
<a href="blae.php" onclick="location.href='logout.php';return false;" style="float:right;">Log Out</a>
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
var gun;
var bullets;
var stars;
var onions;
var bombs;
var clouds;
var platforms;
var base;
var cursors;
var gunV=0;
var score = 0;
var health = 100;
var life = 3;
var gameOver = false;
var scoreText;
var healthText;
var lifeText;
var gameText;
var checkpointX,checkpointY;
var bird1H=100,bird2H=100,bird3H=100;
var alien1H=150,alien2H=150,alien3H=150;
var timesPressed=0;

var game = new Phaser.Game(config);

function preload ()
{
    this.load.audio('background', 'assets/background.mp3');
    this.load.image('sky', 'assets/sky_.png');
    this.load.image('ground', 'assets/platform_.png');
    this.load.image('star', 'assets/star.png');
    this.load.image('onion', 'assets/onions.png');
    this.load.image('gun', 'assets/gun.png');
    this.load.image('bullet', 'assets/goli.png');
    this.load.image('bomb', 'assets/bomb.png');
    this.load.image('cloud', 'assets/cloud.png');
    this.load.image('groundbase', 'assets/groundbase.png');
    this.load.image('wall', 'assets/wall_.png');
    this.load.image('opendoor', 'assets/open_door.png');
    this.load.image('shutdoor', 'assets/shut_door.png');
    this.load.spritesheet('dude', 'assets/dude.png', { frameWidth: 32, frameHeight: 48 });
    this.load.spritesheet('alien', 'assets/alien.png', { frameWidth: 32, frameHeight: 50 });
    this.load.spritesheet('bird', 'assets/birds.png', { frameWidth: 44, frameHeight: 50 });
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

    bombs = this.physics.add.staticGroup();
    bombs.create(100, 80, 'bomb').setScale(1.5);
    bombs.create(550, 280, 'bomb').setScale(1.5);
    bombs.create(300, 380, 'bomb').setScale(1.5);
    bombs.create(150, 480, 'bomb').setScale(1.5);
    bombs.create(300, 610, 'bomb').setScale(1.5);
    bombs.create(1200, 80, 'bomb').setScale(1.5);
    bombs.create(800, 280, 'bomb').setScale(1.5);
    bombs.create(1000, 380, 'bomb').setScale(1.5);
    bombs.create(1150, 480, 'bomb').setScale(1.5);
    bombs.create(1000, 610, 'bomb').setScale(1.5);

    clouds = this.physics.add.staticGroup();
    clouds.create(400, 200, 'cloud').setScale(1.5);
    clouds.create(200, 120, 'cloud').setScale(1.5);
    clouds.create(300, 300, 'cloud').setScale(1.5);
    clouds.create(150, 350, 'cloud').setScale(1.5);
    clouds.create(300, 450, 'cloud').setScale(1.5);
    clouds.create(900, 200, 'cloud').setScale(1.5);
    clouds.create(1100, 120, 'cloud').setScale(1.5);
    clouds.create(1000, 300, 'cloud').setScale(1.5);
    clouds.create(1150, 350, 'cloud').setScale(1.5);
    clouds.create(1000, 450, 'cloud').setScale(1.5);

    onions = this.physics.add.staticGroup();
    onions.create(50, 80, 'onion');
    onions.create(1250, 80, 'onion');
    onions.create(200, 200, 'onion');
    onions.create(1100, 200, 'onion');
    onions.create(400, 120, 'onion');
    onions.create(900, 320, 'onion');

    onionsL = this.physics.add.staticGroup();
    onionsL.create(620, 320, 'onion').setScale(1.5);
    onionsL.create(1320, 320, 'onion').setScale(1.5);

    gun = this.physics.add.staticGroup();
    gun.create(675, 125, 'gun');

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

    alien1 = this.physics.add.sprite(550, 550, 'alien');
    alien2 = this.physics.add.sprite(225, 225, 'alien');
    alien3 = this.physics.add.sprite(1300, 550, 'alien');

    bird1 = this.physics.add.sprite(550, 125, 'bird');
    bird2 = this.physics.add.sprite(1025, 350, 'bird');
    bird3 = this.physics.add.sprite(1300, 125, 'bird');

    this.anims.create({
        key: 'leftA',
        frames: this.anims.generateFrameNumbers('alien', { start: 0, end: 5 }),
        frameRate: 10,
        repeat: -1
    });

    this.anims.create({
        key: 'rightA',
        frames: this.anims.generateFrameNumbers('alien', { start: 8, end: 13 }),
        frameRate: 10,
        repeat: -1
    });

    this.anims.create({
        key: 'leftB',
        frames: this.anims.generateFrameNumbers('bird', { start: 0, end: 3 }),
        frameRate: 10,
        repeat: -1
    });

    this.anims.create({
        key: 'rightB',
        frames: this.anims.generateFrameNumbers('bird', { start: 4, end: 7 }),
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
    this.physics.add.collider(bombs, base);
    this.physics.add.collider(bombs, platforms);
    this.physics.add.collider(bombs, wall);    
    this.physics.add.collider(alien1, base);
    this.physics.add.collider(alien2, platforms);
    this.physics.add.collider(alien3, base);

    this.physics.add.overlap(player, stars, collectStar, null, this);
    this.physics.add.overlap(player, gun, collectGun, null, this);
    this.physics.add.overlap(player, onions, collectOnion, null, this);
    this.physics.add.overlap(player, onionsL, collectOnionL, null, this);

    this.physics.add.overlap(player, shutdoor, checkWin, null, this);
    this.physics.add.collider(player, bombs, hitBomb, null, this);
    this.physics.add.collider(player, clouds, hitCloud, null, this);

    this.physics.add.collider(player, alien1, hitAlien, null, this);
    this.physics.add.collider(player, alien2, hitAlien, null, this);
    this.physics.add.collider(player, alien3, hitAlien, null, this);
    this.physics.add.collider(player, bird1, hitBird, null, this);
    this.physics.add.collider(player, bird2, hitBird, null, this);
    this.physics.add.collider(player, bird3, hitBird, null, this);

    scoreText = this.add.text(16, 16, 'Score: 0', { fontSize: '32px', fill: '#000' });
    healthText = this.add.text(526, 16, 'Health: 100%', { fontSize: '32px', fill: '#000' })
    lifeText = this.add.text(1186, 16, 'Lives: 3', { fontSize: '32px', fill: '#000' });
    gameText = this.add.text(481, 286, '', { fontSize: '64px', fill: '#fff' });
    score=parseInt(getCookie("score"));
    health=parseInt(getCookie("health"));
    life=parseInt(getCookie("life"));
    scoreText.setText('Score: ' + score);
    healthText.setText('Health: ' + health + '%');
    lifeText.setText('Lives: '+ life);
}

var flagA1=0,flagA2=1,flagA3=0;
var flagB1=0,flagB2=1,flagB3=0;

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

    if (gunV==1 && cursors.down.isDown && timesPressed<1)
    {
        timesPressed++;
        bullets = this.physics.add.group();

        if(player.anims.currentAnim.key=='right')
        {
            bulletO=bullets.create(player.x+10, player.y+10, 'bullet');
            bulletO.setVelocityX(1000);
        }
        else if(player.anims.currentAnim.key=='left')
        {
            bulletO=bullets.create(player.x+10, player.y+10, 'bullet');
            bulletO.setVelocityX(-1000); 
        }
        else
        {
            bulletO=bullets.create(0, 0, 'bullet');
            bulletO.setVelocityX(-1000); 
        }

        this.physics.add.collider(bulletO, bird1, bulBird1, null, this);
        this.physics.add.collider(bulletO, bird2, bulBird2, null, this);
        this.physics.add.collider(bulletO, bird3, bulBird3, null, this);
        this.physics.add.collider(bulletO, alien1, bulAlien1, null, this);
        this.physics.add.collider(bulletO, alien2, bulAlien2, null, this);
        this.physics.add.collider(bulletO, alien3, bulAlien3, null, this);
        this.physics.add.collider(bulletO, wall, disableB, null, this);
        this.physics.add.collider(bulletO, base, disableB, null, this);
        this.physics.add.collider(bulletO, platforms, disableB, null, this);
    }
    else if(cursors.down.isDown==false)
    {
        timesPressed=0;
    }

    if(flagA1==0)
    {
        alien1.setVelocityX(-100);
        alien1.anims.play('leftA',true);
        if(alien1.x<50)
            flagA1=1;
    }
    if(flagA1==1)
    {
        alien1.setVelocityX(100);
        alien1.anims.play('rightA',true);
        if(alien1.x>550)
            flagA1=0;
    }

    if(flagA2==0)
    {
        alien2.setVelocityX(-100);
        alien2.anims.play('leftA',true);
        if(alien2.x<225)
            flagA2=1;
    }
    if(flagA2==1)
    {
        alien2.setVelocityX(100);
        alien2.anims.play('rightA',true);
        if(alien2.x>375)
            flagA2=0;
    }

    if(flagA3==0)
    {
        alien3.setVelocityX(-100);
        alien3.anims.play('leftA',true);
        if(alien3.x<700)
            flagA3=1;
    }
    if(flagA3==1)
    {
        alien3.setVelocityX(100);
        alien3.anims.play('rightA',true);
        if(alien3.x>1300)
            flagA3=0;
    }

    if(bird1.y>120)
        bird1.setVelocityY(-30);

    if(bird2.y>345)
        bird2.setVelocityY(-30);

    if(bird3.y>120)
        bird3.setVelocityY(-30);

    if(flagB1==0)
    {
        bird1.setVelocityX(-100);
        bird1.anims.play('leftB',true);
        if(bird1.x<175)
            flagB1=1;
    }
    if(flagB1==1)
    {
        bird1.setVelocityX(100);
        bird1.anims.play('rightB',true);
        if(bird1.x>425)
            flagB1=0;
    }

    if(flagB2==0)
    {
        bird2.setVelocityX(-100);
        bird2.anims.play('leftB',true);
        if(bird2.x<875)
            flagB2=1;
    }
    if(flagB2==1)
    {
        bird2.setVelocityX(100);
        bird2.anims.play('rightB',true);
        if(bird2.x>1275)
            flagB2=0;
    }

    if(flagB3==0)
    {
        bird3.setVelocityX(-100);
        bird3.anims.play('leftB',true);
        if(bird3.x<875)
            flagB3=1;
    }
    if(flagB3==1)
    {
        bird3.setVelocityX(100);
        bird3.anims.play('rightB',true);
        if(bird3.x>1125)
            flagB3=0;
    }

    checkpointX=player.x;
    checkpointY=player.y-50;

}

function collectGun (player, gun)
{
    gun.disableBody(true, true);
    score += 50;
    scoreText.setText('Score: ' + score);
    gunV=1;
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

function collectOnion (player, onion)
{
    onion.disableBody(true, true);
    score += 5;
    scoreText.setText('Score: ' + score);
    health=health+5;
    if(health>100)
        health=100;
    healthText.setText('Health: ' + health + '%');
}

function collectOnionL (player, onionL)
{
    onionL.disableBody(true, true);
    score += 25;
    scoreText.setText('Score: ' + score);
    life=life+1;
    if(life>3)
        life=3;
    lifeText.setText('Lives: ' + life);
}

function checkWin (player, shutdoor)
{
    if(stars.countActive(true) === 0)
    {
        scoreText.setText('Score: ' + score);
        gameText.setText('Game Won');

        this.physics.pause();

        player.setTint(0x00ff00);

        player.anims.play('turn');

        gameOver = true;

        alien1.disableBody(true, true);
        alien2.disableBody(true, true);
        alien3.disableBody(true, true);
        bird1.disableBody(true, true);
        bird2.disableBody(true, true);
        bird3.disableBody(true, true);
        score=score+health+(life*100)+1000;
        scoreText.setText('Grand Final Score: ' + score);
        window.setInterval(nextLevel,3000);
    }
}

function nextLevel()
{
    setCookie("score",score,100);
    setCookie("health",health,100);
    setCookie("life",life,100);
    high=parseInt(getCookie("high"));
    if(score>high)
        setCookie("high",score,100);
    window.open("exit.php","_self");
}

function bye()
{
    setCookie("score",score,100);
    setCookie("health",health,100);
    setCookie("life",life,100);
    high=parseInt(getCookie("high"));
    if(score>high)
        setCookie("high",score,100);
    window.open("exit.php","_self");
}

function setCookie(cname, cvalue, exdays)
{
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname)
{
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i < ca.length; i++)
  {
    var c = ca[i];
    while (c.charAt(0) == ' ')
    {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0)
    {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
function hitBomb(player, bomb)
{
    health=health-10;
    if(health<0)
        health=0;
    healthText.setText('Health: ' + health + '%');
    player.setVelocityY(-300);

    if(health<=0)
    {
        if(life==0)
        {
            scoreText.setText('Score: ' + score);
            gameText.setText('Game Over');
            this.physics.pause();
            player.setTint(0xff0000);
            player.anims.play('turn');
            gameOver = true;
            window.setInterval(bye,3000);
        }
        else
        {
            player.x=checkpointX;
            player.y=checkpointY;
            life--;
            health=100;
            healthText.setText('Health: ' + health + '%');
            lifeText.setText('Lives: '+ life);
        }
    }
}

function hitCloud(player, cloud)
{
    health=health-2;
    if(health<0)
        health=0;
    healthText.setText('Health: ' + health + '%');

    if(health<=0)
    {
        if(life==0)
        {
            scoreText.setText('Score: ' + score);
            gameText.setText('Game Over');
            this.physics.pause();
            player.setTint(0xff0000);
            player.anims.play('turn');
            gameOver = true;
            window.setInterval(bye,3000);
        }
        else
        {
            player.x=checkpointX;
            player.y=checkpointY;
            life--;
            health=100;
            healthText.setText('Health: ' + health + '%');
            lifeText.setText('Lives: '+ life);
        }
    }
}

function hitAlien(player,alien)
{
    health=health-100;
    if(health<0)
        health=0;
    healthText.setText('Health: ' + health + '%');

    if(health<=0)
    {
        if(life==0)
        {
            scoreText.setText('Score: ' + score);
            gameText.setText('Game Over');
            this.physics.pause();
            player.setTint(0xff0000);
            player.anims.play('turn');
            gameOver = true;
            alien1.disableBody(true, true);
            alien2.disableBody(true, true);
            alien3.disableBody(true, true);
            bird1.disableBody(true, true);
            bird2.disableBody(true, true);
            bird3.disableBody(true, true);
            window.setInterval(bye,3000);
        }
        else
        {
            player.x=checkpointX;
            player.y=checkpointY;
            life--;
            health=100;
            healthText.setText('Health: ' + health + '%');
            lifeText.setText('Lives: '+ life);
        }
    }
}

function hitBird(player,bird)
{
    health=health-4;
    if(health<0)
        health=0;
    healthText.setText('Health: ' + health + '%');

    if(health<=0)
    {
        if(life==0)
        {
            scoreText.setText('Score: ' + score);
            gameText.setText('Game Over');
            this.physics.pause();
            player.setTint(0xff0000);
            player.anims.play('turn');
            gameOver = true;
            bird1.disableBody(true, true);
            bird2.disableBody(true, true);
            bird3.disableBody(true, true);
            alien1.disableBody(true, true);
            alien2.disableBody(true, true);
            alien3.disableBody(true, true);
            window.setInterval(bye,3000);
        }
        else
        {
            player.x=checkpointX;
            player.y=checkpointY;
            life--;
            health=100;
            healthText.setText('Health: ' + health + '%');
            lifeText.setText('Lives: '+ life);
        }
    }
}

function bulBird1(bullet,birdy1)
{
    bird1H-=5;
    score=score+1;
    scoreText.setText('Score: ' + score);
    bullet.disableBody(true, true);
    if(bird1H<=0)
    {
        bird1.disableBody(true, true);
        score=score+100;
        scoreText.setText('Score: ' + score);
    }
}

function bulBird2(bullet,birdy2)
{
    bird2H-=5;
    score=score+1;
    scoreText.setText('Score: ' + score);
    bullet.disableBody(true, true);
    if(bird2H<=0)
    {
        bird2.disableBody(true, true);
        score=score+100;
        scoreText.setText('Score: ' + score);
    }
}

function bulBird3(bullet,birdy3)
{
    bird3H-=5;
    score=score+1;
    scoreText.setText('Score: ' + score);
    bullet.disableBody(true, true);
    if(bird3H<=0)
    {
        bird3.disableBody(true, true);
        score=score+100;
        scoreText.setText('Score: ' + score);
    }
}

function bulAlien1(bullet,alieny1)
{
    alien1H-=5;
    score=score+1;
    scoreText.setText('Score: ' + score);
    bullet.disableBody(true, true);
    if(alien1H<=0)
    {
        alien1.disableBody(true, true);
        score=score+150;
        scoreText.setText('Score: ' + score);
    }
}

function bulAlien2(bullet,alieny2)
{
    alien2H-=5;
    score=score+1;
    scoreText.setText('Score: ' + score);
    bullet.disableBody(true, true);
    if(alien2H<=0)
    {
        alien2.disableBody(true, true);
        score=score+150;
        scoreText.setText('Score: ' + score);
    }
}

function bulAlien3(bullet,alieny3)
{
    alien3H-=5;
    score=score+1;
    scoreText.setText('Score: ' + score);
    bullet.disableBody(true, true);
    if(alien3H<=0)
    {
        alien3.disableBody(true, true);
        score=score+150;
        scoreText.setText('Score: ' + score);
    }
}

function disableB(bullet,obstacle)
{
    bullet.disableBody(true,true);
}

</script>

</body>
</html>