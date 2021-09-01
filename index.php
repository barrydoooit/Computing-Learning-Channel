<?php
include("app/classes/DB.php");
include('app/classes/Login.php');
$visitor_id = Login::isLoggedIn();
if ($visitor_id != 0) {
    $user = DB::select(['*'], ['users'], ['id' => $visitor_id])[0];
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


    <script src="https://kit.fontawesome.com/a2de648733.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="assets/css/style.css">



    <title>CLC</title>
</head>

<body class="preload">

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
                <li><a target=”_blank” href="index">HOME</a></li>

        <li><a target=”_blank” href="Pcentre">PROJECTS</a></li>
                <li><a target=”_blank” href="about">ABOUT</a></li>
                <?php if ($visitor_id != 0) : ?>
                    <li><a target=”_blank” href="newpost">POST</a></li>
                    <li><a target=”_blank” href="profile?username=<?php echo $user['username']; ?>"><?php echo $user['username']; ?></a></li>
                    <li><a href="logout">LOGOUT</a></li>
                <?php else : ?>
                    <li><a target=”_blank” href="create-account">SIGNUP</a></li>
                    <li><a target=”_blank” href="login">LOGIN</a></li>
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
    <!-- Page wrapper-->
    <div class="page-wrapper">
        <div class="slideshow">
            <!--<section id="slideshow">
                <div class="slick">
                    <div><img src="assets/images/slide-image-1.png" alt=""></div>
                    <div><a target=”_blank” href="https://www.webfx.com/blog/web-design/books-learning-web-design/"><img src="assets/images/slide-image-2.png" alt=""></a></div>
                </div>
            </section> -->
        </div>

        <div class="button-wrapper">
            <div class="contentSwap-container" id="contentSwap-container">
                <button id="oer-btn">Open Education Resources</button>
                <button id="sdt-btn">Student Developed Tutorials</button>
                <button id="ssr-btn">Subscriptions</button>
            </div>
        </div>


        <div class="content clearfix">
            <div class="main-content">
                <div id="oer-content">
                    <h2 class="recent-post-title">Open Education Resources</h2>
                    <div class="wrapper-grid" id="oerpost-list"></div>
                    <div class="page-number" id="oerpage-number"></div>
                </div>

                <div id="sdt-content" style="display: none;">
                    <h2 class="recent-post-title">Student Developed Tutorials</h2>
                    <div class="search">
                        <input type="text" class="search-term" name="searchbox" id="searchbox" placeholder="Search...">
                        <button type="submit" class="search-btn" name="search" id="search">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="user-posts" id="user-posts">
                        <div class='wrapper' style='min-width: 1500px;'>
                            <div class="post-list" id="post-list" data-settled="no"></div>
                            <div class="sidebar">
                                <div class="section topics">
                                    <h2 class="section-title">Topics</h2>
                                    <ul id='tag-list'>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="page-number" id="page-number"></div>

                    </div>
                </div>


                <div id="ssr-content" style="display: none;">
                    <h2 class="recent-post-title">Subscriptions</h2>
                    <div class="notice" id="subscription-notice">You'are not with us. <a target=”_blank” href="create-account">Sign-up</a> or <a target=”_blank” href="login">Login</a></div>
                    <div class="user-posts" id="follower-posts">
                        <div class="post-list" id="followerpost-list"></div>
                        <div class="page-number" id="followerpost-page-number"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="overlay">
        <div class="popup">
            <div class="QR-code">
                <div class="donate-QRcode"></div>
                <div class="donate-sign">Tipping via <span></span></div>
            </div>
        </div>
    </div>
    <?php include("app/includes/footer.php"); ?>
    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- Custon Script -->

    <script src="assets/js/slide.js"></script>
    <script src="assets/js/contentSwap.js"></script>
    <script src="assets/js/like_animation.js"></script>
    <script src="assets/js/popup.js"></script>
    <script>
        $(document).ready(function() {

            let oerPostPageSettings = {
                curPage: 1,
                totalPages: 0,
                recordPerPage: 10,
                pageContainerId: "#oerpost-list",
                srcType: "OER",
                queryAttachMent: "",
                processFunction: function(data) {
                    return makeOerPosts(data);
                }
            };
            let postPageSettings = {
                curPage: 1,
                totalPages: 0,
                recordPerPage: 4,
                pageContainerId: "#post-list",
                srcType: "TUT",
                queryAttachMent: "",
                processFunction: function(data) {
                    return makeTutPosts(data);
                }
            };
            let followerPostPageSettings = {
                curPage: 1,
                totalPages: 0,
                recordPerPage: 4,
                pageContainerId: "#followerpost-list",
                srcType: "TUT",
                queryAttachMent: "",
                processFunction: function(data) {
                    return makeTutPosts(data);
                }
            };
            loadData(1, oerPostPageSettings);
            waitForElementSettled('oerpost-list', function() {
                setPaginationButton(document.getElementById('oerpage-number'), oerPostPageSettings);
            })
            //Load all posts
            loadData(1, postPageSettings);
            waitForElementSettled('post-list', function() {
                setPaginationButton(document.getElementById('page-number'), postPageSettings);
            })

            //Search function
            document.getElementById("search").addEventListener('click', function() {
                postPageSettings.queryAttachments = "";
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

            if ((visitorId = <?php echo $visitor_id; ?>) != 0) {
                document.getElementById("subscription-notice").style.display = "none";
                followerPostPageSettings.queryAttachments = " AND user_id=(SELECT user_id FROM followers WHERE follower_id=" + visitorId + ")";
                loadData(1, followerPostPageSettings);
                waitForElementSettled('post-list', function() {
                    setPaginationButton(document.getElementById('followerpost-page-number'), followerPostPageSettings);
                })
            }

            function loadData(page, pageSettings) {
                $.ajax({
                    url: "api/posts",
                    method: "GET",
                    processData: false,
                    data: $.param({
                        srcType: pageSettings.srcType,
                        page: page,
                        recordPerPage: pageSettings.recordPerPage,
                        queryAttachments: pageSettings.queryAttachments
                    }),
                    success: function(data) {
console.log(data);
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
                        $(pageSettings.pageContainerId + ' .donate').click(function(e){
                            //onclick=\"document.getElementById('overlay').style.display = 'block';\"
                            overlay=document.getElementById('overlay');
                            console.log($(this).attr('data-tipmethod'));
                            if($(this).attr('data-tipmethod')=='LOVE'){
                                $('#overlay .donate-QRcode').css('background-image', 'url(assets/images/heart.png)');
                                $('#overlay .donate-sign span').html('LOVE');
                            }else{
                                $('#overlay .donate-QRcode').css('background-image', 'url(assets/images/user-QRcode/'+$(this).attr('data-id')+'.png');
                                $('#overlay .donate-sign span').html($(this).attr('data-tipmethod'));
                            }
                            overlay.style.display = 'block';
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

                if (pageSettings.totalPages <= 1)
                    return;
                while (pageNumWrapper.lastChild) {
                    pageNumWrapper.removeChild(pageNumWrapper.lastChild);
                }
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
                        for (i = 0; i < 3; i++) {
                            if (postData.tags[i] && postData.tags[i].authorized == 1)
                                postData.tags[i].tag_name += '*';
                        }
                        postsInHtml +=
                            "<div class=\"post\"><div data-id=\""+postData.authorId+"\" data-tipmethod=\""+ postData.tipMethod+"\" class=\"donate\" style=\"background-image: url(assets/images/user-QRcode/"+postData.authorId+".png);\"></div><div class=\"img-like\"><div class=\"coverimg\" style=\"background-image: url(assets/images/post-cover/" + postData.cover_image +
                            ");\"></div><a target=”_blank” " + "data-id=\"" + postData.postId + "\"href=\"" + postData.url + "\"><div class=\"overlay\"><div class=\"text\">Access</div></div></a></div><div class=\"post-preview-wrapper\"><div class=\"post-preview\"><a target=”_blank” " +
                            "data-id=\"" + postData.postId + "\" href=\"" + postData.url + "\"><div class=\"post-title\"><h3>" + postData.postTitle + "</h3></div></a><div class=\"preview-text\">" + "<div class=\"tags\">" + (postData.tags[0] ? "<span>" + postData.tags[0].tag_name + "</span>" : '') + (postData.tags[1] ? "<span>" + postData.tags[1].tag_name + "</span>" : '') + (postData.tags[2] ? "<span>" + postData.tags[2].tag_name + "</span>" : '') + "</span></div>" + "<p>" + postData.description +
                            "</p></div><div class=\"post-info\"><div class=\"post-data\"><ul><li class=\"view\" data-id=\"" + postData.postId + "\"><i class=\"fas fa-eye\"></i> " + postData.viewed + " Viewed</li><li>&nbsp|&nbsp</li><li class=\"like" +
                            (postData.liked ? " liked" : "") + "\" data-id=\"" + postData.postId + "\"><i class=\"fa fa-heart\" aria-hidden=\"true\"></i> " + postData.likes + " Likes</li></ul></div><div class=\"post-date-container\"><h4 class=\"post-date\">posted on " +
                            postData.createdAt + " by </h4></div><a target=”_blank” href=\"profile.php?username=" + postData.authorName + "\"><div class=\"post-author-container\"><h4 class=\"author-username\">" +
                            postData.authorName + "</h4><div class=\"author-profileimg\" style=\"background-image:url(assets/images/user-profile/" + postData.authorImg + ");\"></div></div></a></div></div></div></div>";
                    }
                }
                return postsInHtml;
            }

            function makeOerPosts(dataSet) {



                postsInHtml = "";
                for (var indexes in dataSet) {
                    if (Object.prototype.hasOwnProperty.call(dataSet, indexes)) {
                        postData = dataSet[indexes];
                        postsInHtml +=
                            "<div class=\"container\"><div class=\"img-banner\"><div class=\"cover-img\" style=\"background-image: url(assets/images/oer-cover/" + postData.cover_image +
                            ");\"></div><a target=”_blank” href=\"" + postData.url + "\" data-id=\"" + postData.postId + "\"><div class=\"overlay\"><div class=\"text\">Access</div></div></a></div><div class=\"author\"><div class=\"user-name\"><h4>" +
                            postData.authorName + "</h4></div><div class=\"author-profileimg\" style=\"background-image:url(assets/images/user-profile/" + postData.authorImg + ")\"></div></div><a target=”_blank” href=\"" + postData.url + "\" data-id=\"" + postData.postId + "\"><h3 class=\"post-title\">" +
                            postData.postTitle + "</h3></a><div class=\"post-info-container\"><div class=\"post-info\"><ul><li class=\"view\" data-id=\"" + postData.postId + "\"><i class=\"fas fa-eye\"></i> " + postData.viewed + " Viewed</li><li>&nbsp|&nbsp</li><li class=\"like" +
                            (postData.liked ? " liked" : "") + "\" data-id=\"" + postData.postId + "\"><i class=\"fa fa-heart\" aria-hidden=\"true\"></i> Likes " + postData.likes + "</li></ul></div></div></div>";
                    }
                }
                return postsInHtml;
            }

            function loadTagList() {
                $.ajax({
                    url: "api/tags",
                    method: "GET",
                    processData: false,
                    success: function(data) {
                        var rdata = JSON.parse(data);
                        tagList = document.getElementById("tag-list");
                        for (i = 0; i < rdata.length; i++) {
                            tagList.innerHTML += '<li data-id=' + rdata[i].id + '><a>' + rdata[i].tag_name + '</a></li>';
                        }
                        $('#tag-list li[data-id]').click(function(e) {
                            e.preventDefault();
                            var tagId = $(this).attr('data-id');
                            console.log(tagId);
                            postPageSettings.queryAttachments = " AND id IN (SELECT post_id FROM post_tags WHERE tag_id=" + tagId + ")";
                            loadData(1, postPageSettings);
                            waitForElementSettled('post-list', function() {
                                setPaginationButton(document.getElementById('page-number'), postPageSettings);
                            });
                        });
                    }
                });
            }

            loadTagList();
        });
    </script>
</body>

</html>