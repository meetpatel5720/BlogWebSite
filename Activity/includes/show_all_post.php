<h1>Your Posts</h1>
<hr>
<div class="row">
    <div class="col-lg-12 table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Tags</th>
                    <th>Comments</th>
                    <th>Views</th>
                    <th>Likes</th>
                    <th>Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>

                <?php //show category script

                $user_id = $_SESSION['user_id'];
                $query = "SELECT posts.* , COUNT(comments.comment_id) AS comment_count FROM posts LEFT JOIN comments ON posts.post_id = comments.comment_post_id where post_user_id = $user_id GROUP BY posts.post_id ORDER BY post_date DESC";
                $select_posts = mysqli_query($connection,$query);

                while($row = mysqli_fetch_assoc($select_posts)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['comment_count'];
                    $post_views_count = $row['post_views_count'];
                    $post_likes = $row['post_likes'];
                    $post_date = $row['post_date'];

                    $post_date = date("d-m-Y H:i:s", strtotime($post_date));

                    echo "<tr>";
                    echo "<td>{$post_id}</td>";
                    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";

                    $category_query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
                    $select_category_query = mysqli_query($connection,$category_query);
                    while($row = mysqli_fetch_assoc($select_category_query)){
                        $cat_title = $row['cat_title'];
                        echo "<td>{$cat_title}</td>";
                    }

                    echo "<td>{$post_status}</td>";
                    echo "<td><img class='post-img' src='../resource/images/$post_image' alt='image'></td>";
                    echo "<td>{$post_tags}</td>";
                    echo "<td>{$post_comment_count}</td>";
                    echo "<td>{$post_views_count}</td>";
                    echo "<td>{$post_likes}</td>";
                    echo "<td>{$post_date}</td>";
                    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                    echo "<td><a href='posts.php?delete_post={$post_id}'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>


                <?php
                if(isset($_GET['delete_post']) && isUserLoggedIn()){
                    if(checkUserCredentialForPost($_SESSION['user_id'],$_GET['p_id'])){
                        $delete_post_id = $_GET['delete_post'];
                        $delete_query = "DELETE FROM posts WHERE post_id = $post_id";
                        $delete_post_query = mysqli_query($connection,$delete_query);

                        header("Location: posts.php");
                    }
                    else{
                        header("Location: error.php?error=nocredential");
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
</div>
