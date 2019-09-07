<?php session_start(); ?>
<div class="navbar navbar-expand-md header-nav">
    <div>
        <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
    </div>
    <div class="nav-block-right">
        <ul>
            <li><button type="button" class="dropbtn" data-toggle="collapse" data-target="#profile-menu">
                <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
            </li>
        </ul>
    </div>


    <div class="collapse navbar-collapse" id="profile-menu">
        <ul class="profile-menu">
            <?php
            if(!isset($_SESSION['username'])){
                echo "<li><a href='signup.php'>Sign Up</a></li>";
                echo "<li><a href='login.php'>Log In</a></li>";
            }
            else{
                echo "<li><a href='Activity/'><i class='fa fa-fw fa-user'></i> {$_SESSION['username']}</a></li>";
                echo "<li><a href='includes/logout.php'><i class='fa fa-fw fa-power-off'></i> Logout</a></li>";
            }
            ?>
        </ul>
    </div>

</div>
