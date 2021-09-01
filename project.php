<?php
include("app/classes/DB.php");
include('app/classes/Login.php');
$visitor_id = Login::isLoggedIn();
if ($visitor_id != 0) {
    $visitor = DB::select(['*'], ['users'], ['id' => $visitor_id])[0];
}
$isFollowing = false;
if (isset($_GET['projectid'])) {
    if (DB::query('SELECT id FROM recruiments WHERE id=:id', array(':id' => $_GET['projectid']))) {
        $proj = DB::query('SELECT * FROM recruiments WHERE id=:id', array(':id' => $_GET['projectid']))[0];
        $user_id = $proj['poster_id'];
        $user = DB::query('SELECT * FROM users WHERE id=:id', array(':id' => $user_id))[0];
        $visitor_id = Login::isLoggedIn();
        $followers = sizeof(DB::query("SELECT id FROM followers WHERE user_id=$user_id"));
        $tutorials = sizeof(DB::query("SELECT id FROM posts WHERE user_id=$user_id"));
        $projects = sizeof(DB::query("SELECT id FROM recruiments WHERE poster_id=$user_id"));

        if (DB::query("SELECT id FROM followers WHERE user_id=$user_id AND follower_id=$visitor_id")) {
            //already following
            $isFollowing = True;
        }
    }
} else {
    die('404 Project Not Found');
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


    <link rel="stylesheet" href="assets/css/project.css">
    <link rel="stylesheet" href="assets/css/nav.css">
    <title>CLC</title>
</head>

<body class="preload">
    <nav>
        <div class="logo">
            <h2><span>CL</span> Channel</h2>
        </div>
        <div class="menu">
            <ul>
                <li><a target=”_blank” href="index">HOME</a></li>
                <li><a target=”_blank” href="#">ABOUT</a></li>
                <?php if ($visitor_id != 0) : ?>
                    <li><a target=”_blank” href="new_recruit">POST</a></li>
                    <li><a target=”_blank” href="profile?username=<?php echo $visitor['username']; ?>"><?php echo $visitor['username']; ?></a></li>
                <?php else : ?>
                    <li><a target=”_blank” href="create-account">SIGNUP</a></li>
                    <li><a target=”_blank” href="login">LOGIN</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container">

        <div class="content-area">
            <div class="sidebar sidebar-l">
                <div class="sidebar-content sidebar-l1">
                    <div class="profileimg" style="background-image:url(assets/images/user-profile/<?php echo $user['profile_image']; ?>);"></div>
                    <h4 class="username"><?php echo $user['username']; ?></h4>
                    <div class="followers"><span><i class="fas fa-users"></i> <?php echo $followers; ?></span> &nbsp <span><i class="fas fa-book-open"></i> <?php echo $tutorials; ?> </span> &nbsp <span><i class="fas fa-people-carry"></i> <?php echo $projects; ?> </span></div>
                    <?php if ($user_id != $visitor_id) : ?><button id="follow-btn"><span id="button-text" class="button-text"><?php if (!$isFollowing) : ?>Follow</span><span class="button-icon"><i class="fas fa-plus"></i>
                                <?php else : ?>Followed</span><span class="button-icon"><i class="fas fa-user-check"></i> </span></button>
                    <?php endif; ?> <?php endif; ?>
                </div>
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
                <div class="detailed">
                    <h3 class="title"><?php echo $proj['project_title']; ?></h3>
                    <div class="statistics">
                        <h5 class="postdate"><i class="far fa-clock"></i> <?php echo date("d/m/Y", strtotime($proj['created_at'])); ?> </h5>
                        <h5><i class="fas fa-eye"></i> <?php echo $proj['views']; ?></h5>
                    </div>
                    <h4 class="lowtitle">Introduction</h4>
                    <div class="Introduction info-item">
                        <p><?php echo $proj['project_intro']; ?></p>
                    </div>
                    <h4 class="lowtitle">Requirements</h4>
                    <div class="requirements info-item">
                        <p>We require programming prerequisites including <b><i><span> <?php echo implode('</span>,<span>', explode(',', $proj['programming_req'])); ?></span></i></b></p>
                        <p>Also, We require technical prerequisites including
                            <b><i><span> <?php echo implode('</span>,<span>', explode(',', $proj['technical_req'])); ?></span></i></b>
                        </p>
                    </div>
                    <h4 class="lowtitle">Additional Requirements</h4>
                    <div class="addtional-requirements info-item">
                        <p><?php echo $proj['additional_req']; ?></p>
                    </div>
                    <h4 class="lowtitle">Job Arrangements</h4>
                    <div class="jobs info-item">
                        <ul class="job-list">
                            <?php $jobs = DB::select(["*"], ["jobs"], ["recruiment_id" => $proj['id']]);
                            foreach ($jobs as $job) : ?>
                                <li class="job">
                                    <div class="job-title"><?php echo $job['job_title']; ?></div>
                                    <?php $candidates = DB::select(["*"], ["applications"], ["job_id" => $job['id'], "status" => '"PROGRESS"']); ?>
                                    <?php $members = DB::select(["*"], ["applications"], ["job_id" => $job['id'], "status" => '"APPROVED"']); ?>
                                    <div class="job-cap"><span class="<?php echo ($job['job_sum'] - $job['job_cap']) >= 0 ? 'aval' : 'full'; ?>"><?php echo ($job['job_sum'] - $job['job_cap']); ?></span>/<?php echo $job['job_sum']; ?> comfirmed, <?php echo sizeof($candidates); ?> candidates</div>
                                    
                                    <?php if ($user_id == $visitor_id || DB::select(["*"], ["applications"], ["user_id" => $visitor_id, "job_id" => $job['id'], "status" => '"APPROVED"'])) : ?>
                                        <h3>Members</h3>
                                        <?php if (sizeof($members) == 0) : ?>
                                        <?php echo "<p>Vacant Seats for ya.</p>";
                                        else : ?>
                                            <ul class="candidates">
                                                <?php foreach ($members as $member) : ?>
                                                    <?php $cdt = DB::select(["*"], ["users"], ["id" => $member['user_id']])[0]; ?>
                                                    <li class="info-item user" style="border-right: 2px solid greenyellow !important;" data-id="<?php echo $member["id"]; ?>">
                                                    <a target=”_blank” href="profile?username=<?php echo $cdt['username'];?>"><div class="profileimg" style="background-image:url(assets/images/user-profile/<?php echo $cdt['profile_image']; ?>});"></div>
                                                        <h5 class="username"><?php echo $cdt['username']; ?></h5></a>
                                                        <?php if ($user_id == $visitor_id) : ?>
                                                            <i data-id="<?php echo $member["id"]; ?>" class="reject fas fa-times" style="color:rgb(189, 48, 43);">OUT</i>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                        <?php else: ?><button type="button" name="submit-btn" class="submit-btn" id="submit-btn" data-id="<?php echo $job['id']; ?>}">Apply</button>
                                    <?php endif; ?>
                                    <?php if ($user_id == $visitor_id) : ?>
                                        <h3>Candidates</h3>
                                        <?php if (sizeof($candidates) == 0) : ?>
                                        <?php echo "<p>There's no applicants yet.</p>";
                                        else : ?>
                                            <ul class="candidates">
                                                <?php foreach ($candidates as $candidate) : ?>
                                                    <?php $cdt = DB::select(["*"], ["users"], ["id" => $candidate['user_id']])[0]; ?>
                                                    <li class="info-item user" data-id="<?php echo $candidate["id"]; ?>">
                                                        <a target=”_blank” href="profile?username=<?php echo $cdt['username'];?>">
                                                        <div class="profileimg" style="background-image:url(assets/images/user-profile/<?php echo $cdt['profile_image']; ?>});"></div>
                                                        <h5 class="username"><?php echo $cdt['username']; ?></h5></a>
                                                        <i data-id="<?php echo $candidate["id"]; ?>" class="approve fas fa-check" style="color:rgb(63, 216, 43)"></i>
                                                        <i data-id="<?php echo $candidate["id"]; ?>" class="reject fas fa-times" style="color:rgb(189, 48, 43);font-size:1.2rem"></i>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <h4 class="lowtitle">
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="sidebar sidebar-r">
                <div class="sidebar-content sidebar-r1">
                    <div class="recomment-list">
                        <div>
                            <div class="title">
                                <h4></h4>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="sidebar-content sidebar-r2"></div>
            </div>
        </div>
    </div>


    <?php include("app/includes/footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.submit-btn[data-id]').click(function(e) {
                if (<?php echo $visitor_id; ?> == 0) {
                    window.location.replace("login.php");
                    return;
                }

                var buttonId = $(this).attr('data-id');
                $.ajax({
                    url: "api/apply",
                    method: 'POST',
                    processData: false,
                    contentType: "application/json",
                    data: '{ "userid": "' + <?php echo $visitor_id; ?> + '", "jobid": "' + buttonId + '" }',
                    success: function(r) {
                        alert("Applied! Please wait for the organizer's consideration.");
                    },
                    error: function(r) {
                        alert("Attempt Failed! " + r.responseText);
                        console.log(r);
                    }
                });


            });
            $("#follow-btn").click(e => {
                if (<?php echo $visitor_id; ?> == 0) {
                    window.location.replace("login.php");
                    return;
                }
                $.ajax({
                    url: "api/follow",
                    method: 'POST',
                    processData: false,
                    contentType: "application/json",
                    data: '{ "visitorid": "' + <?php echo $visitor_id; ?> + '", "userid": "' + <?php echo $user['id']; ?> + '" }',
                    success: function(r) {
                        res = JSON.parse(r);
                        $("#button-text").text(res.isFollowing == 1 ? 'Followed ' : 'Follow ');
                        $(".button-icon").html(`<i class="fas fa-${res.isFollowing == 1 ? 'user-check': 'plus'}"></i>`);
                    },
                    error: function(r) {
                        console.log(r);
                    }
                });
            });
            $(".approve[data-id]").on('click', e => {
                employmentid = $(e.target).attr("data-id");
                $.ajax({
                    url: "api/job",
                    method: 'POST',
                    processData: false,
                    contentType: "application/json",
                    data: '{ "id": "' + employmentid + '"}',
                    success: function(r) {
                        $(`.user[data-id=${employmentid}]`).fadeOut(700);
                    },
                    error: function(r) {
                        console.log(r.responseText);
                        alert("Error! Approvement failed.");
                    }
                });
            });
            $(".reject").click(e => {
                employmentid = $(e.target).attr("data-id");
                $.ajax({
                    url: "api/job",
                    method: 'DELETE',
                    processData: false,
                    contentType: "application/json",
                    data: '{ "id": "' + employmentid + '"}',
                    success: function(r) {
                        $(`.user[data-id=${employmentid}]`).fadeOut(700);
                    },
                    error: function(r) {
                        alert("Error! Rejection failed");
                        console.log(r.responseText);
                    }
                });
            });
        });
    </script>

</body>

</html>