<?php include "includes/db.php";?>
<?php include "includes/functions.php";?>
<?php session_start(); ?>

<?php
if(isset($_POST['signup'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);
    $email = mysqli_real_escape_string($connection, $email);

    $error = [
        'username' => '',
        'email' => '',
        'password' => ''
    ];


    if(strlen($username)< 6){
        $error['username'] = "Username must be more than 6 characater";
    }
    elseif(userNameExists($username)){
        $error['username'] = "This username is already taken";
    }
    elseif(emailExists($email)){
        $error['email'] = "You already have an account on this email, try login using that";
    }
    elseif(strlen($password)< 8){
        $error['password'] = "Password must be more than 8 characater";
    }
    else{

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

        $query = "INSERT INTO users(username,user_email,user_password,user_firstname,user_lastname) VALUES('{$username}','{$email}','{$password}','{$firstname}','{$lastname}')";

        $create_user_query = mysqli_query($connection, $query);

        if($create_user_query){
            // get user id for setting session after signup
            $query = "SELECT * FROM users WHERE username = '{$username}'";
            $get_user_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($get_user_query)){
                $_SESSION['user_id'] = $row['user_id'];
            }
            $_SESSION['username'] = $username;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            header("Location: Activity/");
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create an account</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link rel="stylesheet" href="css/block_style.css">
        <link rel="stylesheet" href="css/common_style.css">

        <style>
            body{
                background-color: #333;
            }
        </style>
    </head>
    <body>
        <div class="center-container">
            <div class="div-box">
                <h1 class="text-center mb-4">Create account</h1>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <lable class="font-weight-bold" for="username">Username</lable>
                        <input type="text" name="username" class="form-control mt-1" required placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '';?>">

                        <p class='text-danger text-center mb-2 font-weight-bold'><?php echo isset($error['username']) ? $error['username'] : '';?></p>

                    </div>
                    <div class="row">

                        <div class="form-group col-sm-6">
                            <lable class="font-weight-bold" for="firstname">First name</lable>
                            <input type="text" name="firstname" class="form-control mt-1" required placeholder="First name" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '';?>">
                        </div>
                        <div class="form-group col-sm-6">
                            <lable class="font-weight-bold" for="lastname">Last name</lable>
                            <input type="text" name="lastname" class="form-control mt-1" required placeholder="Last name" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '';?>">

                        </div>
                    </div>
                    <div class="form-group">
                        <lable class="font-weight-bold" for="email">Email</lable>
                        <input type="text" name="email" class="form-control mt-1" required placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '';?>">

                        <p class='text-danger text-center mb-2 font-weight-bold'><?php echo isset($error['email']) ? $error['email'] : '';?></p>
                    </div>
                    <div class="form-group">
                        <lable class="font-weight-bold" for="username">Password</lable>
                        <input type="password" name="password" class="form-control mt-1" required placeholder="Password">

                        <p class='text-danger text-center mb-2 font-weight-bold'><?php echo isset($error['password']) ? $error['password'] : '';?></p>

                    </div>

                    <button type="submit" class="btn btn-primary mx-auto mybtn" name="signup">Sign up</button>
                </form>
                <div class="text-center mt-2">
                    <span>Already have an account? <a href="login.php">Log in</a></span>
                </div>
            </div>
        </div>
    </body>
</html>
