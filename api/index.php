<?php

use function PHPSTORM_META\type;

require_once("DB.php");

$db = new DB("mysql.comp.polyu.edu.hk", "clc", "clc", "cloterra");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    http_response_code(500);
    if ($_GET['url'] == "auth") {
        $user = $db->select(["*"], ["users"], ["id" => $_GET['user_id']])[0];
        echo json_encode($user);
    } else if ($_GET['url'] == "posts") {
        $output = '';
        $recordPerPage = $_GET['recordPerPage'];
        $srcType = $_GET['srcType'];
        $page = $_GET['page'];
        $queryAttachments = $_GET['queryAttachments'];
        if (isset($_COOKIE['SNID'])) {
            $token = $_COOKIE['SNID'];
            $visitor_id = ($selectResult = $db->select(['user_id'], ['login_tokens'], ["token" => sha1($token)])) ? $selectResult[0]['user_id'] : 0;
        } else {
            $visitor_id = 0;
        }
        $startFrom = ($page - 1) * $recordPerPage;
        $query = "SELECT * FROM posts WHERE src_type='" . $srcType . "'" . $queryAttachments . " ORDER BY id DESC";
        $recordsCount = count($db->query($query));
        if ($recordsCount > $recordPerPage) {
            $query = "SELECT * FROM posts WHERE src_type='" . $srcType . "'" . $queryAttachments . " ORDER BY id DESC LIMIT " . $startFrom . "," . $recordPerPage;
        }
        $result = $db->query($query);
        $postsInfo = array();

        for ($i = 0; $i < count($result); $i++) {
            $post = $result[$i];
            $user_id = $post['user_id'];
            $user = $db->select(["*"], ["users"], ["id" => $user_id])[0];
            $alreadyLiked = false;
            if ($visitor_id != 0 && $db->select(['post_id'], ['post_likes'], ['post_id' => $post['id'], 'user_id' => $visitor_id])) {
                $alreadyLiked = true;
            }
            $tags = $db->query("SELECT tag_name, authorized FROM tags WHERE id IN (SELECT tag_id FROM post_tags WHERE post_id=" . $post['id'] . ") ORDER BY tag_count DESC LIMIT 3");
            array_push($postsInfo, array(
                'authorId' => $post['user_id'],
                'cover_image' => $post['cover_image'],
                'url' => $post['url'],
                'postTitle' => $post['postTitle'],
                'description' => strlen($post['description']) >= 252 ? substr($post['description'], 0, 252) . "..." : $post['description'],
                'postId' => $post['id'],
                'liked' => $alreadyLiked,
                'likes' => $post['likes'],
                'tipMethod' => $user['tip_method'],
                'viewed' => $post['viewed'] >= 10000 ? "10k+" : $post['viewed'],
                'createdAt' => date("d/m/Y", strtotime($post['created_at'])),
                'authorName' => $user['username'],
                'authorImg' => $user['profile_image'],
                'tags' => $tags
            ));
        }

        $pagesCount = ceil($recordsCount / $recordPerPage);
http_response_code(200);
        echo json_encode(array(
            'posts' => $postsInfo,
            'pagesCount' => $pagesCount
        ));
        http_response_code(200);
    } else if ($_GET['url'] == 'tags') {
        $query = "SELECT id,tag_name FROM tags ORDER BY tag_count DESC LIMIT 20";
        $result = $db->query($query);
        echo json_encode($result);
        http_response_code(200);
    } else if ($_GET['url'] == 'follow') {
        http_response_code(503);
        $user = $db->select(['* '], ['users'], ['id' => $_GET['userid']])[0];
        $visitor_id = $_GET['visitorid'];
        $user_id = $_GET['userid'];
        if (!$db->select(['id'], ['followers'], ['user_id' => $user_id, 'follower_id' => $visitor_id])) {
            $isFollowing = 0;
        } else {
            $isFollowing = 1;
        }
        $followerNum = $db->select(['Count(id)'], ['followers'], ['user_id' => $user_id])[0]['Count(id)'];
        echo '{';
        echo ' "isFollowing": "' . $isFollowing . '",';
        echo ' "followerNum": "' . $followerNum . '"';
        echo '}';
        http_response_code(200);
    } else if ($_GET['url'] == "recruit") {
        if (isset($_COOKIE['SNID'])) {
            $token = $_COOKIE['SNID'];
            $visitor_id = ($selectResult = $db->select(['user_id'], ['login_tokens'], ["token" => sha1($token)])) ? $selectResult[0]['user_id'] : 0;
        } else {
            $visitor_id = 0;
        }
        
        $query = "SELECT * FROM recruiments "; 
        if (!empty($_GET['queryAttachments'])){
            $query .= $_GET['queryAttachments'];
        }
        $result = $db->query($query);
        $postsInfo = array();
        
        for ($i = 0; $i < count($result); $i++) {
            $post = $result[$i];
            $user_id = $post['poster_id'];
            $user = $db->select(["*"], ["users"], ["id" => $user_id])[0];
            /*if ($visitor_id != 0 && $db->select(['post_id'], ['post_likes'], ['post_id' => $post['id'], 'user_id' => $visitor_id])) {
                $alreadyLiked = true;
            }*/
            
            $jobs = $db->select(["*"], ["jobs"], ["recruiment_id" => $post['id']]);
            $joblist = array();
            foreach($jobs as $job){
                $jobinfo = array();
                array_push($jobinfo, array(
                    'id' => $job['id'],
                    'jobtitle' => $job['job_title'],
                    'jobsum' => $job['job_sum'],
                    'jobcap' => $job['job_cap']
                ));
                array_push($joblist, $jobinfo);
            }
            array_push($postsInfo, array(
                'id' => $post['id'],
                'posterId' => $post['poster_id'],
                'postername' => $user['username'],
                'posterimg' => $user['profile_image'],
                'projecttitle' => $post['project_title'],
                'projectintro' => $post['project_intro'],
                'createdAt' => date("d/m/Y", strtotime($post['created_at'])),
                'progreq' => $post['programming_req'],
                'techreq' => $post['technical_req'],
                'addreq' => $post['additional_req'],
                'jobsum' => $post['jobsum'],
                'jobcap' => $post['jobcap'],   
                'joblist' => $joblist
            ));
        }

        echo json_encode(array(
            'posts' => $postsInfo,
        ));
        http_response_code(200);
    } 
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_GET['url'] == "auth") {
        $user = array();
        $postBody = json_decode(file_get_contents("php://input"));
        $errors = array();
        if (empty($postBody->email)) {
            $errors['email'] = 'Email required';

            if (empty($postBody->password)) {
                $errors['password'] = 'Password required';
            }
        } else {

            if (!$db->select(["*"], ["users"], ['email' => $postBody->email])) {
                $errors['email'] = 'Not registered';
            } else {
                $user = $db->select(["*"], ["users"], ['email' => $postBody->email])[0];
                if (empty($postBody->password)) {
                    $errors['password'] = 'Password required';
                } else if (!password_verify($postBody->password, $user['password'])) {
                    $errors['password'] = 'Password incorrect';
                }
            }
        }

        if (!array_filter($errors)) {
            //$_SESSION['username'] = $user['username'];
            //$_SESSION['welcome-msg'] = "Welcome! " . $_SESSION['username'];
            $cstrong = True;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            $db->insert("login_tokens", ['token' => sha1($token), 'user_id' => $user['id']]);
            //setcookie('SNID', $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
            //setcookie('SNID_', '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
            echo '{ "Token": "' . $token . '"}';
            http_response_code(200);
        } else {
            echo '{';
            $errorString = "";
            foreach ($errors as $key => $value) {
                $errorString .= '"' . $key . '": "' . $value . '",';
            }
            echo substr($errorString, 0, strlen($errorString) - 1);
            echo '}';
            http_response_code(401);
        }
    } else if ($_GET['url'] == "users") {
        $errors = array();
        $admin = 0;
        $DEFAULT_FILENAME = 'default.png';

        if (empty($_POST['username'])) {
            $errors['username'] =  'Username required';
        } else if ($db->select(['username'], ['users'], ["username" => $_POST['username']])) {
            $errors['username'] = 'This username has been used';
        }
        if (empty($_POST['email'])) {
            $errors['email'] = 'Email required';
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email';
        } else if ($db->select(["email"], ["users"], ["email" => $_POST['email']])) {
            $errors['email'] = 'This email address has been used';
        }
        if (empty($_POST['password'])) {
            $errors['password'] = 'Password required';
        } else if (empty($_POST['passwordConf'])) {
            $errors['passwordConf'] = 'Password not confirmed';
        } else if ($_POST['password'] !== $_POST['passwordConf']) {
            $errors['passwordConf'] = 'Inconsistant passwords';
        }

        if (count($errors) === 0) {
            if (empty($_FILES['profile_image']['name'])) {
                $imagename = $DEFAULT_FILENAME;
                $result = true;
            } else {
                $imagename = $_POST['username'] . '_profile.' . end(explode(".", $_FILES['profile_image']['name']));
                $destination = "../assets/images/user-profile/" . $imagename;
                $result = move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination);
            }

            if ($result) {
                $profile_image = $imagename;
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $db->insert("users", ['username' => $_POST['username'], 'password' => $password, 'email' => $_POST['email'], 'profile_image' => $profile_image, 'admin' => $admin]);
                echo '{ "welcome-msg": "Register successful" }';
                http_response_code(200);
            } else {
                echo '{ "fileUpload": "Unable to upload image" }';
                http_response_code(409);
            }
        } else {
            echo '{';
            $errorString = "";
            foreach ($errors as $key => $value) {
                $errorString .= '"' . $key . '": "' . $value . '",';
            }
            echo substr($errorString, 0, strlen($errorString) - 1);
            echo '}';
            http_response_code(401);
        }
    } else if ($_GET['url'] == 'like') {
        http_response_code(503);
        $likeRecord = ['post_id' => $_GET['postid'], 'user_id' => $_GET['visitorid']];

        if (!$db->select(['user_id'], ['post_likes'], $likeRecord)) {
            $db->update('posts', ['id' => $_GET['postid']], ['likes' => 'likes+1']);
            $db->insert('post_likes', $likeRecord);
        } else {
            $db->update('posts', ['id' => $_GET['postid']], ['likes' => 'likes-1']);
            $db->delete('post_likes', $likeRecord);
        }

        echo '{';
        echo ' "likes": "' . $db->select(['likes'], ['posts'], ['id' => $_GET['postid']])[0]['likes'] . '",';
        echo ' "liked": "' . ($db->select(['user_id'], ['post_likes'], $likeRecord) ? 1 : 0) . '"';
        echo '}';
        http_response_code(200);
    } else if ($_GET['url'] == 'view') {
        http_response_code(503);
        $db->update('posts', ['id' => $_GET['postid']], ['viewed' => 'viewed+1']);
        echo '{';
        echo ' "viewed": "' . $db->select(['viewed'], ['posts'], ['id' => $_GET['postid']])[0]['viewed'] . '"';
        echo '}';
        http_response_code(200);
    } else if ($_GET['url'] == 'follow') {
        http_response_code(503);
        $postBody = json_decode(file_get_contents("php://input"));
        $user = $db->select(['* '], ['users'], ['id' => $postBody->userid])[0];
        $visitor_id = $postBody->visitorid;
        $user_id = $postBody->userid;

        if (!$db->select(['id'], ['followers'], ['user_id' => $user_id, 'follower_id' => $visitor_id])) {
            $db->insert('followers', ['user_id' => $user_id, 'follower_id' => $visitor_id]);
            $isFollowing = 1;
        } else {
            $db->delete('followers', ['user_id' => $user_id, 'follower_id' => $visitor_id]);
            $isFollowing = 0;
        }
        $followerNum = $db->select(['Count(id)'], ['followers'], ['user_id' => $user_id])[0]['Count(id)'];
        echo '{';
        echo ' "isFollowing": "' . $isFollowing . '",';
        echo ' "followerNum": "' . $followerNum . '"';
        echo '}';
        http_response_code(200);
    } else if ($_GET['url'] == "posts") {
        http_response_code(503);
        $cover_image = '';
        $DEFAULT_FILENAME = 'default.png';
        $srcType = $_POST['src_type'];
        $user_id = $_POST['user_id'];
        $tags = json_decode($_POST['tags']);

        $href = substr($_POST['url'], 0, 4) === 'http' ? $_POST['url'] : ('http://' . $_POST['url']);
        if (empty($_FILES['cover_image']['name'])) {
            $cover_image = $DEFAULT_FILENAME;
        } else {
            $cover_image = 'post_' . time() . '_' . $_FILES['cover_image']['name'];
            $destination = "../assets/images/" . ($srcType == "TUT" ? "post-cover/" : "oer-cover/") . $cover_image;
            $result = move_uploaded_file($_FILES['cover_image']['tmp_name'], $destination);
            if (!$result) {
                return;
            }
        }

        $post_id = $db->insert(
            'posts',
            [
                'user_id' => $user_id,
                'postTitle' => $_POST['postTitle'],
                'url' => $href,
                'description' => strlen($_POST['description']) >= 252 ? substr($_POST['description'], 0, 252) . "..." : $_POST['description'],
                'cover_image' => $cover_image,
                'src_type' => $srcType
            ]
        );
        $tag_ids = array();
        foreach ($tags as $tag) {
            if ($tag_id = $db->select(['id'], ['tags'], ['tag_name' => $tag])[0]['id']) {
                $db->update('tags', ["id" => $tag_id], ['tag_count' => 'tag_count+1']);
                array_push($tag_ids, $tag_id);
            } else {
                array_push($tag_ids, $db->insert('tags', ['tag_name' => $tag]));
            }
        }
        foreach ($tag_ids as $tagid) {
            $db->insert('post_tags', ['tag_id' => $tagid, 'post_id' => $post_id]);
        }
        http_response_code(200);
    } else if ($_GET['url'] == 'donate') {
        $cover_image = '';
        $user_id = $_POST['user_id'];
        $tip_method = $_POST['tip_method'];

        if (!empty($_FILES['qrcode_image']['name'])) {
            $image = $user_id . '.' . pathinfo($_FILES['qrcode_image']['name'], PATHINFO_EXTENSION);
            $destination = "../assets/images/user-QRcode/".$image;
            $result = move_uploaded_file($_FILES['qrcode_image']['tmp_name'], $destination);
            if (!$result) {
                return;
            }
            $db->update('users', ['id'=>$user_id], ['tip_method'=>$tip_method]);
            http_response_code(200);
        } else {
            http_response_code(403);
        }
    }  else if ($_GET['url'] == 'recruit') {
        $rawstring = file_get_contents("php://input");
        $postBody = json_decode($rawstring);
        $projecttitle = $postBody->projecttitle;
        $projectintro = $postBody->projectintro;
        $additionalreq = $postBody->addreq;
        $joblist = $postBody->joblist;
        $jobsum=0;
        foreach($joblist as $job){
            $jobsum+=intval(json_decode($job)->jobcap);
        }
        $recid = $db->insert('recruiments', [
            'poster_id'=>$postBody->uid,
            'project_title'=>$projecttitle,
            'project_intro'=>$projectintro,
            'programming_req'=>implode(",",$postBody->progreq),
            'technical_req'=>implode(",",$postBody->techreq),
            'additional_req'=>$additionalreq,
            'jobsum'=>$jobsum,
            'jobcap'=>$jobsum,
            ])[0];
        echo $recid; 
        foreach($joblist as $job){
            $jobid = $db->insert('jobs', [
                'recruiment_id' => $recid,
                'job_title' => json_decode($job)->jobtitle,
                'job_sum' => json_decode($job)->jobcap,
                'job_cap' => json_decode($job)->jobcap
            ]);
        }
        http_response_code(200);
    }else if ($_GET['url'] == 'apply') {
        http_response_code(503);
        $postBody = json_decode(file_get_contents("php://input"));
        $user = $db->select(['* '], ['users'], ['id' => $postBody->userid])[0];
        $user_id = $postBody->userid;

        if (!$db->select(['id'], ['jobs'], ['id' => $postBody->jobid])) {
            http_response_code(404);
            echo "Job not found!";
        }else if ($db->select(['id'], ['applications'], ['user_id' => $postBody->userid ,'job_id' => $postBody->jobid])) {
            http_response_code(403);
            echo "Already applied! Please wait for the organizer!";
        }  else {
            $db->insert('applications', ['user_id' => $user_id, 'job_id' => $postBody->jobid]);
            http_response_code(200);
        }
        
    }else if ($_GET['url'] == 'job') {
        http_response_code(503);
        $postBody = json_decode(file_get_contents("php://input"));
        $db->update('applications', ['id' => $postBody->id], ['status' => '"APPROVED"']);
        $jobid = $db->select(['job_id'], ['applications'],['id' => $postBody->id])[0]['job_id'];
        $db->update('jobs', ['id' => $jobid ], ['job_cap' => 'job_cap-1']);
        $recid =  $db->select(['recruiment_id'], ['jobs'],['id' => $postBody->id])[0]['recruiment_id'];
        $db->update('recruiments', ['id' => $recid], ['job_cap' => 'job_cap-1']);
        http_response_code(200);
    }else if ($_GET['url'] == 'image') {
        http_response_code(503);
        if (empty($_FILES['profile_image']['name'])) {
            http_response_code(403);
            echo 'File Lost';
            return;
        } else {
            $user_name = $db->select(['username'], ['users'], ['id'=>$_POST['userid']])[0]['username'];
            $imagename = $user_name . '_profile.' . end(explode(".", $_FILES['profile_image']['name']));
            $destination = "../assets/images/user-profile/" . $imagename;
            $result = move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination);
        }
        if ($result) {
            $profile_image = $imagename;
            $db->update("users", ['id' => $_POST['userid']], ['profile_image' => '"'.$profile_image.'"']);
            http_response_code(200);
        } else {
            echo 'Unable to upload image';
            http_response_code(409);
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    if ($_GET['url'] == "auth") {
        if (isset($_COOKIE['SNID'])) {
            if ($db->select(["token"], ["login_tokens"], ["token" => sha1($_COOKIE['SNID'])])) {
                $db->delete('login_tokens', ['token' => sha1($_COOKIE['SNID'])]);
                setcookie('SNID', '1', time() - 3600, '/');
                setcookie('SNID_', '1', time() - 3600, '/');
                http_response_code(200);
            }
        } else {
            http_response_code(405);
        }
    }else if ($_GET['url'] == 'job'){
        http_response_code(503);
        $postBody = json_decode(file_get_contents("php://input"));
        $jobid = $db->select(['job_id'], ['applications'],['id' => $postBody->id])[0]['job_id'];
        $recid =  $db->select(['recruiment_id'], ['jobs'],['id' => $postBody->id])[0]['recruiment_id'];
        $db->update('recruiments', ['id' => $recid], ['job_cap' => 'job_cap+1']);
        $isExpel = ($db->select(['status'], ['applications'],['id' => $postBody->id])[0]['status']=="APPROVED");
        $db->delete('applications', ['id' => $postBody->id]);
        if($isExpel){
            $db->update('jobs', ['id' => $jobid], ['job_cap' => 'job_cap+1']);
        }
        http_response_code(200);
    } 
} else {
    http_response_code(405);
}
