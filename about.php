<?php
include("app/classes/DB.php");
include('app/classes/Login.php');
$visitor_id = Login::isLoggedIn();
if ($visitor_id != 0) {
    $user = DB::select(['*'], ['users'], ['id' => $visitor_id])[0];
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css2?family=Candal&family=Lora:wght@500&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" rel="stylesheet">


    <script src="https://kit.fontawesome.com/a2de648733.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="assets/css/style.css">



    <title>CLC</title>
</head>

<body>
    <?php //include("app/includes/header.php"); 
    ?>
    <!--<?php //if (isset($_SESSION['welcome-msg'])) : 
        ?>
        <div class="welcome-msg" id="welcome-msg"></div>
        <script>
            let msgElement = document.getElementById('welcome-msg');
            /*createElement('div');
            msgElement.classList.add('welcome-msg');
            document.body.appendChild(msgElement);*/
            let msg = document.createTextNode("<?php //echo $_SESSION['welcome-msg']; 
                                                ?>");
            msgElement.appendChild(msg);
            setTimeout(function() {
                var op = 1;
                var timer = setInterval(function() {
                    if (op <= 0.1) {
                        clearInterval(timer);
                        msgElement.style.display = 'none';
                    }
                    msgElement.style.opacity = op;
                    msgElement.style.filter = 'alpha(opacity=' + op * 100 + ")";
                    op -= op * 0.1;
                }, 50);
            }, 3000);
        </script>
        <?php //unset($_SESSION['welcome-msg']); 
        ?>
    <?php //endif; 
    ?> -->
    <nav>
        <div class="logo">
            <h2><span>CL</span> Channel</h2>
        </div>
        <div class="menu">
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="#">ABOUT</a></li>
                <?php if ($visitor_id != 0) : ?>
                    <li><a href="newpost">POST</a></li>
                    <li><a href="profile?username=<?php echo $user['username']; ?>"><?php echo $user['username']; ?></a></li>
                <?php else : ?>
                    <li><a href="create-account">SIGNUP</a></li>
                    <li><a href="login">LOGIN</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <header>
        <div class="banner-area">
            <div class="single-banner">
                <img class="banner-img" src="assets/images/slide1.jpg" alt="">
                <div class="banner-text">
                    <h2>Welcome to <br>Computing Learning Channel</h2>
                </div>
            </div>
            <div class="single-banner">
                <img class="banner-img" src="assets/images/slide2.jpg" alt="">
                <div class="banner-text">
                    <h2>Welcome!Slide 2</h2>
                </div>
            </div>
        </div>
    </header>


    <center>
        <p style="font-size: 40px;">
            OUR GOAL
        </p>
        Create an information exchange platform. We are all relay nodes, with their own efforts to convey information.
    </center>

    <br>

    <table style="margin: 0px;padding: 0px;">
        <td style="margin: 0px;padding: 0px;">
            <div class="col-md-6 col-sm-6">
                <center>
                    <img class="img img-circle" src="./assets/images/heart.png" height="120px" width="120px"
                         style="border-radius: 50%;border: 2px solid black;">
                    <h4><b>Ding Yukuan</b></h4>
                    <p>A software developer who is always trying to push boundaries in search of great breakthroughs. Off from his desk, you can find him cheering up his buddies and enjoying life.</p>
                </center>
            </div>
        </td>
        <br>
        <br>
        <td style="margin: 0px;padding: 0px;">
            <div class="col-md-6 col-sm-6">
                <center>
                    <img class="img img-circle" src="./assets/images/heart.png" height="120px" width="120px"
                         style="border-radius: 50%;border: 2px solid black;">
                    <h4><b>Li Jinlin</b></h4>
                    <p>A passionate developer who always tries to learn new technology and software. In his free time, either he reads some articles or learns some other stuff.</p>
                </center>
            </div>
        </td>
    </table>
    <table style="margin: 0px;padding: 0px;">
        <td style="margin: 0px;padding: 0px;">
            <div class="col-md-6 col-sm-6">
                <center>
                    <img class="img img-circle" src="./assets/images/heart.png" height="120px" width="120px"
                         style="border-radius: 50%;border: 2px solid black;">
                    <h4><b>Wang Hewei</b></h4>
                    <p>A software developer who is always trying to push boundaries in search of great breakthroughs. Off from his desk, you can find him cheering up his buddies and enjoying life.</p>
                </center>
            </div>
        </td>
        <td style="margin: 0px;padding: 0px;">
            <div class="col-md-6 col-sm-6">
                <center>
                    <img class="img img-circle" src="./assets/images/heart.png" height="120px" width="120px"
                         style="border-radius: 50%;border: 2px solid black;">
                    <h4><b>Zhang Caiqi</b></h4>
                    <p>A passionate developer who always tries to learn new technology and software. In his free time, either he reads some articles or learns some other stuff.</p>
                </center>
            </div>
        </td>
    </table>
    
    <br>
    <br>
    <br>
    <?php include("app/includes/footer.php"); ?>
    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- Custon Script -->

    <script src="assets/js/header.js"></script>
    <script src="assets/js/slide.js"></script>
    
</body>

</html>