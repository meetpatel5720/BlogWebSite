<?php ob_start(); ?>
<?php session_start();?>
<?php include "../includes/functions.php";?>

<?php
    if(!isset($_SESSION['username'])){
        header("Location: ../index.php");
    }
?>
