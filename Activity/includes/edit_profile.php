<?php
$username = $_SESSION['username'];
$error = [
    'username' => ''
];

$query = "SELECT * FROM users WHERE username = '{$username}'";
$select_user = mysqli_query($connection,$query);

while($row = mysqli_fetch_assoc($select_user)){
    $firstname = $row['user_firstname'];
    $lastname = $row['user_lastname'];
    $image = $row['user_image'];
}

if(empty($image)){
    $image = "user_no_profile.png";
}

if(isset($_POST['edit_profile'])){
    $new_username = $_POST['username'];
    $username = mysqli_real_escape_string($connection, $username);
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $user_image = $_FILES['user_image']['name'];

    if($new_username !== $username){
        if(userNameExists($username)){
            $error['username'] = "This username is already taken";
        }
    }
    else{

        if(empty($user_image)){
            $user_image_name = $image;
        }
        else{
            $temp = explode(".", $_FILES['user_image']['name']);
            $user_image_name = $new_username . "_" . rand(0,100000) . "." . $temp[1];
            $user_image_temp = $_FILES['user_image']['tmp_name'];
            $isUploaded = move_uploaded_file($user_image_temp, "../resource/userimages/$user_image_name");
        }

        $query = "UPDATE users SET ";
        $query .= "username = '{$new_username}', ";
        $query .= "user_firstname = '{$firstname}', ";
        $query .= "user_lastname = '{$lastname}', ";
        $query .= "user_image = '{$user_image_name}' ";
        $query .= "WHERE username = '{$username}'";

        $edit_user_query = mysqli_query($connection,$query);
        confirmQuery($edit_user_query);

        // delete old file when user update file
        if($user_image_name !== $image && $image !== 'user_no_profile.png'){
            $old_image_file = "../resource/userimages/$image";
            unlink($old_image_file);
        }

        header("Location: profile.php");
    }
}
?>


<h1>Edit Profile</h1>
<hr>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <img id="user_image" class="d-block img-fluid rounded-circle img-thumbnail mb-2" src="../resource/userimages/<?php echo $image;?>" alt="">

        <lable class="font-weight-bold" for="user_image">Profile Image</lable>
        <input type="file" accept="image/*" name="user_image" id="user_image_input" onchange="document.getElementById('user_image').src = window.URL.createObjectURL(this.files[0])">
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <lable class="font-weight-bold" for="cat_title">Username</lable>
            <input type="text" class="form-control mt-1" name="username" value="<?php echo $username; ?>">

            <p class='text-danger mb-0 font-weight-bold'><?php echo isset($error['username']) ? $error['username'] : '';?></p>
        </div>
    </div>

    <div class="row">

        <div class="form-group col-md-6">
            <lable class="font-weight-bold" for="firstname">Firstname</lable>
            <input type="text" class="form-control mt-1" name="firstname" value="<?php echo $firstname; ?>">
        </div>
        <div class="form-group col-md-6">
            <lable class="font-weight-bold" for="lastname">Lastname</lable>
            <input type="text" class="form-control mt-1" name="lastname" value="<?php echo $lastname; ?>">
        </div>

    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_profile" value="Update Profile">
    </div>
</form>
