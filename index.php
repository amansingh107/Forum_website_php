<?php

require_once("db.php");
// Check if user is already logged in
if(isset($_SESSION['user_id'])) {
    header('Location: main_forum.php');
    exit;
}

// Check if login form is submitted
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate login
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: main_forum.php');
            exit;
        }
    }

    // Display error message if credentials are invalid
    $login_error = "Invalid username or password";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="styles.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="wrapper">
    <form action="" method="post">
      <h1>Login</h1>
      <?php if(isset($login_error)): ?>
      <div class="error-message" style="color:red; width:100%; margin-left:35px; justify-content:center; font-weight:1000"><?php echo $login_error; ?></div>
      <?php endif; ?>
      <div class="input-box">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <button type="submit" name="login" class="btn">Login</button>
     
      <div class="register-link">
        <p>Don't have an account? <a href="signup.php">Register</a></p>
      </div>
    </form>
  </div>
</body>
</html>
