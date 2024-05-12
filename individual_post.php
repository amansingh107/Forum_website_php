<?php
session_start();
// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once("db.php");

// Fetch post details from database
if(isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = '$post_id'";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);

    // Fetch comments for this post
    $sql = "SELECT * FROM comments WHERE post_id = '$post_id'";
    $result = mysqli_query($conn, $sql);
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    header('Location: main_forum.php');
    exit;
}

// Add comment functionality
if(isset($_POST['comment'])) {
    $comment = $_POST['comment_text'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO comments (post_id, user_id, comment) VALUES ('$post_id', '$user_id', '$comment')";
    if(mysqli_query($conn, $sql)) {
        // Redirect to avoid form resubmission on refresh
        header("Location: individual_post.php?id=$post_id");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Logout functionality
if(isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Website</title>
    <link rel="stylesheet" href="style2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<style>
.menu li a {
  text-decoration: none; /* Remove underline from anchor tags within list items */
}

@media screen and (max-width: 800px) {
              .navbar {
                display: none;
            }
                .menu-btn {
                    display: block; /* Show the menu button for smaller devices */
                }
    
                .wrapper {
                    display: block; /* Show the wrapper for smaller devices */
                }
    
                .content {
                    display: block; /* Show the content for smaller devices */
                    text-align: center;
                    color: #fff;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    z-index: 9999;
                }
            }

</style>
</head>
<body>
    <nav class="navbar" style="position:fixed;">
        <div class="max-width">
            <div class="logo" ><a  style="text-decoration: none; "href="#">Forum<span>Page</span></a></div>
            <ul class="menu" style="margin:auto;">
                <li><a href="main_forum.php" class="menu-btnn">Go Back</a></li>
               
                <li><a href="create_post.php" class="menu-btnn">Create Forum</a></li>
                <li><form method="post">
  <button style="
    width:90px;
    height:40px;
    border-radius:10px;
    margin-left:10px;
    background-color:  #3ded11; /* Optional: Change background color */
    color: #ffffff; /* Optional: Change text color */
    border: none; /* Optional: Remove border */
    cursor: pointer; /* Optional: Change cursor on hover */
    " class="form-logout" type="submit" name="logout">Logout</button>
</form>
</li>
            </ul>
        </div>
    </nav>




    <input type="checkbox" id="active">
      <label for="active" class="menu-btn"><i class="fas fa-bars"></i></label>
      <div class="wrapper">
      <ul>
                <li><a href="main_forum.php">Go Back</a></li>
                <li><a href="create_post.php">Create</a></li>
                <li><form method="post">
  <button style="
    width:90px;
    height:40px;
    border-radius:10px;
    margin-left:10px;
    background-color:  #3ded11; /* Optional: Change background color */
    color: #ffffff; /* Optional: Change text color */
    border: none; /* Optional: Remove border */
    cursor: pointer; /* Optional: Change cursor on hover */
    type="submit" name="logout">Logout</button>
</form>
</li>
      </ul>
      </div>
      


<main>
    <article>
       <h1 stule="margin:0px;"><?= $post['title'] ?></h1>
      <h2 style="margin-top:20px; font-size:30px;"><?= $post['summary'] ?> </h2>
      <p class="meta" style="font-size: 25px">Posted </span> by <span class="author"><?= $post['author'] ?></</span></p>
      <p style="font-size:20px; font-weight: 400;"><?= $post['content'] ?></p>
      <!-- Additional paragraphs and content go here -->
    </article>
  </main>





 
 

<!-- 
  Comment box start -->
  <div class="row d-flex justify-content-center" id="comments" style="width:100%; left:0; ">
  <div class="col-md-8 col-lg-6" style="width:100%; margin:auto; ">
    <div class="card shadow-0 border" style="margin:auto;">
      <div class="card-body p-4" style=" background:  #6527BE; justify-content:center;">
        <div data-mdb-input-init class="form-outline mb-4" style="font-family: Quicksand, sans-serif;  font-weight:200;">
        <form method="post">
          <input  style="width:90%; margin:auto;"type="text" id="addANote" class="form-control" name="comment_text" placeholder="Type comment..." />
          <input style="margin-left:70px;"class="comment_input" type="submit" name="comment" value="Comment">
          </form>
        </div>
        <h2 style="font-family: Quicksand, sans-serif;  font-weight:800; color:#fff; padding-left:70px;">Recent Comments</h2>
        <?php foreach($comments as $comment): ?>
        <div class="card mb-4" style="font-family: Quicksand, sans-serif;  font-weight:800; margin:auto;">
          <div class="card-body">
            <p ><?= $comment['comment'] ?></p>
            <?php
        // Fetch username based on user_id
        $comment_user_id = $comment['user_id'];
        $sql = "SELECT username FROM users WHERE id = '$comment_user_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $comment_username = $row['username'];
        ?>

            <div class="d-flex justify-content-between">
              <div class="d-flex flex-row align-items-center">
                <img src="human-image.png" alt="avatar" width="25"
                  height="25" style="border-radius:50%;" />
                <p class="small mb-0 ms-2"><?= $comment_username ?></p>
              </div>
              <div class="d-flex flex-row align-items-center">
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        

        

      </div>
    </div>
  </div>
</div>

 

<br>
<br>

 



    <footer>
        <span style="font-weight:400; font-size:25px">Created By <a href="#" style="color:">Aman Singh</a> | <span class="far fa-copyright"></span> 2023 All rights reserved.</span>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>














