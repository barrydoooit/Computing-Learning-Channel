<?php
include("app/classes/DB.php");
define('mail_from','EcoCOMP@comp.polyu.edu.hk');
$errors = array();
if (isset($_POST['sendemail-btn'])) {
    $cstrong = True;
    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, 'Invalid email');
    } else {
        $user_id = DB::query('SELECT id FROM users WHERE email=:email', array(':email' => $email));
    }
    if (empty($user_id)) {
        array_push($errors, 'Email has not been registered');
        echo 'Email has not been registered';
    } else {
        DB::query(
            'INSERT INTO password_tokens(id, token, user_id) VALUES (:id, :token, :user_id)',
            array(':id' => '', ':token' => sha1($token), ':user_id' => $user_id[0]['id'])
        );
        
        
    
        // Send email to user with the token in a link they can click on
        $to = $email;
        $subject = "Reset your password on CL Channel";
        $headers = 'From: ' . mail_from . "\r\n"
            . 'Reply-To: ' . mail_from . "\r\n"
            . 'Return-Path: ' . mail_from . "\r\n"
            . 'X-Mailer: PHP/' . phpversion() . "\r\n"
            . 'MIME-Version: 1.0' . "\r\n"
            . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        $msg = "<html>
                        <head>
                            <title>HTML email</title>
                        </head>
                        <body>
                            <p>" . "Hi there, click on this <a href=\"https://clc.comp.polyu.edu.hk/change-password?token=" . $token //need to change href accordingly 
            . "\">link</a> to reset your password on our site"
            . "</p>
                        </body>
                    </html>";

        $msg = wordwrap($msg, 500);

        mail($to, $subject, $msg, $headers);

    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css2?family=Candal&family=Lora:wght@500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/user.css">
    <title>Forget password</title>
</head>

<body id="user-pane">
    <?php include('app/includes/header.php'); ?>
    <div class="auth-content">
        <form action="forgot-password.php" method="post">
            <div class="form-title">Forget password</div>
            <div class="form-item">
                <label>Email</label>
                <input type="text" placeholder="Email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" class="text-input">
            </div>
            <button type="submit" name="sendemail-btn" class="submit-btn" onclick="alert('Email sent');">Send verification email</button>
        </form>
    </div>
</body>