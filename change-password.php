<?php
include("app/classes/DB.php");
if (!isset($_GET['token'])){
    die("403 Forbidden");
}else{
    $token = $_GET['token'];
    $result = DB::select(
        ['*'], ['password_tokens'], ['token'=>'"'.sha1($token).'"'])[0];
}
$correct = true;
$changed = false;

if (isset($_POST['change-password-btn'])) {
        if($_POST['np']==$_POST['npa']){          
            DB::update('users', ['id' => $result['user_id']], ['password' => '"'.password_hash($_POST['np'], PASSWORD_DEFAULT).'"']);
            $changed = true;
        }else{
            $correct = false;
        }
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css2?family=Candal&family=Lora:wght@500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2de648733.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/user.css">
    <title>Forget password</title>
</head>

<body id="user-pane">
    <?php include('app/includes/header.php'); ?>
    <div class="auth-content">
    <?php if($changed):?>
    <h3 style="margin: 5px 5px 5px 5px;">Password Changed <i class="fa fa-check-circle" aria-hidden="true"></i></h3>
    <?php else: ?>
        <form action="change-password?token=<?php echo $token; ?>" method="post">
            <div class="form-title">Forget password</div>
            <?php if(!$correct):?>
                <div class="error-msg" id="error-msg">
                <li>Password Inconsistent</li></div>
            <?php endif; ?>  
            <div class="form-item">
                <label>New Password</label>
                <input type="text" placeholder="New Password" name="np" class="text-input">
            </div>
            <div class="form-item">
                <label>Comfirm Password</label>
                <input type="text" placeholder="New Password Again" name="npa" class="text-input">
            </div>
            <button type="submit" name="change-password-btn" class="submit-btn">Change Password</button>
        </form>
        <?php endif; ?>  
    </div>