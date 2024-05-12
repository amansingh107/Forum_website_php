<?php
session_start();

// Check if user is not logged in
if(!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once("db.php");

// Fetch posts from database
$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script> -->

</head>
<body>
    <nav class="navbar" >
        <div class="max-width">
            <div class="logo" ><a  style="text-decoration: none; "href="#">Forum<span>Page</span></a></div>
            <ul class="menu" style="margin:auto;" >
                <li><a href="#home" class="menu-btnn">Home</a></li>
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
                <li><a href="#home">Home</a></li>
                <li><a href="create_post.php">Create Forum</a></li>
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
      




 <!-- home section start -->
 <section style="background: url(bg_imag6.avif) no-repeat center;"class="home" id="home">
        <div class="max-width">
            <div class="home-content">
                <div class="text-1" style="color: #fff;">Welcome to My <span class="text-2">Forum</span></div>
                <div class="text-3" style="color: #fff;">Get Latest Updates Here</span></div>
            </div>
        </div>
</section>




<div class="title" >Main Forum</div>
<div class="container"   style="  width:70%;">
<?php foreach($posts as $post): ?>
  <div class="card" style=" margin:50px auto; ">
    <div class="card__header">
    </div>
    <div class="card__body">
      <h3>Title: <?= $post['title'] ?></h3>
      <h4><?= $post['summary'] ?></h4>
    </div>
    <div class="card__footer">
      <div class="user">
        <img   style="  width:80px;
  height: 80px;"src="human-image.png" alt="user__image" class="user__image">
        <div class="user__info">
          <h3 style="margin-top:20px">Author: <?= $post['author'] ?></h3>
          <large><a style="color:#3ded11; font-weight:1000;" href="individual_post.php?id=<?= $post['id'] ?>">View Full Post</a></large>
        </div>
    </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<footer>
        <span>Created By <a href="#">Aman Singh</a> | <span class="far fa-copyright"></span> 2024 All rights reserved.</span>
    </footer>

</body>
</html>
