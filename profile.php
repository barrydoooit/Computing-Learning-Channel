<?php
include('./app/classes/DB.php');
include('./app/classes/Login.php');

$username = "";
$isFollowing = false;
if (isset($_GET['username'])) {
    if (DB::query('SELECT id FROM users WHERE username=:username', array(':username' => $_GET['username']))) {
        $user = DB::query('SELECT * FROM users WHERE username=:username', array(':username' => $_GET['username']))[0];
        $username = $_GET['username'];
        $user_id = $user['id'];
        $visitor_id = Login::isLoggedIn();


        if (isset($_POST['follow'])) {

            if (!DB::query("SELECT id FROM followers WHERE user_id=$user_id")) {
                DB::insert('followers', ['user_id' => $user_id, 'follower_id' => $visitor_id]);
                $isFollowing = True;
            }
        }
        if (isset($_POST['unfollow'])) {

            if (DB::query("SELECT id FROM followers WHERE user_id=$user_id")) {
                DB::delete('followers', ['user_id' => $user_id, 'follower_id' => $visitor_id]);
                $isFollowing = false;
            }
        }
        if (DB::query("SELECT id FROM followers WHERE user_id=$user_id")) {
            //already following
            $isFollowing = True;
        }
    } else {
        die('User not found');
    }
    // include($_SERVER['DOCUMENT_ROOT'] . "/EvolvedChannel/app/includes/like.php");
}
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Candal&family=Lora:wght@500&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tammudu+2:wght@400;500&family=Nunito+Sans:wght@300;400;700&family=Nunito:wght@200;300;400&family=Roboto+Slab:wght@200;300;400&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" rel="stylesheet">


    <script src="https://kit.fontawesome.com/a2de648733.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/profile.css">


    <title>CLC</title>
</head>

<body>



    <!-- <ul>
  <li><a class="active" href="#home">Home Page</a></li>
  <li><a href="#news">Upload New Icon</a></li>
  <li><a href="#contact">Upload New Qr_Code</a></li>
  <li><a href="#about">About</a></li>
</ul>
<br> -->


    <!-- <div class="herp-section" style="background-image: url(" ./pictures/cs.jpg ");">
    <h1 class="hero-text">     Jack's Working Space</h1>
</div> -->


    <nav>
        <div class="logo">
            <h2><span>CL</span> Channel</h2>
        </div>

        <div class="menu">
            <ul>
                <li><a href="index">HOME</a></li>
                <li><a href="#">ABOUT</a></li>
                <?php if ($user_id == $visitor_id) : ?>
                    <li><a href="newpost">POST</a>
                    <?php endif; ?>
                    </li>
            </ul>
        </div>
    </nav>

    <header>
        <div class="banner-area">
            <div class="single-banner" style="background-image: url(assets/images/slide1.jpg)">
                <div style="height:100px;"></div>
                <form id="profile-img" name="profile-img"><input type="file" id="change-img" name="change-img" style="display:none" /></form>
                <div id="change-img-btn" class="profile-img" style='background-image: url("assets/images/user-profile/<?php echo $user['profile_image']; ?>")'></div>
                <div class="banner-text">
                    <h2><?php echo $username; ?></h2>
                </div>
                <?php if ($user['id'] != $visitor_id) : ?>
                    <button type="submit" name="follow" id="follow-btn">Subscribe</button>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="page-wrapper">

        <div class="main-content">
            <div class="post-content">
                <div class="post-area">
                    <div class="button-wrapper">
                        <div class="contentSwap-container" id="contentSwap-container">
                            <button id="post-btn">Tutorials</button>
                            <button id="rec-btn">My Projects</button>
                        </div>
                    </div>
                    <div id="tut-posts">
                        <h2 class="recent-post-title">My Posts</h2>
                        <div class="search">
                            <input type="text" class="search-term" name="searchbox" id="searchbox" placeholder="Search...">
                            <button type="submit" class="search-btn" name="search" id="search">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        <div class="user-posts" id="user-posts">
                            <div class="post-list" id="post-list"></div>
                            <div class="page-number" id="page-number"></div>
                        </div>
                    </div>
                    <div id="rec-posts" style="display: none;">
                        <div class="user-posts" id="rec-user-posts">
                            <div class="post-list rec-post-list" id="rec-post-list">

                            </div>
                            <div class="page-number" id="rec-page-number"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="sidebar">
                <div class="QR-code">
                    <div class="donate-QRcode" style="background-image: url(assets/images/user-QRcode/Barry.jpg)" alt=""></div>
                    <div class="donate-sign">Tipping via PayMe</div>
                </div>
            </div>-->
        </div>
    </div>


