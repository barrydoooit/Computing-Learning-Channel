<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/EvolvedChannel/app/classes/DB.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/EvolvedChannel/app/classes/Login.php");

    $likeRecord = ['post_id' => $_GET['postid'], 'user_id' => isset($visitor_id)?$visitor_id:Login::isLoggedIn()];
   
    if (!DB::select(['user_id'], ['post_likes'], $likeRecord)) {
        DB::update('posts', ['id' => $_GET['postid']], ['likes' => 'likes+1']);
        DB::insert('post_likes', $likeRecord);
    } else {
        DB::update('posts', ['id' => $_GET['postid']], ['likes' => 'likes-1']);
        DB::delete('post_likes', $likeRecord);
    }
   
    die(json_encode(array(
        'likes' => DB::select(['likes'], ['posts'], ['id'=>$_GET['postid']])[0]['likes'],
        'liked' => DB::select(['user_id'], ['post_likes'], $likeRecord)?1:0
    )));