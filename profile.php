<?php include "includes/db.php";?>
<?php include "includes/functions.php";?>
<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="css/block_style.css">
        <link rel="stylesheet" href="css/common_style.css">

        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php include "includes/header_nav.php"; ?>

        <?php
        if(isset($_GET['username'])){
            $username = $_GET['username'];

            $query = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($connection,$query);
            confirmQuery($result);
            while($row = mysqli_fetch_assoc($result)){
                $user_id = $row['user_id'];
                $firstname = $row['user_firstname'];
                $lastname = $row['user_lastname'];
                $email = $row['user_email'];
                $image = $row['user_image'];
            }
            if(empty($image)){
                $image = "user_no_profile.png";
            }
        }
        ?>

        <div class="px-4 py-3">
            <div class="row mb-3">
                <div class="col-auto">
                    <img class="img-fluid rounded-circle img-thumbnail" src="resource/userimages/<?php echo $image;?>" alt="">
                </div>
                <div class="col align-self-center">
                    <h3 class="mb-0"><?php echo $firstname . " " .$lastname;?></h3>
                    <h4 class="text-primary mb-0"><small>@ <?php echo $username;?></small></h4>
                    <p class="mb-0"><strong>Email: </strong><?php echo $email;?></p>
                </div>
            </div>
            <hr>

            <div class="row mt-2">
                <div class="col-md-6 mb-3">
                    <div class="rounded-card">
                        <h3>Posts from <?php echo $firstname . " " .$lastname;?></h3>
                        <ul class="list-unstyled mb-0">
                            <?php
                            $query = "SELECT posts.* , users.user_id, users.username FROM posts LEFT JOIN users ON posts.post_user_id = users.user_id WHERE post_user_id = $user_id AND post_status = 'published' ORDER BY post_views_count DESC, post_likes DESC";
                            $select_posts = mysqli_query($connection,$query);
                            confirmQuery($select_posts);
                            while($row = mysqli_fetch_assoc($select_posts)){
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                                $post_user_id = $row['user_id'];
                                $post_username = $row['username'];
                                $post_views_count = $row['post_views_count'];
                                $post_likes = $row['post_likes'];


                                echo "<li class='user-post' style='display:none;'>";
                                echo "<a class='post-title-small font-weight-bold' href='post.php?p_id=$post_id'>$post_title</a>";
                                echo "<div>";
                                echo "<sapn class='mb-2'>by <a href='profile.php?username=$post_username' class='post_owner'>$post_username</a></sapn>";
                                echo "<span class='float-right'>";
                                echo "<span class='text-info'><i class='fa fa-eye'></i> $post_views_count</span>";
                                echo "<span class='ml-3 text-yellowbrown'><i class='fa fa-thumbs-up'></i> $post_likes</span>";
                                echo "</span></div>";
                                echo "<hr></li>";
                            }
                            ?>
                        </ul>

                        <a href="#" id="loadMorePost" class="btn btn-primary">Load More</a>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="rounded-card">
                        <h3>Posts liked by <?php echo $firstname . " " .$lastname;?></h3>
                        <ul class="list-unstyled mb-0">
                            <?php
                            $query = "SELECT posts.* , users.user_id, users.username FROM likes LEFT JOIN posts ON likes.post_id = posts.post_id LEFT JOIN users on posts.post_user_id=users.user_id WHERE likes.user_id = $user_id AND post_status = 'published' ORDER BY post_views_count DESC, post_likes DESC";

                            $select_posts = mysqli_query($connection,$query);
                            confirmQuery($select_posts);
                            $count = mysqli_num_rows($select_posts);
                            if($count<1){
                                echo "<p class='text-muted'>No post found</a></p>";
                            }
                            while($row = mysqli_fetch_assoc($select_posts)){
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                                $post_user_id = $row['user_id'];
                                $post_username = $row['username'];
                                $post_views_count = $row['post_views_count'];
                                $post_likes = $row['post_likes'];


                                echo "<li class='user-liked-post' style='display:none;'>";
                                echo "<a class='post-title-small font-weight-bold' href='post.php?p_id=$post_id'>$post_title</a>";
                                echo "<div>";
                                echo "<sapn class='mb-2'>by <a href='profile.php?username=$post_username' class='post_owner'>$post_username</a></sapn>";
                                echo "<span class='float-right'>";
                                echo "<span class='text-info'><i class='fa fa-eye'></i> $post_views_count</span>";
                                echo "<span class='ml-3 text-yellowbrown'><i class='fa fa-thumbs-up'></i> $post_likes</span>";
                                echo "</span></div>";
                                echo "<hr></li>";
                            }
                            ?>
                        </ul>

                        <a href="#" id="loadMoreLikedPost" class="btn btn-primary">Load More</a>
                    </div>
                </div>
            </div>
        </div>


        <!--       load more post functionality on liad more click-->
        <script>
            $(document).ready(function () {

                //for user's post
                $('.user-post').slice(0,5).show();
                if($('.user-post').length<=5){
                    $("#loadMorePost").hide();
                }
                $(document).on('click','#loadMorePost', function (e) {
                    e.preventDefault();
                    $(".user-post:hidden").slice(0, 5).slideDown();
                    if ($(".user-post:hidden").length == 0) {
                        $("#loadMorePost").fadeOut('slow');
                    }
                    $('html,body').animate({
                        scrollTop: $(this).offset().top
                    }, 1000);
                });


                // for liked post
                $('.user-liked-post').slice(0,5).show();
                if($('.user-liked-post').length<=5){
                    $("#loadMoreLikedPost").hide();
                }
                $(document).on('click','#loadMoreLikedPost', function (e) {
                    e.preventDefault();
                    $(".user-liked-post:hidden").slice(0, 5).slideDown();
                    if ($(".user-liked-post:hidden").length == 0) {
                        $("#loadMoreLikedPost").fadeOut('slow');
                    }
                    $('html,body').animate({
                        scrollTop: $(this).offset().top
                    }, 1000);
                });
            });
        </script>
    </body>
</html>
