<?php include "db.php";?>
<?php session_start(); ?>


<?php
    $_SESSION['user_id'] = null;
    $_SESSION['username'] = null;
    $_SESSION['firstname'] = null;
    $_SESSION['lastname'] = null;

    header("Location: ../index.php");
?>
