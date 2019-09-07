<?php include "includes/db.php";?>
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

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <?php include "includes/header_nav.php"; ?>

        <div class="col-left">
            <h1>Recent Posts</h1>
            <hr>
            <!--Post 1-->

            <?php

            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }
            else{
                $page = "";
            }

            if($page == "" || $page == 1){
                $page_1 = 0;
            }
            else{
                $page_1 = ($page * 5) - 5;
            }

            $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
            $find_count = mysqli_query($connection, $post_query_count);
            $count = mysqli_num_rows($find_count);

            $count = ceil($count / 5);


            $query = "SELECT posts.* , users.user_id, users.username ";
            $query .= "FROM posts LEFT JOIN users ON posts.post_user_id = users.user_id ";
            $query .= "WHERE post_status = 'published' ORDER BY post_date DESC LIMIT $page_1 , 5";

            //            $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_date DESC LIMIT $page_1 , 5";
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

            <div>

                <h2 style="clear: both;"><a class="post-title" href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a></h2>

                <p class="mb-2">by <a href="profile.php?username=<?php echo $post_username;?>" class="post_owner"><?php echo $post_username;?></a></p>
                <hr>

                <p class="mb-2"><i class="fa fa-clock-o" aria-hidden="true"></i> Posted on <?php echo $post_date ?></p>
                <hr>

                <div>
                    <span class="h4 text-info"><i class="fa fa-eye"></i> <?php echo $post_views_count ?></span>
                    <span class="h4 ml-3 text-yellowbrown"><i class="fa fa-thumbs-up"></i> <?php echo $post_likes ?></span>
                </div>
                <hr>

                <img class="post-img" src="resource/images/<?php echo $post_image ?>" alt="">

                <div class="post-content"><?php echo $post_content ?></div>


                <a class="btn btn-primary mt-2 mb-2" href="post.php?p_id=<?php echo $post_id ?>">ReadMore <i class="fa fa-chevron-circle-right"></i></a>

                <hr>
            </div>

            <!--End of php while loop-->
            <?php } ?>

            <!--Pager navigation-->
            <div class="pager">
                <ul id="page" class="pagination justify-content-center mt-2">
                </ul>
            </div>
        </div>

        <?php include "includes/sidecolumn.php"; ?>
        <?php include "includes/footer.php"; ?>

        <script>
            var images = document.querySelectorAll('.post-content img');
            images.forEach(function myFunction(item, index) {
                images[index].removeAttribute("width");
                images[index].removeAttribute("height");
            });
        </script>

        <script>
            function getPageRange(totalPages, page, maxLength) {

                function range(start, end) {
                    return Array.from(Array(end - start + 1), ($, i) => i + start);
                }

                if (totalPages <= maxLength) {
                    // no breaks in list
                    return range(1, totalPages);
                }

                if (page <= 3) {
                    // no break on left of page
                    return range(1, maxLength);
                }
                if (page > totalPages-3) {
                    // no break on left of page
                    return range(totalPages - 5 + 1, totalPages);
                }

                return range(page-2, page+2);
            }

            $(function () {
                var totalPages = <?php echo $count?>;
                var paginationSize = 5;   //size for max no of buttons shown in paginaion.
                var currentPage = <?php echo $page == "" ? 1 : $page; ?>;

                function showPagination(pageNo) {
                    if (pageNo < 1 || pageNo > totalPages) return false;

                    currentPage = pageNo;

                    // Replace the navigation items (not prev/next):
                    $(".pagination li").slice(1, -1).remove();

                    getPageRange(totalPages, currentPage, paginationSize).forEach( item => {
                        $("<li>").addClass("page-item")
                            .toggleClass("active", item === currentPage).append(
                            $("<a>").addClass("page-link").attr({
                                href: "index.php?page=" + item}).text(item)
                        ).insertBefore("#next-page");
                    });

                    // Disable prev/next when at first/last page:
                    $("#previous-page").toggleClass("disabled", currentPage === 1);
                    $("#next-page").toggleClass("disabled", currentPage === totalPages);
                    return true;
                }

                // Include the prev/next buttons:
                $(".pagination").append(
                    $("<li>").addClass("page-item").attr({ id: "previous-page" }).append(
                        $("<a>").addClass("page-link").attr({
                            href: "index.php?page=" + (currentPage -1)}).text("Prev")
                    ),
                    $("<li>").addClass("page-item").attr({ id: "next-page" }).append(
                        $("<a>").addClass("page-link").attr({
                            href: "index.php?page=" + (currentPage +1)}).text("Next")
                    )
                );
                // Show the page links
                showPagination(currentPage);
            });
        </script>
    </body>
</html>
