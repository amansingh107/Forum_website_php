<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}


require_once('db.php');
// Add post functionality
if(isset($_POST['create_post'])) {
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $content = $_POST['content'];
    
    $author_id = $_SESSION['user_id'];

    $sql = "SELECT username FROM users WHERE id = '$author_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $author = $row['username'];


    $sql = "INSERT INTO posts (title, summary, content, author) VALUES ('$title', '$summary', '$content', '$author')";
    if(mysqli_query($conn, $sql)) {
        // Refresh the page to show the new post
        header('Location: main_forum.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>


<!-- Logout functionality -->
<?php
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
<nav class="navbar" style=" position: fixed;
        top: 0;
        left: 0;
        width: 100%;"   >
        <div class="max-width">
            <div class="logo"><a href="#" style=" text-decoration: none; ">Forum<span>Page</span></a></div>
            <ul class="menu" style="margin:auto">
                <li><a href="main_forum.php" class="menu-btnn">Go Back</a></li>
           
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
      

<br>


    <h2 style="color:#fff">Create a New Post</h2>
<form method="post" style="width:70%">
  <div class="form-group">
    <label for="title">Title:</label><br>
    <input type="text" class="form-control" name="title" id="title" required><br>
  </div>
  <div class="form-group">
    <label for="summary">Summary:</label><br>
    <textarea class="form-control" name="summary" id="summary" rows="2" required></textarea><br>
  </div>
  <div class="form-group">
    <label for="content">Content:</label><br>
    <textarea class="form-control" name="content" id="content" rows="4" required></textarea><br>
  </div>
  <button  type="submit"  name="create_post"id = "postbtn"class="btn btn-primary" style=" background-color:white; 
  color:green;
  border-radius: 5px;
  border-color: #fff;" >Create Post</button>
</form>

<footer>
        <span style="font-weight:400; font-size:25px">Created By <a href="#" style="color:">Aman Singh</a> | <span class="far fa-copyright"></span> 2023 All rights reserved.</span>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>