<?php include "../includes/db.php";?>
<?php include "includes/activity_header.php";?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Activity Panel</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../css/activity_css.css">
        <link rel="stylesheet" href="../css/common_style.css">

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>
    <body>

        <?php include "includes/navigation.php"?>

        <div class="page-container">
            <h1>Welcome <small><?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'];?></small></h1>
            <hr>


            <!-- /.row -->

            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card panel-blue">
                        <div class="card-header bg-primary">
                            <div class="row text-white">
                                <div class="col-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <?php
                                    $user_id = $_SESSION['user_id'];
                                    $query = "SELECT * FROM posts where post_user_id = $user_id";
                                    $select_all_post = mysqli_query($connection,$query);
                                    $post_count = mysqli_num_rows($select_all_post);
                                    echo "<div class='huge'>$post_count</div>";
                                    ?>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="card-footer">
                                <span class="float-left">View Details</span>
                                <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card panel-green">
                        <div class="card-header bg-success">
                            <div class="row text-white">
                                <div class="col-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <?php

                                    $query = "SELECT comments.* FROM comments LEFT JOIN posts ON comments.comment_post_id = posts.post_id WHERE comment_author_id = $user_id";

                                    $select_all_comments = mysqli_query($connection,$query);
                                    $comment_count = mysqli_num_rows($select_all_comments);
                                    echo "<div class='huge'>$comment_count</div>";
                                    ?>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="card-footer">
                                <span class="float-left">View Details</span>
                                <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card panel-yellow">
                        <div class="card-header bg-warning">
                            <div class="row text-white">
                                <div class="col-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <?php
                                    $query = "SELECT SUM(post_views_count) AS post_views_count FROM posts WHERE post_user_id = $user_id";
                                    $getviews = mysqli_query($connection,$query);
                                    while($row = mysqli_fetch_assoc($getviews)){
                                        $views_count = $row['post_views_count'];
                                    }
                                    echo "<div class='huge'>$views_count</div>";
                                    ?>
                                    <div> Post views</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="card-footer">
                                <span class="float-left">View Details</span>
                                <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card panel-red">
                        <div class="card-header bg-danger">
                            <div class="row text-white">
                                <div class="col-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-9 text-right">
                                    <?php
                                    $query = "SELECT SUM(post_likes) AS post_likes_count FROM posts WHERE post_user_id = $user_id";
                                    $getlikes = mysqli_query($connection,$query);
                                    while($row = mysqli_fetch_assoc($getlikes)){
                                        $likes_count = $row['post_likes_count'];
                                    }
                                    echo "<div class='huge'>$likes_count</div>";
                                    ?>
                                    <div>Likes</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="card-footer">
                                <span class="float-left">View Details</span>
                                <span class="float-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->


            <!--Chart-->
            <div class="col-lg-12 table-responsive inner-border"id="analysis_chart" style="width:auto; height: 500px; "></div>
        </div>

        <script>
            var dashboard = document.getElementById("dashboard");
            dashboard.className += "active";
        </script>


        <!--Charts script-->

        <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Data', 'Count'],

                    <?php
                    $element_text = ['Active Post', 'Post Views', 'Comments', 'Likes'];
                    $element_count = [$post_count,$views_count,$comment_count,$likes_count];

                    for($i = 0; $i<4; $i++){
                        echo "['{$element_text[$i]}'" . "," . " {$element_count[$i]}],";
                    }
                    ?>
                ]);

                var options = {
                    chart: {
                        title: '',
                        subtitle: '',
                    }
                };

                var chart = new google.charts.Bar(document.getElementById('analysis_chart'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>
    </body>
</html>
