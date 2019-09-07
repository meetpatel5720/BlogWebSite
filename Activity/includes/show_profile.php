<?php
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection,$query);
    confirmQuery($result);
    while($row = mysqli_fetch_assoc($result)){
        $firstname = $row['user_firstname'];
        $lastname = $row['user_lastname'];
        $email = $row['user_email'];
        $image = $row['user_image'];
    }
    if(empty($image)){
        $image = "user_no_profile.png";
    }
}
?>


<h1>Personal Details</h1>
<hr>

<div class="row">
    <div class="col-sm-3 col-md-3 col-lg-2">
        <img class="img-fluid rounded-circle img-thumbnail" src="../resource/userimages/<?php echo $image;?>" alt="">
    </div>
    <div class="col-sm-9 col-md-9 col-lg-10 align-self-center">
        <h3 class="mb-0"><?php echo $firstname . " " .$lastname;?></h3>
        <h4 class="text-primary mb-0"><small>@ <?php echo $username;?></small></h4>
    </div>
</div>

<h4><p class="mt-4"><strong>Email: </strong><?php echo $email;?></p></h4>

<a href="profile.php?source=edit_profile" class="btn btn-primary" name="edit_profile">Edit Profile</a>
