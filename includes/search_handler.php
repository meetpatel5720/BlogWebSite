<?php ob_start(); ?>
<?php include "db.php";?>
<?php include "functions.php";?>
<?php
// like function
if(isset($_POST['search_key'])){
    $keyword = $_POST['search_key'];

    $query = "SELECT categories.cat_id,categories.cat_title, COUNT(*) as post_count FROM categories LEFT JOIN posts ON categories.cat_id = posts.post_category_id WHERE cat_title like '%$keyword%'GROUP BY posts.post_category_id ORDER BY post_count DESC LIMIT 0,6";

    $result = mysqli_query($connection,$query);

    if(mysqli_num_rows($result)>0){
        $output = '<ul class="mt-3">';

        while($row = mysqli_fetch_assoc($result)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
            $output .= "<li><a href='category.php?category_id=$cat_id'>{$cat_title}</a></li>";
        }

        $output .= '</ul>';
        echo $output;
    }
    else{
        echo "<h3 class='mt-3'>No result found</h3>";
    }
    exit();
}
?>
