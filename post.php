<?php include "includes/db.php";?>
<?php include "includes/functions.php";?>
<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Post</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="css/block_style.css">
        <link rel="stylesheet" href="css/common_style.css">

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <?php include "includes/header_nav.php"; ?>


       <!--Boostrap modal for login message-->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="exampleModalLongTitle">You are not logged in</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Please login/signup to like or unlike this post.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="login" type="button" class="btn btn-primary">Login</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if(isset($_GET['p_id'])){
            $p_id = $_GET['p_id'];

            if (!isset($_SESSION['recent_viewed_posts'][$p_id])) {
                $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $p_id";
                $send_query = mysqli_query($connection, $view_query);
                confirmQuery($send_query);

                $_SESSION['recent_viewed_posts'][$p_id] = 1;
            }



        }

        $query = "SELECT posts.* , users.user_id, users.username ";
        $query .= "FROM posts LEFT JOIN users ON posts.post_user_id = users.user_id ";
        $query .= "WHERE post_id = $p_id AND post_status = 'published'";

        $select_all_post_query = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_all_post_query)){
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            $post_user_id = $row['user_id'];
            $post_username = $row['username'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_views_count = $row['post_views_count'];
            $post_likes = $row['post_likes'];

            $post_date = date("d-m-Y H:i:s", strtotime($post_date));

            /*while loop continuous*/
        ?>

        <div class="col-left">
            <div>
                <h2 style="clear: both;"><?php echo $post_title ?></h2>

                <p class="mb-2">by <a href="profile.php?username=<?php echo $post_username;?>" class="post_owner"><?php echo $post_username;?></a></p>
                <hr>

                <p class="mb-2"><i class="fa fa-clock-o" aria-hidden="true"></i> Posted on <?php echo $post_date ?></p>

                <hr>
                <img class="post-img" src="resource/images/<?php echo $post_image ?>" alt="">

                <div class="post-content-block"><?php echo $post_content ?></div>
                <hr>

                <span class="h3 mr-3 text-info"><i class="fa fa-eye"></i> <?php echo $post_views_count ?></span>

                <button id="like-button" type="button" class="h3 mb-0 <?php echo isUserLiked($post_id,getLoggedInUserId()) ? 'unlike' : 'like' ;?>"><i class="fa fa-thumbs-up"></i> <span><?php echo getPostLikes($post_id);?></span></button>
                <hr>
            </div>

            <!--End of php while loop-->
            <?php } ?>

            <?php //add comment
            $error_msg = "";
            if(isset($_POST['post_comment'])){

                if(isUserLoggedIn()){

                    $comment_author_id = $_SESSION['user_id'];
                    $comment_content = $_POST['comment_content'];

                    $query = "INSERT INTO comments (comment_post_id,comment_author_id,comment_content,comment_date) ";
                    $query .= "VALUES ({$p_id},{$comment_author_id},'{$comment_content}',now())";
                    $insert_comment_query = mysqli_query($connection, $query);

                    confirmQuery($insert_comment_query);

                    header("Location: post.php?p_id={$p_id}");
                }
                else{
                    $error_msg = "Please log into your account to add comment.";
                }
            }
            ?>

            <!--Comment box-->
            <div class="well mt-2">
                <h4>Leave a comment:</h4>
                <p class="text-danger mb-0"><?php echo $error_msg; ?></p>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <textarea class="form-control" rows="3" name="comment_content"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="post_comment">Submit</button>
                </form>
            </div>
            <hr>

            <h2>Recent comments</h2>

            <!--Posted comments-->
            <?php
            $query = "SELECT comments.* , users.username FROM comments LEFT JOIN users on comments.comment_author_id = users.user_id WHERE comment_post_id = $p_id ORDER BY comment_date DESC";
            $select_comments_query = mysqli_query($connection,$query);
            while($row = mysqli_fetch_assoc($select_comments_query)){
                $comment_date = $row['comment_date'];
                $comment_author = $row['username'];
                $comment_content = $row['comment_content'];

                $comment_date = date("d-m-Y H:i:s", strtotime($comment_date));

            ?>

            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><a href="profile.php?username=<?php echo $comment_author; ?>"><?php echo $comment_author; ?></a><span style="font-size:14px;"> <i class="fa fa-clock-o"></i> <?php echo $comment_date; ?></span>
                    </h4>
                    <p><?php echo $comment_content; ?></p>
                </div>
            </div>
            <hr>

            <?php } ?>

            <!--Comment 1-->

        </div>

        <?php include "includes/sidecolumn.php"; ?>
        <?php include "includes/footer.php"; ?>

        <script>
            var images = document.querySelectorAll('.post-content-block img');
            images.forEach(function myFunction(item, index) {
                images[index].removeAttribute("width");
                images[index].removeAttribute("height");
            });
        </script>

        <!--Like button query-->
        <script>
            $(document).ready(function(){
                var user_id = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1?>;
                var post_id = <?php echo $p_id;?>;

                var isUserLoggedIn = <?php echo isUserLoggedIn() ? 'true' : 'false';?>;
                console.log(isUserLoggedIn);

                if(isUserLoggedIn){
                    $(document).on('click','.like', function(){
                        $.ajax({

                            url: "includes/likes_handler.php",
                            type: 'post',
                            data:{
                                'liked': 1,
                                'post_id': post_id,
                                'user_id': user_id
                            },
                            success: function($result){
                                $('#like-button').removeClass('like');
                                $('#like-button').addClass('unlike');
                                $('#like-button span').text($result);
                            }

                        });
                    });
                    //unlike

                    $(document).on('click','.unlike', function(){
                        $.ajax({

                            url: "includes/likes_handler.php",
                            type: 'post',
                            data:{
                                'unliked': 1,
                                'post_id': post_id,
                                'user_id': user_id
                            },
                            success: function($result){
                                $('#like-button').removeClass('unlike');
                                $('#like-button').addClass('like');
                                $('#like-button span').text($result);
                            }

                        });
                    });
                }
                else{
                    $('#like-button').attr("data-toggle","modal");
                    $('#like-button').attr("data-target","#loginModal");
                    $('#login').click(function(){
                        window.location.href = "login.php";
                    });
                }


            });
        </script>

    </body>
</html>
