<?php
if(isset($_POST['create_post'])){
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category'];
    $post_user_id = $_SESSION['user_id'];
    $post_status = $_POST['post_status'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_content = mysqli_real_escape_string($connection, $post_content);

    $post_image = $_FILES['post_image']['name'];

    if(!empty($post_image)){
        $temp = explode(".", $_FILES['post_image']["name"]);
        $post_image_name = $temp[0] . "_" . rand(0,100000) . "." . $temp[1];

        $post_image_temp = $_FILES['post_image']['tmp_name'];

        move_uploaded_file($post_image_temp, "../resource/images/$post_image_name");
    }
    else{
        $post_image_name = "";
    }

    $query = "INSERT INTO posts(post_title,post_category_id,post_user_id,post_status,post_image,post_tags,post_content,post_date) ";

    $query .= "VALUES('{$post_title}',{$post_category_id},{$post_user_id},'{$post_status}','{$post_image_name}','{$post_tags}','{$post_content}',now())";

    $post_insert_query = mysqli_query($connection, $query);

    if(!$post_insert_query){
        die('QUERY FAILED' . mysqli_error($connection));
    }

    header("Location: posts.php");
}
?>
<h1>Create Post</h1>
<hr>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <lable class="font-weight-bold" for="post_title">Post Title</lable>
        <input type="text" class="form-control mt-1" name="post_title">
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
                echo "<option value='$cat_id'>{$cat_title}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <lable class="font-weight-bold" for="post_status">Post Status</lable>
        <!--        <input type="text" class="form-control mt-1" name="post_status">-->
        <select name="post_status" id="post_status" class="form-control mt-1 col-sm-4">
            <option value="published">Publised</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    <div class="form-group">
        <img id="post_image" class="post-img-edit" src="" alt="">

        <lable class="font-weight-bold" for="post_image">Post Image</lable>
        <input type="file" accept="image/*" name="post_image" accept="image/*" onchange="document.getElementById('post_image').src = window.URL.createObjectURL(this.files[0])">
    </div>

    <div class="form-group">
        <lable class="font-weight-bold" for="post_tags">Post Tags</lable>
        <input type="text" class="form-control mt-1" name="post_tags">
    </div>

    <div class="form-group">
        <lable class="font-weight-bold" for="post_content">Post Content</lable>
        <textarea class="form-control mt-1" name="post_content" id="post_content" cols="30" row="10" style="height:500px;"></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>

</form>

<hr>
<h1>Post Preview</h1>
<hr>
<div id="post_preview" class="post-preview"></div>

<script>
    var images = document.querySelectorAll('.post-preview img');
    images.forEach(function myFunction(item, index) {
        console.log("..");
        images[index].removeAttribute("width");
        images[index].removeAttribute("height");
    });
</script>

<script src="../js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript" src="../js/tinymce_image_uploader.js"></script>
