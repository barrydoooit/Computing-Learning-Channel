<?php
include($_SERVER['DOCUMENT_ROOT'] . "/EvolvedChannel/app/classes/DB.php");
include($_SERVER['DOCUMENT_ROOT'] . "/EvolvedChannel/app/classes/Login.php");

$output = '';
$recordPerPage=$_POST['recordPerPage'];
$table = $_POST['table'];
$page = $_POST['page'];
$formAction = $_POST['formAction'];
$query = $_POST['query'];
/*$recordPerPage=3;
$table = 'posts';
$page = 1;
$formAction = "index.php?";*/
$visitor_id = Login::isLoggedIn();
if($visitor_id){
    $visitorName= DB::query("SELECT username FROM users WHERE id=$visitor_id")[0]['username'];
    $formAction .= "username=$visitorName&";
}else{
    $formAction = "login.php?";
}
$startFrom = ($page-1)*$recordPerPage;
$query .= " ORDER BY id DESC LIMIT " . $startFrom . "," . $recordPerPage;
$result = DB::query($query);

$user = array();
for($i=0;$i<count($result);$i++){ 
    $post = $result[$i]; 
    $user_id= $post['user_id'];
    $query = "SELECT * FROM users WHERE id=$user_id";
    $user = DB::query($query)[0];
    $alreadyLiked = false;
    if(DB::select(['post_id'], ['post_likes'], ['post_id' => $post['id'], 'user_id' => $visitor_id])){
        $alreadyLiked = true;
    }
    
    $output .=
                    '<div class="post">
                    <div class="img-like">
                        <div class="coverimg" style="background-image: url(assets/images/post-cover/' . $post['cover_image'] . ');"></div>
                        <a href="' . $post['url'] . '"><div class="overlay">
                            <div class="text">Access</div>
                        </div></a>
                    </div>

                    
                        <div class="post-preview-wrapper">
                            <div class="post-preview">
                                <a href="' . $post['url'] . '"><div class="post-title"><h3>' . $post['postTitle'] . '</h3></div></a> 
                                <div class="preview-text">
                                    <p>' . (strlen($post['description'])>=255?substr($post['description'],0,255)."...":$post['description']) . '</p>
                                </div>
                                <div class="post-info"> 
                                    <button name="likes" data-id="' . $post['id'] . '" class="likes" id="likes"><h4 style="color:rgb(' . ($alreadyLiked ? '216, 114, 67' : '55, 55, 55') . ');">' . $post['likes'] . ' Likes </h4></button><div class="post-date-container">
                                        <h4 class="post-date">posted on ' .  date("d/m/Y", strtotime($post['created_at'])) . ' by </h4>
                                    </div><a href="profile.php?username=' . $user['username'] . '"><div class="post-author-container">
                                        <h4 class="author-username">' . $user['username'] . '</h4> 
                                        <div class="author-profileimg" style="background-image:url(assets/images/user-profile/' . $user['profile_image'] . ');"></div>
                                    </div></a>
                                </div>
                            </div>
                        </div>
                   
                </div>';
}
$recordsCount = count(DB::query($query));
$pagesCount = ceil($recordsCount/$recordPerPage);

die(json_encode(array(
    'posts' => $output,
    'pagesCount' => $pagesCount
)));
