<!--
* @file thread_list.php
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

    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE `category_id` = '$id'";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        // insert into thread DB

        $sno = $_POST['sno'];
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];

        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title);

        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc);

        $sql = "INSERT INTO `thread` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;

        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Congratulations!</strong> Your thread has been added ! Please wait for community to respond
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <div class="container my-4">
        <div class="mt-4 p-5 bg-dark text-secondary rounded">
            <h1 class="mb-3 text-success">Welcome to <?php echo $catname; ?> Forums</h1>
            <h5 class="text-success"><?php echo $catdesc; ?></h5>
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

            <button class="btn btn-success text-dark mt-3">Learn More</button>
        </div>
    </div>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '
    <div class="container">
        <h1>Start a Discussion</h1>
        <form action=" ' . $_SERVER["REQUEST_URI"] . ' " method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="titleHelp">
                <div id="titleHelp" class="form-text">Keep your title as short and crisp as possible</div>
            </div>
            <input type="hidden" name="sno" value=" ' . $_SESSION["sno"] . ' ">
            <label for="floatingTextarea2">Ellaborate Your Concern</label>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="desc" name="desc" style="height: 100px"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    } else {
        echo '
        <div class="container my-4">
        <h1>Start a Discussion</h1>
        <div class="mt-4 p-5 bg-dark text-secondary rounded">
            <h1 class="mb-3 text-warning">You are not Logged in!</h1>
            <h5 class="text-light opacity-75">Please login to be able to start a Discussion</h5>
        </div>
        </div>';
    }
    ?>

    <div class="container" id="ques">
        <h1 class="py-3">Browse Questions</h1>
        <?php

        $id = $_GET['catid'];
        $sql = "SELECT * FROM `thread` WHERE `thread_cat_id` = $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;

        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT `user_name` FROM `users` WHERE sno = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo ' 
        <div class="d-flex my-4">
            <div class="flex-shrink-0">
                <img src="images/user.png" width="54px" alt="...">
            </div>
            <div class="flex-grow-1 ms-3">
                <h5 class="mt-0"><a href="/learnPHP/projects/forum/thread.php?threadid=' . $id . '" class = "text-danger text-decoration-none">' . $title . '</a></h5>
                <p class = "mb-0 mt-0">' . $desc . '</p>
                <p class = "mb-0 mt-0"><b>Asked by: ' . $row2['user_name'] . ' at ' . $thread_time . '</b></p>
            </div>
        </div> ';
        }

        if ($noResult) {
            echo ' <div class="container my-4">
            <div class="mt-4 p-5 bg-dark text-secondary rounded">
                <h1 class="mb-3 text-success">No Questions yet!</h1>
                <h5 class="text-light opacity-75">Be the First person to ask a Question</h5>
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