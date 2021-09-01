<?php
include('app/classes/Login.php');
include('app/classes/DB.php');
$errors = array();
$userid = Login::isLoggedIn();
if ($userid == 0) {
    header('location: ./login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Candal&family=Lora:wght@500&family=Roboto&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/a2de648733.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="assets/css/management.css">



    <title>New post</title>
</head>
<style>
    #tag-picker {
        overflow: hidden;
        height: auto;
        border: 1px solid #ccc;
        border-radius: 5px;
        align-items: center;
        margin: 20px;
        display: flex;
        flex-wrap: wrap;
        background: white;
    }

    .tags {
        line-height: 20px;
        color: white;
        display: flex;
        flex-wrap: wrap;
        font-size: 12px;
    }

    .tags .tag-item {
        padding: 5px 2px 5px 10px;
        margin: 5px 2px 5px 2px;
        border-radius: 100px;
        background: #00a1d6;
        display: flex;
    }

    .tags .tag-item>* {
        margin: 0 10px 0 0;
    }

    .box {
        flex: 1;
        width: 150px;
        min-width: 150px;
        height: 40px;
    }

    .box input {
        width: 100%;
        border: none;
        height: 40px;
        line-height: 35px;
        background: transparent;
        -webkit-appearance: none;
        margin-left: 5px
    }

    .box input:active {
        border-color: blue
    }

    span {
        cursor: pointer;
        font-size: 12px;
        user-select: none;
    }

    .tips {
        margin: 5px 5px;
        height: 30px;
        line-height: 30px;
        font-size: 12px;
        color: gray
    }

    div.shaker {
        animation: shake 0.3s;
        animation-iteration-count: 1;
    }

    @keyframes shake {
        0% {
            transform: translate(1px, 1px) rotate(0deg);
        }

        10% {
            transform: translate(-1px, -2px) rotate(-1deg);
        }

        20% {
            transform: translate(-3px, 0px) rotate(1deg);
        }

        30% {
            transform: translate(3px, 2px) rotate(0deg);
        }

        40% {
            transform: translate(1px, -1px) rotate(1deg);
        }

        50% {
            transform: translate(-1px, 2px) rotate(-1deg);
        }

        60% {
            transform: translate(-3px, 1px) rotate(0deg);
        }

        70% {
            transform: translate(3px, 1px) rotate(-1deg);
        }

        80% {
            transform: translate(-1px, -1px) rotate(1deg);
        }

        90% {
            transform: translate(1px, 2px) rotate(0deg);
        }

        100% {
            transform: translate(1px, -2px) rotate(-1deg);
        }
    }
</style>

<body>
    <?php include("app/includes/header.php"); ?>

    <div class="page-wrapper">
        <div class="craft-panel">
            <div class="newpost-content">
                <form action="newpost.php" method="post" enctype="multipart/form-data">
                    <div class="form-title">New post</div>
                    <div class="divide-wrapper">
                        <div class="side">
                            <div class="form-item img-uploader">
                                <div class="uploader-title">
                                    <label id="img-lbl">Cover Image</label>
                                    <input type="file" name="cover_image" class="chooseimg-btn" id="imgInp">

                                </div>

                                <div class="img-frame" style="background-image: url(assets/images/cover_upload.png);" id="img-frame">
                                    <button type="button" for="imgInp" id="upload-btn">upload</button>
                                </div>
                            </div>
                            <label id="tag-lbl">Tags</label>
                            <div id="tag-picker">
                                <div class="tags">
                                </div>
                                <div class="box"><input id="tag-input" type="text" placeholder="press enter to create tag"></div>
                                <div class="tips">
                                    10 more tags available
                                </div>
                            </div>

                        </div>

                        <div class="side">
                            <div class="form-item">
                                <label id="post-title-lbl">Post Title</label>
                                <input type="text" placeholder="Post Title" name="postTitle" class="text-input" id="post-title">
                                <!textarea type="text" placeholder="Post Title" oninvalid="this.setCustomValidity('please input the post title')" onchange="this.setCustomValidity('')" required name="postTitle" class="text-input"></textarea>
                            </div>
                            <div class="form-item">
                                <label id="url-lbl">Source URL</label>
                                <input type="text" placeholder="URL" name="url" class="text-input" id="url">
                                <!textarea type="text" placeholder="URL" name="url" required class="text-input" oninvalid="this.setCustomValidity('please input the url')" onchange="this.setCustomValidity('')" required></textarea>
                            </div>
                            <div class="form-item">
                                <label id="description-lbl">Description</label>
                                <!input type="text" placeholder="Description" name="description" class="text-input" id="description" style="height: 100px;">
                                <textarea type="text" name="description" class="text-input" id="description" placeholder="Description" style="height: 100px;"></textarea>
                            </div>
                            <div class="form-item">
                                <label>Resource Type*</label><br>
                                <ul class="radio-group">
                                    <li>
                                        <input type="radio" value="oer-src" name="srcType" id="srcType01" checked="true">
                                        <label for="srcType01" style="border-top-left-radius: 5px;border-bottom-left-radius: 5px; border-right: 2px solid #061836">Open Resources</label>
                                    </li>
                                    <li>
                                        <input type="radio" value="tut-src" name="srcType" id="srcType02">
                                        <label for="srcType02" style="border-top-right-radius: 5px;border-bottom-right-radius: 5px; border-left: 2px solid #061836">Tutorials</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <button type="button" name="postsubmit-btn" class="postsubmit-btn" id="postsubmit-btn">Post</button>

                </form>
            </div>

        </div>
    </div>

    <?php include("app/includes/footer.php"); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <!-- Custom Script -->
    <script src="assets/js/header.js"></script>
    <script src="assets/js/imagepreview.js"></script>
    <script>
        $("#upload-btn").unbind("click").bind("click", function() {
            $("#imgInp").click();
        });
    </script>
    <script>
        tagsCount = 0;
        document.getElementById("tag-input").addEventListener("keydown", function(e) {
            console.log(e);
            if (e.keyCode == 13) {
                add_tag(this.value);
                this.value = '';
            }

        });
        document.getElementById('tag-picker').addEventListener('click', function(e) {
            var event = e || window.event;
            var target = event.target || event.srcElement;
            console.log(e.target.className);
            if (target.className == "btn-x") {
                console.log(target.parentNode.parentNode.removeChild(target.parentNode));
                tagsCount--;
                document.getElementsByClassName('tips')[0].style.color = 'black'
            }
        });
        var tags = document.getElementsByClassName('tags')[0];

        function add_tag(tagName) {
            if (tagsCount < 10) {
                if ((oritag = checkDup(tagName)) != null) {
                    oritag.classList.add('shaker');
                    setTimeout(function() {
                        oritag.classList.remove('shaker');
                    }, 300);
                } else {
                    var child = document.createElement('div');
                    child.className = 'tag-item';
                    child.innerHTML = '<p>' + tagName.trim().toLowerCase() + '</p> <span class="btn-x">X</span>';
                    tags.appendChild(child);
                    tagsCount++;
                    document.getElementsByClassName('tips')[0].innerText = (10 - tagsCount) + ' more tags available';
                }

            } else {
                document.getElementsByClassName('tips')[0].style.color = 'red'
            }
        }

        function checkDup(newtag) {
            formertags = document.querySelectorAll(".tag-item > p");
            for (i = 0; i < tagsCount; i++) {
                tag = formertags[i];
                if (newtag.trim().toLowerCase() == tag.innerText) {
                    console.log(tag.parentNode)
                    return tag.parentNode;
                }
            }
            return null;
        }
        document.getElementById("postsubmit-btn").addEventListener("click", function() {
            var formData;
            var fileData;
            var fileExtension = "png";
            var errorNum = 0;
            
            if ($('#imgInp').prop('files')[0] != undefined) {
                fileData = $('#imgInp').prop('files')[0];
                fileExtension = fileData.name.split('.').pop().toLowerCase();
            }
            if (tagsCount==0){
                $('#tag-lbl').html("Tags <span> *At least 1 tag is required</span>");
                errorNum++;
            }
            if (jQuery.inArray(fileExtension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $('#img-lbl').html("Cover Image <span> *Unsupported format</span>");
                errorNum++;
            }
            if ($('#post-title').val() == "") {
                $('#post-title-lbl').html("Post Title <span>*Must enter title</span>");
                errorNum++;
            }
            if ($('#url').val() == "") {
                $('#url-lbl').html("URL <span>*Must enter URL</span>");
                errorNum++;
            }
            if ($('#description').val() == "") {
                $('#description-lbl').html("Description <span>*Must enter description</span>");
                errorNum++;
            }
            if (errorNum == 0) { //TODO: image resizer and resolution control
                $('#img-lbl').html("Cover Image");
                $('#post-title-lbl').html("Post Title");
                $('#url-lbl').html("URL");
                $('#tag-lbl').html("Tags");
                $('#description-lbl').html("Description");

                formData = new FormData();
                if ($('#imgInp').prop('files') != undefined) {
                    formData.append("cover_image", fileData);
                }
                alltags = [];
                formertags = document.querySelectorAll(".tag-item > p");
                for (i = 0; i < tagsCount; i++) 
                    alltags.push(formertags[i].innerText);
                alltags=JSON.stringify(alltags);
                console.log(alltags);
                formData.append("postTitle", $("#post-title").val());
                formData.append("url", $("#url").val());
                formData.append("description", $("#description").val());
                formData.append("user_id", <?php echo $userid; ?>);
                formData.append("src_type", $('input[name=srcType]:checked').val() == "tut-src" ? "TUT" : "OER");
                formData.append("tags", alltags);
                $.ajax({
                    url: "api/posts",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(r) {
                        alert("Post uploaded!")
                    },
                    error: function(r) {
                        console.log(r);
                    }

                });
            } else {
                errorNum = 0;
            }
        });
    </script>
</body>

</html>