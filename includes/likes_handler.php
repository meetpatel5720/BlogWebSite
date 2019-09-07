<?php ob_start(); ?>
<?php include "db.php";?>
<?php include "functions.php";?>
<?php
// like function
if(isset($_POST['liked'])){
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    // fetching the right post
    $searchPost = "SELECT * FROM posts WHERE post_id = $post_id";
    $postResult = mysqli_query($connection, $searchPost);
    $post = mysqli_fetch_assoc($postResult);
    $likes = $post['post_likes'];

    //updating the likes
    mysqli_query($connection,"UPDATE posts SET post_likes = $likes+1 WHERE post_id = $post_id");

    //add like into like table
    mysqli_query($connection,"INSERT INTO likes(user_id,post_id) VALUES($user_id,$post_id)");

    echo getPostLikes($post_id);
    exit();
}

//unlike function
if(isset($_POST['unliked'])){
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    // fetching the right post
    $searchPost = "SELECT * FROM posts WHERE post_id = $post_id";
    $postResult = mysqli_query($connection, $searchPost);
    $post = mysqli_fetch_assoc($postResult);
    $likes = $post['post_likes'];

    //updating the likes
    mysqli_query($connection,"UPDATE posts SET post_likes = $likes-1 WHERE post_id = $post_id");

    //remove like from like table
    mysqli_query($connection,"DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id");

    echo getPostLikes($post_id);
    exit();
}
?>
