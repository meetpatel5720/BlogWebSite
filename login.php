<?php include "includes/db.php";?>
<?php include "includes/functions.php";?>
<?php session_start(); ?>

<?php
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $error = [
        'username' => '',
        'password' => ''
    ];

    $query = "SELECT * FROM users WHERE username = '{$username}'";

    $get_user_query = mysqli_query($connection,$query);
    if(mysqli_num_rows($get_user_query) != 0){
        while($row = mysqli_fetch_assoc($get_user_query)){
            $db_id = $row['user_id'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
        }

        if($username === $db_username && password_verify($password,$db_user_password)){
            $_SESSION['user_id'] = $db_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;

            header("Location: index.php");
        }
        else{
            $error['password'] = "Inccorrect username or password</p>";
        }
    }
    else{
        $error['username'] = "No information found for this user";
    }

}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login </title>
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
                <h1 class="text-center mb-4">Account Login</h1>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <lable class="font-weight-bold" for="username">Username</lable>
                        <input type="text" name="username" class="form-control mt-1" required placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '';?>">

                        <p class='text-danger text-center mb-2 font-weight-bold'><?php echo isset($error['username']) ? $error['username'] : '';?></p>

                    </div>
                    <div class="form-group">
                        <lable class="font-weight-bold" for="username">Password</lable>
                        <input type="password" name="password" class="form-control mt-1" required placeholder="Password">

                        <p class='text-danger text-center mb-2 font-weight-bold'><?php echo isset($error['password']) ? $error['password'] : '';?></p>
                    </div>

                    <button type="submit" class="btn btn-primary mx-auto mybtn" name="login">Login</button>
                </form>
                <div class="text-center mt-2">
                    <span>Create an account? <a href="signup.php">Sign up</a></span>
                </div>
            </div>
        </div>
    </body>
</html>
