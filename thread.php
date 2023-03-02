<!--
* @file thread.php
* @author KUSHAGRA JAISWAL 
* @date 2022-06-24
* @copyright Copyright (c) 2022
-->

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        #ques {
            min-height: 35vh;
        }
    </style>
    <title>Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
    <?php
    include 'partials/_dbconnect.php';
    include 'partials/header.php';

    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `thread` WHERE `thread_id` = '$id'";
    $result = mysqli_query($conn, $sql);
    $noResult = true;

    while ($row = mysqli_fetch_assoc($result)) {
        $noResult = false;
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $commented_by = $row['thread_user_id'];

        // Query the users table to get the name of the user who posted the thread.
        $sql2 = "SELECT `user_name` FROM `users` WHERE sno = '$commented_by'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_name'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {

        // insert into comments DB
        $comment = $_POST['comment'];
        $comment = str_replace("<", "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment);
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `current_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;

        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Congratulations!</strong> Your Comment has been added !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <div class="container my-4">
        <div class="mt-4 p-5 bg-dark text-secondary rounded">
            <h1 class="mb-3 text-danger"> <?php echo $title; ?> </h1>
            <h5 class="text-warning opacity-75"><?php echo $desc; ?></h5>
            <hr>
            <p>This is a peer to peer Forum for sharing knowledge with eachother.</p>
            <ul></ul>
            <li> No Spam / Advertising / Self-promote in the forums. ...</li>
            <li> Do not post copyright-infringing material. ...</li>
            <li> Do not post “offensive” posts, links or images. ...</li>
            <li>Do not cross post questions. ...</li>
            <li> Do not PM users asking for help. ...</li>
            <li>Remain respectful of other members at all times.</li>
            </ul>
            <h5 class="text-seconary mt-4">Posted by: <b class="text-success"><?php echo $posted_by; ?></b></h5>
        </div>
    </div>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '
    <div class="container">
    <h1>Post a Comment</h1>
    <form action=" ' . $_SERVER["REQUEST_URI"] . ' " method="POST">
        <label for="floatingTextarea2">Type your comment</label>
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="comment" name="comment" style="height: 100px"></textarea>
            <input type="hidden" name="sno" value=" ' . $_SESSION["sno"] . ' ">
            </div>
        <button type="submit" class="btn btn-success mt-3">Post Comment</button>
    </form>
</div>';
    } else {
        echo '
        <div class="container my-4">
        <h1>Post a Comment</h1>
        <div class="mt-4 p-5 bg-dark text-secondary rounded">
            <h1 class="mb-3 text-warning">You are not Logged in!</h1>
            <h5 class="text-light opacity-75">Please login to be able to post comments.</h5>
        </div>
        </div>';
    }
    ?>

    <div class="container" id="ques">
        <h1 class="py-3">Discussions</h1>
        <?php

        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE `thread_id` = $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;

        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['current_time'];
            $thread_user_id = $row['comment_by'];
            $sql2 = "SELECT `user_name` FROM `users` WHERE sno = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo ' 
        <div class="d-flex my-4">
            <div class="flex-shrink-0">
                <img src="images/user.png" width="54px" alt="...">
            </div>
            <div class="flex-grow-1 ms-3">
            <h5 class="mt-0  font-weight-bold my-0"><a href="/learnPHP/projects/forum/thread.php" class = "text-dark text-decoration-none">' . $row2['user_name'] . ' at : ' . $comment_time . '</a></h5> 
            <p>' . $content . '</p>
            </div>
        </div> ';
        }

        if ($noResult) {
            echo ' <div class="container my-4">
            <div class="mt-4 p-5 bg-dark text-secondary rounded">
                <h1 class="mb-3 text-success">No Comments yet!</h1>
                <h5 class="text-light opacity-75">Be the First person to Post a comment</h5>
            </div>
            </div>';
        }



        ?>
    </div>

    <?php include 'partials/footer.php'; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>