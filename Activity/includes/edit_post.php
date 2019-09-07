<?php

if(isset($_GET['p_id'])){
    if(checkUserCredentialForPost($_SESSION['user_id'],$_GET['p_id'])){
        $edit_post_id = $_GET['p_id'];

        $query = "SELECT * FROM posts WHERE post_id = {$edit_post_id}";
        $select_post_by_id = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_post_by_id)){
            $post_id = $row['post_id'];
            $post_user_id = $row['post_user_id'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_content = $row['post_content'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_date = $row['post_date'];
        }

        if(isset($_POST['edit_post'])){
            $post_title = $_POST['post_title'];
            $post_category_id = $_POST['post_category'];
            $post_user_id = $_SESSION['user_id'];
            $post_status = $_POST['post_status'];
            $post_tags = $_POST['post_tags'];
            $post_content = $_POST['post_content'];
            $post_content = mysqli_real_escape_string($connection, $post_content);

            $post_image = $_FILES['post_image']['name'];

            if(empty($post_image)){
                $image_query = "SELECT * FROM posts WHERE post_id = $edit_post_id";
                $select_image = mysqli_query($connection, $image_query);
                while($row = mysqli_fetch_assoc($select_image)){
                    $post_image_name = $row['post_image'];
                }
            }
            else{
                $temp = explode(".", $_FILES['post_image']['name']);
                $post_image_name = $temp[0] . "_" . rand(0,100000) . "." . $temp[1];

                $post_image_temp = $_FILES['post_image']['tmp_name'];

                move_uploaded_file($post_image_temp, "../resource/images/$post_image_name");
            }

            $query = "UPDATE posts SET ";
            $query .= "post_title = '{$post_title}', ";
            $query .= "post_category_id = '{$post_category_id}', ";
            $query .= "post_user_id = {$post_user_id}, ";
            $query .= "post_status = '{$post_status}', ";
            $query .= "post_image = '{$post_image_name}', ";
            $query .= "post_tags = '{$post_tags}', ";
            $query .= "post_content = '{$post_content}' ";
            $query .= "WHERE post_id = '{$edit_post_id}'";

            $edit_post_query = mysqli_query($connection,$query);

            if(!$edit_post_query){
                die("QUERY FAILED" . mysqli_errno($connection));
            }

            header("Location: posts.php");
        }
    }
    else{
        header("Location: error.php?error=nocredential");
    }
}

?>
<h1>Edit Post</h1>
<hr>
<form action="" method="post" enctype="multipart/form-data" name="edit_post_form">
    <div class="form-group">
        <lable class="font-weight-bold" for="cat_title">Post Title</lable>
        <input type="text" class="form-control mt-1" name="post_title" value="<?php echo $post_title; ?>">
    </div>
    <div class="form-group">
        <lable class="font-weight-bold" for="post_category">Post Category</lable>
        <select name="post_category" id="post_category" class="form-control mt-1 col-sm-4">

            <?php
            $select_query = "SELECT * FROM categories";
            $select_categoris_query = mysqli_query($connection, $select_query);
            while($row = mysqli_fetch_assoc($select_categoris_query)){
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='$cat_id'";
                if($cat_id == $post_category_id){
                    echo ' selected';
                }
                echo ">{$cat_title}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <lable class="font-weight-bold" for="post_status">Post Status</lable>
        <select name="post_status" id="post_status" class="form-control mt-1 col-sm-4">
            <option value="<?php echo $post_status; ?>"><?php echo ucfirst($post_status); ?></option>
            <?php
            if($post_status=='published'){
                echo "<option value='draft'>Draft</option>";
            } else{
                echo "<option value='published'>Published</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <img id="post_image" class="post-img-edit" src="../resource/images/<?php echo $post_image; ?>" alt="">

        <lable class="font-weight-bold" for="post_image">Post Image</lable>
        <input type="file" accept="image/*" name="post_image" id="post_image_input" onchange="document.getElementById('post_image').src = window.URL.createObjectURL(this.files[0])">
    </div>
    <div class="form-group">
        <lable class="font-weight-bold" for="post_tags">Post Tags</lable>
        <input type="text" class="form-control mt-1" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    <div class="form-group">
        <lable class="font-weight-bold" for="post_content">Post Content</lable>
        <textarea class="form-control mt-1" name="post_content" id="post_content" cols="30" row="10" style="height:500px;"><?php echo $post_content; ?>
        </textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_post" value="Update Post">
    </div>
</form>

<hr>
<h1>Post Preview</h1>
<hr>
<div id="post_preview" class="post-preview"></div>

<script>
    var images = document.querySelectorAll('.post-preview img');
    images.forEach(function myFunction(item, index) {
        images[index].removeAttribute("width");
        images[index].removeAttribute("height");
    });
</script>

<script src="../js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript" src="../js/tinymce_image_uploader.js"></script>
