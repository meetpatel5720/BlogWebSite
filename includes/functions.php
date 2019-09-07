<?php
function checkUserCredentialForPost($user_id,$p_id){
    global $connection;
    $query = "SELECT posts.post_user_id , users.user_id FROM posts LEFT JOIN users ON posts.post_user_id = users.user_id where post_user_id = $user_id AND post_id = $p_id";
    $result = mysqli_query($connection,$query);
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $post_user_id = $row['post_user_id'];
        }
        if($post_user_id === $user_id){
            return true;
        }
    }
    return false;

}
function checkUserCredentialForComment($user_id,$comment_id){
    global $connection;
    $query = "SELECT comments.comment_author_id , users.user_id FROM comments LEFT JOIN users ON comments.comment_author_id = users.user_id where comments.comment_author_id = $user_id AND comment_id = $comment_id";
    $result = mysqli_query($connection,$query);
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $comment_author_id = $row['post_user_id'];
        }
        if($comment_author_id === $user_id){
            return true;
        }
    }
    return false;
}
function userNameExists($username){
    global $connection;
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $checkQuery = mysqli_query($connection, $query);

    $usercount = mysqli_num_rows($checkQuery);

    if($usercount > 0){
        return true;
    }
    else{
        return false;
    }
}

function emailExists($email){
    global $connection;
    $query = "SELECT * FROM users WHERE user_email = '{$email}'";
    $checkQuery = mysqli_query($connection, $query);

    $count = mysqli_num_rows($checkQuery);

    if($count > 0){
        return true;
    }
    else{
        return false;
    }
}

function isUserLoggedIn(){
    if(isset($_SESSION['username'])){
        return true;
    }
    else{
        return false;
    }
}

function isCategoryExists($category){
    global $connection;
    $query = "SELECT * FROM categories WHERE cat_title = '{$category}'";
    $checkQuery = mysqli_query($connection, $query);

    $count = mysqli_num_rows($checkQuery);

    if($count > 0){
        return true;
    }
    else{
        return false;
    }
}

function confirmQuery($result){
    global $connection;
    if(!$result){
        die('QUERY FAILED' . mysqli_error($connection));
    }
}

function getLoggedInUserId(){
    return isUserLoggedIn() ? $_SESSION['user_id'] : -1 ;
}

function isUserLiked($post_id = '',$user_id = ''){
    global $connection;
    $query = "SELECT * FROM likes WHERE user_id = $user_id AND post_id = $post_id";
    $result = mysqli_query($connection,$query);
    confirmQuery($result);

    return mysqli_num_rows($result) >= 1 ? true : false ;
}

function getPostLikes($post_id){
    global $connection;
    $query = "SELECT * FROM likes WHERE post_id = $post_id";
    $result = mysqli_query($connection,$query);
    $count = mysqli_num_rows($result);
    return $count;
}
?>
