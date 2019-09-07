<div class="navbar navbar-expand-md header-nav">
    <div class="menu-left">
        <button type="button" class="dropbtn" data-toggle="collapse" data-target="#side-nav-menu">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <a href="index.php">Activity</a>
    </div>

    <div class="nav-block-right">
        <ul>
            <li><a href="../index.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
            <li>
                <a data-toggle="collapse" href="#pofile-menu" role="button" aria-expanded="false" aria-controls="profile-menu"><i class="fa fa-user" aria-hidden="true"></i><span> <?php echo $_SESSION['username']; ?> </span><i class="fa fa-caret-down" aria-hidden="true"></i></a>

                <div class="collapse dropmenu" id="pofile-menu">
                    <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </div>
            </li>
        </ul>
    </div>


    <div class="collapse navbar-collapse" id="side-nav-menu">
        <ul class="side-nav">
            <li>
                <a href="index.php" id="dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>
            </li>

            <li>
                <a id="posts" data-toggle="collapse" href="#posts_dropdown" role="button" aria-expanded="false" aria-controls="posts_dropdown"><i class="fa fa-file-text"></i> Posts <i class="fa fa-caret-down"></i></a>

                <ul class="collapse" id="posts_dropdown">
                    <li>
                        <a href="posts.php">View All Posts</a>
                    </li>
                    <li>
                        <a href="posts.php?source=create_post">Add Post</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="categories.php" id="categories"><i class="fa fa-list" aria-hidden="true"></i> Categories</a>
            </li>

            <li>
                <a href="comments.php" id="comments"><i class="fa fa-comments" aria-hidden="true"></i> Comments</a>
            </li>


            <li>
                <a href="profile.php" id="profile"><i class="fa fa-user" aria-hidden="true"></i> Personal Details</a>
            </li>

        </ul>
    </div>
</div>
