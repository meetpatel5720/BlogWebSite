<div class="row">
    <div class="col-lg-12 table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Comment</th>
                    <th>In Response to</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php //show category script

                $user_id = $_SESSION['user_id'];

                $query = "SELECT comments.* ,posts.post_title FROM comments LEFT JOIN posts ON comments.comment_post_id = posts.post_id WHERE comment_author_id = $user_id ORDER BY comment_date DESC";
                $select_comments = mysqli_query($connection,$query);

                while($row = mysqli_fetch_assoc($select_comments)){
                    $comment_id = $row['comment_id'];
                    $comment_post_id = $row['comment_post_id'];
                    $comment_author_id = $row['comment_author_id'];
                    $comment_content = $row['comment_content'];
                    $comment_date = $row['comment_date'];
                    $comment_post_title = $row['post_title'];

                    $comment_date = date("d-m-Y H:i:s", strtotime($comment_date));

                    echo "<tr>";
                    echo "<td>{$comment_id}</td>";
                    echo "<td>{$comment_content}</td>";
                    echo "<td><a href='../post.php?p_id=$comment_post_id'>$comment_post_title</a></td>";
                    echo "<td>{$comment_date}</td>";
                    echo "<td><a href='comments.php?delete_comment=$comment_id'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>

                <?php //Delete comment
                if(isset($_GET['delete_comment'])){
                    if(checkUserCredentialForComment($_SESSION['user_id'],$_GET['delete_comment'])){
                        $delete_comment_id = $_GET['delete_comment'];
                        $delete_query = "DELETE FROM comments WHERE comment_id = $delete_comment_id";
                        $delete_comment_query = mysqli_query($connection,$delete_query);

                        header("Location: comments.php");
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
