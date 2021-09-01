<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css2?family=Candal&family=Lora:wght@500&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/a2de648733.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="assets/css/user.css">
    <title>Login</title>
</head>

<body id="user-pane">
    <?php include('app/includes/header.php'); ?>
    <?php //include('app/includes/welcome-msg.php'); 
    ?>

    <div class="auth-content">
        <form action="login.php" method="post">
            <div class="form-title">Login</div>
            <div class="error-msg" id="error-msg" style="display: none"></div>
            <div class="form-item">
                <label>Email</label>
                <input type="email" placeholder="Email" name="email" id="email" class="text-input">
            </div>
            <div class="form-item">
                <label>Password</label>
                <input type="password" placeholder="Password" name="password" id="password" class="text-input">
                <div class="forgot"> <a href="forgot-password.php">Forgot Password</a></div>
            </div>

            <button type="button" name="login-btn" id="login-btn" class="submit-btn">Login</button>
        </form>
        <div class="alternate">Do not have an account? <a href="create-account.php">Sign Up</a></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="assets/js/header.js"></script>
    <script type="text/javascript">
        $('#login-btn').click(function() {
            $.ajax({
                type: "POST",
                url: "api/auth",
                processData: false,
                contentType: "application/json",
                data: '{ "email": "' + $("#email").val() + '", "password": "' + $("#password").val() + '" }',
                success: function(r) {
                    var errorMsgElement = document.getElementById("error-msg");
                    errorMsgElement.style.display="none";
                    console.log("login success");
                    var response = JSON.parse(r);
                    var token = response.Token;
                    console.log(token);
                    var date = new Date();
                    var dateTime = date.getTime();
                    date.setTime(dateTime + (60 * 60 * 24 * 7 * 1000));
                    document.cookie =  "SNID="+token+"; expires="+date+"; path=/"; 
                    date.setTime(dateTime + (60 * 60 * 24 * 3 * 1000));
                    document.cookie =  "SNID_=1; expires="+date+"; path=/";          
                    window.location.replace("index.php");
                },
                error: function(r) {
                    var errorMsgElement = document.getElementById("error-msg");
                    errorMsgElement.style.display="block";
                    while (errorMsgElement.firstChild) {
                        errorMsgElement.removeChild(errorMsgElement.firstChild);
                    }
                    var errorResponse = JSON.parse(r.responseText);
                    for (errorMsg in errorResponse) {
                        if (errorResponse[errorMsg] != "") {
                            var li = document.createElement("li");
                            li.innerText = errorResponse[errorMsg];
                            errorMsgElement.appendChild(li);
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>