</body>






<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $(".detailed").on('click', function() {
            this.style.display = "none";
        });
        $(".rec-post .overlay").on('click', function() {
            console.log("abstract clicked");
            console.log(document.getElementById("detailed"));
            document.getElementById("detailed").style.display = "block";
        });
        const buttons = [
            document.getElementById("post-btn"),
            document.getElementById("rec-btn")
        ];
        const contents = [
            document.getElementById("tut-posts"),
            document.getElementById("rec-posts")
        ]
        curContentIndex = 0;
        buttons[0].classList.add('active');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                buttonIndex = buttons.indexOf(button);
                if (buttonIndex != curContentIndex) {
                    content = contents[buttonIndex];
                    content.style.display = "block";
                    contents[curContentIndex].style.display = "none";
                    buttons[curContentIndex].classList.remove('active');
                    button.classList.add('active');
                    curContentIndex = buttonIndex;
                }
            });
        });

        let postPageSettings = {
            curPage: 1,
            totalPages: 0,
            recordPerPage: 4,
            pageContainerId: "#post-list",
            api: "posts",
            queryAttachments: " AND user_id=<?php echo $user_id; ?>",
            processFunction: function(data) {
                return makeTutPosts(data);
            }
        };
        let recPageSettings = {
            curPage: 1,
            totalPages: 0,
            recordPerPage: 10,
            pageContainerId: "#rec-post-list",
            api: "recruit",
            queryAttachments: `WHERE (poster_id=<?php echo $user_id; ?>) OR (id IN 
            (SELECT recruiments.id FROM applications, jobs, recruiments WHERE applications.user_id=48 AND applications.job_id=jobs.id AND jobs.recruiment_id=recruiments.id))`,
            processFunction: function(data) {
                return makeRecPosts(data);
            }
        }
        console.log(<?php echo $user_id; ?>);
        //Load all posts
        loadData(1, postPageSettings);
        waitForElementSettled('post-list', function() {
            setPaginationButton(document.getElementById('page-number'), postPageSettings);
        })
        loadProjects(1, recPageSettings);
        //Search function
        document.getElementById("search").addEventListener('click', function() {

            postPageSettings.queryAttachments = " AND user_id=<?php echo $user_id; ?>";
            if (document.getElementById("searchbox").value != '') {
                postPageSettings.queryAttachments += " AND";
                keywords = String(document.getElementById("searchbox").value).trim().split(" ");
                var i = keywords.length;
                keywords.forEach(keyword => {
                    postPageSettings.queryAttachments += " (SELECT username FROM users where users.id=posts.user_id) LIKE '%" + keyword + "%' OR posts.postTitle LIKE '%" + keyword + "%'";
                    i--;
                    if (i > 0) {
                        postPageSettings.queryAttachments += " OR";
                    }
                });
            }
            loadData(1, postPageSettings);
            waitForElementSettled('post-list', function() {
                setPaginationButton(document.getElementById('page-number'), postPageSettings);
            })
        });

        function loadProjects(page, pageSettings) {
            $.ajax({
                url: `api/${pageSettings.api}`,
                method: "GET",
                processData: false,
                data: $.param({
                    queryAttachments: pageSettings.queryAttachments
                }),
                success: function(data) {
                    console.log(data);
                    var rdata = JSON.parse(data);
                    pageSettings.totalPages = rdata.pagesCount;
                    $(pageSettings.pageContainerId).html(pageSettings.processFunction(rdata.posts));
                },
                error: function(err) {
                    console.log(err.responseText);
                }
            });
        }

        function loadData(page, pageSettings) {
            $.ajax({
                url: `api/${pageSettings.api}`,
                method: "GET",
                processData: false,
                data: $.param({
                    srcType: 'TUT',
                    page: page,
                    recordPerPage: pageSettings.recordPerPage,
                    queryAttachments: pageSettings.queryAttachments
                }),
                success: function(data) {
                    var rdata = JSON.parse(data);
                    pageSettings.totalPages = rdata.pagesCount;
                    $(pageSettings.pageContainerId).html(pageSettings.processFunction(rdata.posts));
                    $(pageSettings.pageContainerId).attr("data-settled", "yes");
                    $(pageSettings.pageContainerId + ' .like[data-id]').click(function(e) {
                        if (<?php echo $visitor_id; ?> != 0) {
                            var buttonId = $(this).attr('data-id');
                            $.ajax({
                                type: "POST",
                                url: "api/like?postid=" + buttonId + "&visitorid=<?php echo $visitor_id; ?>",
                                processData: false,
                                contentType: "application/json",
                                data: '',
                                success: function(resp) {
                                    var res = JSON.parse(resp);
                                    $(pageSettings.pageContainerId + " .like[data-id='" + buttonId + "']").html("<i class=\"fa fa-heart\" aria-hidden=\"true\"></i> " + res.likes + " Likes");
                                    $(pageSettings.pageContainerId + " .like[data-id='" + buttonId + "']").toggleClass("liked") //.css("color", res.liked == 1 ? "rgba(216, 114, 67)" : "rgba(55, 55, 55)");
                                }
                            });
                        }
                    });
                    $(pageSettings.pageContainerId + ' a[data-id]').click(function(e) {
                        var buttonId = $(this).attr('data-id');
                        $.ajax({
                            type: "POST",
                            url: "api/view?postid=" + buttonId,
                            processData: false,
                            contentType: "application/json",
                            data: '',
                            success: function(resp) {
                                var res = JSON.parse(resp);
                                $(pageSettings.pageContainerId + " .view[data-id='" + buttonId + "']").html("<i class=\"fas fa-eye\"></i> " + res.viewed + " Viewed");
                            }
                        });
                    });
                },
                error: function(r) {
                    $(pageSettings.pageContainerId).html("<p>Oops! Cannot load posts</p>");
                    console.log(r.responseText);
                }
            })
        }

        function waitForElementSettled(waiteeId, operation) {
            var observer = new MutationObserver(function(mutations, me) {
                var waitee = document.getElementById(waiteeId);
                if (waitee.getAttribute('data-settled') == "yes") {
                    operation();
                    me.disconnect();
                    return;
                }
            });
            observer.observe(document, {
                childList: true,
                subtree: true
            });
        }

        function setPaginationButton(pageNumWrapper, pageSettings) {

            while (pageNumWrapper.lastChild) {
                pageNumWrapper.removeChild(pageNumWrapper.lastChild);
            }
            if (pageSettings.totalPages <= 1)
                return;

            for (i = 1; i <= pageSettings.totalPages; i++) {
                let button = document.createElement('button');
                button.innerText = i;
                if (pageSettings.curPage === i)
                    button.classList.add('active');
                let page = i;
                button.addEventListener('click', function() {
                    pageSettings.curpage = page;
                    let curBtn = pageNumWrapper.querySelector('button.active');
                    curBtn.classList.remove('active');
                    button.classList.add('active');
                    $(pageSettings.pageContainerId).attr("data-settled", "no");
                    loadData(page, pageSettings);
                });
                pageNumWrapper.appendChild(button);
            }
        }

        function makeTutPosts(dataSet) {
            postsInHtml = "";
            for (var indexes in dataSet) {
                if (Object.prototype.hasOwnProperty.call(dataSet, indexes)) {
                    postData = dataSet[indexes];
                    postsInHtml +=
                        "<div class=\"post\"><div class=\"donate\" onclick=\"document.getElementById('overlay').style.display = 'block';\" style=\"background-image: url(assets/images/user-QRcode/Barry.jpg);\"></div><div class=\"img-like\"><div class=\"coverimg\" style=\"background-image: url(assets/images/post-cover/" + postData.cover_image +
                        ");\"></div><a target=”_blank” " + "data-id=\"" + postData.postId + "\"href=\"" + postData.url + "\"><div class=\"overlay\"><div class=\"text\">Access</div></div></a></div><div class=\"post-preview-wrapper\"><div class=\"post-preview\"><a target=”_blank” " +
                        "data-id=\"" + postData.postId + "\" href=\"" + postData.url + "\"><div class=\"post-title\"><h3>" + postData.postTitle + "</h3></div></a><div class=\"preview-text\"><p>" + postData.description +
                        "</p></div><div class=\"post-info\"><div class=\"post-data\"><ul><li class=\"view\" data-id=\"" + postData.postId + "\"><i class=\"fas fa-eye\"></i> " + postData.viewed + " Viewed</li><li>&nbsp|&nbsp</li><li class=\"like" +
                        (postData.liked ? " liked" : "") + "\" data-id=\"" + postData.postId + "\"><i class=\"fa fa-heart\" aria-hidden=\"true\"></i> " + postData.likes + " Likes</li></ul></div><div class=\"post-date-container\"><h4 class=\"post-date\">posted on " +
                        postData.createdAt + " by </h4></div><a target=”_blank” href=\"profile.php?username=" + postData.authorName + "\"><div class=\"post-author-container\"><h4 class=\"author-username\">" +
                        postData.authorName + "</h4><div class=\"author-profileimg\" style=\"background-image:url(assets/images/user-profile/" + postData.authorImg + ");\"></div></div></a></div></div></div></div>";
                }
            }
            return postsInHtml;
        }

        function makeRecPosts(dataSet) {
            postsInHtml = "";
            for (var indexes in dataSet) {
                if (Object.prototype.hasOwnProperty.call(dataSet, indexes)) {
                    postData = dataSet[indexes];
                    postsInHtml +=
                        `
                    <div class="rec-post">
                                    <div class="abstract" data-id=${postData.id}>
                                        <div class="content">
                                            <div class="title">
                                                <h4>${postData.projecttitle}</h4>
                                            </div>
                                            <div class="info">
                                                <div class="info-item user">
                                                    <div class="profileimg" style="background-image:url(assets/images/user-profile/${postData.posterimg});"></div>
                                                    <h5 class="username">${postData.postername}</h5>
                                                </div>
                                                <div class="info-item date">
                                                    <h5>Posted on ${postData.createdAt}</h5>
                                                </div>
                                                <div class="info-item progress">
                                                    <h5><span class="aval">${postData.jobsum-postData.jobcap}</span>/${postData.jobsum} confirmed</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="project?projectid=${postData.id}" target="”_blank”" data-id="${postData.id}">
                                        <div class="overlay">
                                            <div class="text">View Detail</div>
                                        </div>
                                    </a>
                                </div>
                    `;
                }
            }
            return postsInHtml;
        }

        $("#change-img-btn").click(function() {
            $('#change-img').trigger('click');      
        });
        $("#change-img").change(function(e){
            var formData;
            var fileData;
            var fileExtension = "png";
            if ($('#change-img').prop('files')[0] != undefined) {
                fileData = $('#change-img').prop('files')[0];
                fileExtension = fileData.name.split('.').pop().toLowerCase();
                if (jQuery.inArray(fileExtension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    alert("Unsupported Profile Image File!");
                } else { //TODO: image resizer and resolution control
                    formData = new FormData();
                    formData.append("profile_image", fileData);
                    formData.append("userid", <?php echo $user_id; ?>);
                    $.ajax({
                        url: "api/image",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(r) {
                            location.reload();
                        },
                        error: function(r) {
                            alert("Upload Failed!");
                            console.log(r.responseText);
                        }
                    });
                }
            }
        });
    });
</script>

</html>