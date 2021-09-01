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
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tammudu+2:wght@400;500&family=Nunito+Sans:wght@300;400;700&family=Nunito:wght@200;300;400&family=Roboto+Slab:wght@200;300;400&display=swap" rel="stylesheet">


    <script src="https://kit.fontawesome.com/a2de648733.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="assets/css/Pcentre.css">

    <title>CLC</title>
</head>

<body class="preload">
    <nav>
        <div class="logo">
            <h2><span>CL</span> Channel</h2>
        </div>
        <div class="menu">
            <ul>
                <li><a target=”_blank” href="#">HOME</a></li>
                <li><a target=”_blank” href="#">ABOUT</a></li>
                <?php if ($visitor_id != 0) : ?>
                    <li><a target=”_blank” href="new_recruit">POST</a></li>
                    <li><a target=”_blank” href="profile?username=<?php echo $user['username']; ?>"><?php echo $user['username']; ?></a></li>
                <?php else : ?>
                    <li><a target=”_blank” href="create-account">SIGNUP</a></li>
                    <li><a target=”_blank” href="login">LOGIN</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="M-CONT banner-area">
            <div class="banner-text">
                <h3>Welcome to CL Channel's</h3>
                <h2> project center </h2>
            </div>
        </div>
        <div class="content-area">
            <div class="sidebar sidebar-l">
                <div class="sidebar-content sidebar-l1"><-LOOKING FOR ADs-></div>
                <div class="sidebar-content sidebar-l2">
                    <div class="recommend-list">
                        <div class="title">
                            <h3>Recommended</h3>
                        </div>
                        <ul id="recomend-list">
                            <li><a>
                                    <div class="name">Computer Learning Channel Project I</div>
                                    <div class="hot"></div>
                                </a></li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="main-content">
                <div class="M-CONT search-box"></div>
                <div class="M-CONT post-list" id="post-list">
                </div>
                <div class="pagination"></div>
            </div>
            <div class="sidebar sidebar-r">
                <div class="sidebar-content sidebar-r1">
                    <div class="recomment-list">
                        <div>
                            <div class="title">
                                <h4>Programming Language</h4>
                            </div>
                            <form>
                                <ul>
                                    <li>
                                        <input type="checkbox" id="c" name="c" value="C">
                                        <label for="c">C</label><br>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cpp" name="cpp" value="Cpp">
                                        <label for="cpp">C++</label><br>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="csharp" name="csharp" value="C#">
                                        <label for="csharp">C#</label><br>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="go" name="go" value="GO">
                                        <label for="go">GO</label><br>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="java" name="java" value="Java">
                                        <label for="java">Java</label><br>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="javascript" name="javascript" value="JavaScript">
                                        <label for="javascript">JavaScript</label><br>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="php" name="php" value="PHP">
                                        <label for="php">PHP</label><br>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="python" name="python" value="Python">
                                        <label for="">Python</label><br>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="r" name="r" value="R">
                                        <label for="r">R</label><br>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="swift" name="swift" value="Swift">
                                        <label for="swift">Swift</label><br>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="sidebar-content sidebar-r2"></div>
            </div>
        </div>
    </div>
    </body>

    <?php include("app/includes/footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            let recruitPageSettings = {
                curPage: 1,
                totalPages: 0,
                recordPerPage: 10,
                pageContainerId: "#post-list",
                queryAttachMent: "",
                processFunction: function(data) {
                    return makeRecPosts(data);
                }
            };
            loadData(1, recruitPageSettings);
            waitForElementSettled('post-list', function() {
                //setPaginationButton(document.getElementById('oerpage-number'), oerPostPageSettings);
            })

            function loadData(page, pageSettings) {
                $.ajax({
                    url: "api/recruit",
                    method: "GET",
                    processData: false,
                    data: $.param({
                        /*srcType: pageSettings.srcType,
                        page: page,
                        recordPerPage: pageSettings.recordPerPage,
                        queryAttachments: pageSettings.queryAttachments*/
                    }),
                    success: function(data) {
                        var rdata = JSON.parse(data);
                        //pageSettings.totalPages = rdata.pagesCount;
                        $(pageSettings.pageContainerId).html(pageSettings.processFunction(rdata.posts));
                        $(".hover-button i").click(function() {
                            $(this).toggleClass("active");
                            dataid = $(this).attr('data-id');
                            $(".detailed[data-id=" + dataid + "]").toggleClass("active");
                        })
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


            function makeRecPosts(dataSet) {
                postsInHtml = "";
                for (var indexes in dataSet) {
                    if (Object.prototype.hasOwnProperty.call(dataSet, indexes)) {
                        postData = dataSet[indexes];
                        postsInHtml +=
                            ` 
                    <div class="post">
                        <div class="abstract" data-id=${postData.id}>
                            <div class="content">
                                <a href="project?projectid=${postData.id}" target="”_blank”" data-id="${postData.id}"><div class="title">
                                    <h4>${postData.projecttitle}</h4>
                                </div></a>
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
                            <div class="hover-button"><i data-id=${postData.id} class="fas fas fa-angle-down"></i></div>
                        </div>
                        <div class="detailed" data-id=${postData.id}>
                            <h3 class="title">${postData.projecttitle}</h3>
                            <h4 class="lowtitle">Introduction</h4>
                            <div class="Introduction">
                                <p>${postData.projectintro}</p>
                            </div>
                            <h4 class="lowtitle">Requirements</h4>
                            <div class="requirements">
                                <p>We require programming prerequisites including <span>${postData.progreq.split(',').join('</span>,<span>')}</span></p>
                                <p>Also, We require technical prerequisites including <span>${postData.techreq.split(',').join('</span>,<span>')}</span></p>
                            </div>
                            <h4 class="lowtitle">Additional Requirements</h4>
                            <div class="addtional-requirements">
                                <p>${postData.addreq}</p>
                            </div>
                        </div>
                    </div>`
                    }
                }
                return postsInHtml;
            }

        });
    </script>



</html>