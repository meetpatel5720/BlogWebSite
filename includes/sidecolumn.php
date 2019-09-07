<div class="col-right">

    <div class="well">
        <h4>Search categories</h4>

        <div class="input-group">
            <input id="search" type="text" name="search" class="form-control" placeholder="Enter search text">
            <div class="input-group-append">
                <p class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></p>
            </div>
        </div>
        <div id="search_result"></div>
    </div>

    <div class="well">
        <h4>Top catagories</h4>
        <ul>

            <?php
            $query = "SELECT categories.cat_id,categories.cat_title, COUNT(*) as post_count FROM posts LEFT JOIN categories ON categories.cat_id = posts.post_category_id GROUP BY posts.post_category_id ORDER BY post_count DESC LIMIT 0,5";
            $select_all_catagories_query = mysqli_query($connection,$query);

            while($row = mysqli_fetch_assoc($select_all_catagories_query)){
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<li><a href='category.php?category_id=$cat_id'>{$cat_title}</a></li>";
            }
            ?>

        </ul>
    </div>

    <div class="well">
        <h4>Top posts</h4>
        <ul>
            <?php

            $query = "SELECT posts.* , users.user_id, users.username FROM posts LEFT JOIN users ON posts.post_user_id = users.user_id WHERE post_status = 'published' ORDER BY post_views_count DESC, post_likes DESC LIMIT 0,8";

            $select_posts = mysqli_query($connection,$query);

            while($row = mysqli_fetch_assoc($select_posts)){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_user_id = $row['user_id'];
                $post_username = $row['username'];
                $post_views_count = $row['post_views_count'];
                $post_likes = $row['post_likes'];


                echo "<li>";
                echo "<a class='post-title-small font-weight-bold' href='post.php?p_id=$post_id'>$post_title</a>";
                echo "<div>";
                echo "<sapn class='mb-2'>by <a href='profile.php?username=$post_username' class='post_owner'>$post_username</a></sapn>";
                echo "<span class='float-right'>";
                echo "<span class='text-info'><i class='fa fa-eye'></i> $post_views_count</span>";
                echo "<span class='ml-3 text-yellowbrown'><i class='fa fa-thumbs-up'></i> $post_likes</span>";
                echo "</span></div></li>";
                echo "<hr>";
            }
            ?>
        </ul>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(document).on('keyup','#search',function(){
            var keyword = $(this).val();
            if(keyword != ''){
                $.ajax({
                    url: "includes/search_handler.php",
                    type : 'post',
                    data:{
                        'search_key' : keyword
                    },
                    success: function(result){
                        $('#search_result').html(result);
                    }
                });
            }
        });
    });
</script>
