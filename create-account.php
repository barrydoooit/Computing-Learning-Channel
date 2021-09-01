<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css2?family=Candal&family=Lora:wght@500&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/a2de648733.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="assets/css/user.css">


    <title>sign up</title>
</head>

<body id="user-pane">
    <?php include("app/includes/header.php"); ?>

    <div class="auth-content clearfix">
        <form action="create-account.php" method="post" enctype="multipart/form-data">
            <div class="form-title">Sign Up</div>
            <div class="error-msg" id="error-msg" style="display: none"></div>
            <div class="form-item">
                <input type="file" accept="image/*" name="profile_image" id="imgInp">
                <label for="imgInp" id="img-frame" style="background-image: url(assets/images/user-profile/default.png);"><label>
            </div>
            <div class="form-item">
                <label>Username</label>
                <input type="text" placeholder="Username" name="username" id="username" class="text-input">
            </div>
            <div class="form-item">
                <label>Email</label>
                <input type="text" placeholder="Email" name="email" id="email" class="text-input">
            </div>
            <div class="form-item">
                <label>Password</label>
                <input type="password" placeholder="Password" name="password" id="password" class="text-input">
            </div>
            <div class="form-item">
                <label>Confirm Password</label>
                <input type="password" placeholder="Confirm Password" name="passwordConf" id="passwordConf" class="text-input">
            </div>
            <button type="button" name="signup-btn" id="signup-btn" class="signup-btn">Register</button>
        </form>
        <div class="alternate">Already have an account? <a href="login.php">Login</a></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="assets/js/imagepreview.js"></script>
    <script type="text/javascript">
        $('#signup-btn').click(function(e) {
            var formData;
            var fileData;
            var fileExtension = "png";
            if ($('#imgInp').prop('files')[0] != undefined) {
                fileData = $('#imgInp').prop('files')[0];
                fileExtension = fileData.name.split('.').pop().toLowerCase();
            }
            if (jQuery.inArray(fileExtension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                var errorMsgElement = document.getElementById("error-msg");
                while (errorMsgElement.firstChild) {
                    errorMsgElement.removeChild(errorMsgElement.firstChild);
                }
                var li = document.createElement("li");
                li.innerText = "Profile image format is not correct";
                errorMsgElement.appendChild(li);
            } else { //TODO: image resizer and resolution control
                formData = new FormData();
                if ($('#imgInp').prop('files') != undefined) {
                    formData.append("profile_image", fileData);
                }
                formData.append("username", $("#username").val());
                formData.append("email", $("#email").val());
                formData.append("password", $("#password").val());
                formData.append("passwordConf", $("#passwordConf").val());
                $.ajax({
                    url: "api/users",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(r) {
                        var errorMsgElement = document.getElementById("error-msg");
                        errorMsgElement.style.display = "none";
                        console.log("success"); //TODO: head to login page
                    },
                    error: function(r) {
                        var errorMsgElement = document.getElementById("error-msg");
                        errorMsgElement.style.display = "block";
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
            }

        });
    </script>
</body>

</html>