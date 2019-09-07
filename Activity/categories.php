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
            <h1>Availabale Categories</h1>
            <hr>

            <?php //add category script
    if(isset($_POST['submit'])){
        $cat_title = $_POST['cat_title'];
        $error_msg ="";

        if($cat_title == "" || empty($cat_title)){
            $error_msg = "This field should not be empty";
        }
        elseif(isCategoryExists($cat_title)){
            $error_msg = "This category is already exists";
        }
        else{
            $query = "INSERT INTO categories(cat_title) ";
            $query .= "VALUE('{$cat_title}')";

            $create_category_query = mysqli_query($connection,$query);
            confirmQuery($create_category_query);
            header("Location: categories.php");
        }
    }
            ?>

            <div class="row">
                <div class="col-sm-6">
                    <!--Add category form-->
                    <form action="" method="post">
                        <div class="form-group">
                            <lable class="font-weight-bold" for="cat_title">Add Category</lable>
                            <input type="text" class="form-control mt-1" name="cat_title">
                        </div>

                        <p class="text-danger mb-3"><?php echo isset($error_msg) ? $error_msg : ""; ?></p>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="submit" value="Add Category">
                        </div>
                    </form>
                </div>


                <!--Categoris table-->
                <div class="col-sm-6">
                    <p class="font-weight-bold mb-1">Available Categories</p>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //show category script
                            $query = "SELECT * FROM categories";
                            $select_catagories = mysqli_query($connection,$query);

                            while($row = mysqli_fetch_assoc($select_catagories)){
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];
                                echo "<tr>";
                                echo "<td>{$cat_id}</td>";
                                echo "<td>{$cat_title}";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            var categories = document.getElementById("categories");
            categories.className += "active";
        </script>
    </body>
</html>
