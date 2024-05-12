<?php 

require_once("db.php");
// Check if user is already logged in
if(isset($_SESSION['user_id'])) {
    header('Location: main_forum.php');
    exit;
}

if(isset($_POST['register'])) {
  $name = $_POST['name'];
  $username = $_POST['new_username'];
  $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

  // Check if username already exists
  $check_username_sql = "SELECT * FROM users WHERE username = '$username'";
  $check_username_result = mysqli_query($conn, $check_username_sql);

  if(mysqli_num_rows($check_username_result) > 0) {
      $signup_error = "Username already exists";
  } else {
      // Insert new user
      $sql = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$password')";
      if(mysqli_query($conn, $sql)) {
          header('Location: index.php');
          exit;
      } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Form</title>
  <link rel="stylesheet" href="styles.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="wrapper">
    <form action="" method="post">
      <h1>Signup</h1>
      <?php if(isset($signup_error)): ?>
      <div class="error-message" style="color:red; width:100%; margin-left:65px; justify-content:center; font-weight:1000"><?php echo $signup_error; ?></div>
      <?php endif; ?>
      <div class="input-box">
        <input type="text" name="name" id="name" placeholder="Your Name" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="text" name="new_username" id="new_username" placeholder="Username" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="new_password" id="new_password" placeholder="Password" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <button type="submit" name="register" class="btn">Signup</button>
      <div class="register-link">
        <p>Already Have an account? <a href="index.php">Login</a></p>
      </div> 
    </form>
  </div>
</body>
</html>
