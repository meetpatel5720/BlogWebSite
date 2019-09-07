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
    </head>
    <body>

        <?php include "includes/navigation.php"?>

        <div class="page-container">

            <?php
                if(isset($_GET['source'])){
                    $source = $_GET['source'];
                }
                else{
                    $source = '';
                }
                switch($source){
                    case 'create_post':
                        include "includes/create_post.php";
                        break;
                    case 'edit_post':
                        include "includes/edit_post.php";
                        break;
                    default:
                        include "includes/show_all_post.php";
                        break;
                }
            ?>
        </div>

        <script>
            var posts = document.getElementById("posts");
            posts.className += "active";
        </script>
    </body>
</html>
