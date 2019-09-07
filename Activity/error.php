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
        <?php
        $error_msg = '';
        if(isset($_GET['error'])){
            $error = $_GET['error'];
            switch($error){
                case 'nocredential':
                    $error_msg = 'You doesn\'t have credential to do this task';
                    break;
                default:
                    header("Location: index.php");
                    break;
            }
        }
        ?>
        <div class="center-container">
            <div class="div-box">
                <h1 class="font-weight-bold text-danger text-center"><?php echo "$error_msg";?></h1>
                <a href="index.php" class="btn btn-primary d-flex justify-content-center">Go Home</a>
            </div>
        </div>
    </body>
</html>
