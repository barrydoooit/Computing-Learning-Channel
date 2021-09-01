<?php
include_once('app/classes/DB.php');
include_once('app/classes/Login.php');
$user=array();
if($user_id=Login::isLoggedIn()){
    $user = DB::query('SELECT * FROM users WHERE id=:id', array(':id' => $user_id))[0];
}
?>
<header>
    <div class="logo">
        <h1 class="logo-text"><span>CL</span> Channel</h1>
    </div>
    <i class="fa fa-bars menu-toggle"></i>
    <ul class="nav">
        <li><a href="./index.php">Home</a></li>
        <li><a href="./about.php">About</a></li>
        <!--<li><a href="./create-account.php">Sign up</a></li>
        <li><a href="#">Login</a></li>
        <li><a href="#">Video</a></li> -->    
        <li><a href="#">General</a></li>

        <?php if (isset($_COOKIE['SNID'])) : ?>
            <li><a href="newpost.php">Post</a></li>
            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <?php echo $user['username']; ?>
                    <i class="fa fa-chevron-down" style="font-size: .8em"></i>
                </a>
                <ul>
                    <?php if($user['admin']): ?>
                        <li><a href="#">Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="./logout.php" class="logout">Logout</a></li>
                </ul>
            </li>
        <?php else : ?>
            <li><a href="./signup.php">Sign Up</a></li>
            <li><a href="./login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</header>
