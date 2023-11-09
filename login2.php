<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="login.css">
    <!-- I might not need this -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
  <img src="LoginIMG/loginbackground.jpg" class="backgroundimg">
  <!-- Login Form -->
    <div class="container">
      <form action="login.php" method="post">
        <div class="title">Login</div>
        <div class="input-box underline">
          <input type="text" name="username" placeholder="Enter Your Username" required>
          <div class="underline"></div>
        </div>
        <div class="input-box">
          <input type="password" name="password" placeholder="Enter Your Password" required>
          <div class="underline"></div>
        </div>
        <label style="color:red">Invalid username or password</label>
        <div class="input-box button">
          <input type="submit" name="Submit" value="Continue">
        </div>
      </form>
    </div>

    <?php
    // Create connection
    $conn = new mysqli("localhost", "root", "", "COMP1044_database");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Getting username and password
    if (isset($_POST['Submit'])) 
    {

      $uname = $_POST['username'];
      $pass = $_POST['password'];

      $sql = "SELECT * FROM staff WHERE username ='$uname' AND password ='$pass'";
    
        $result = $conn->query($sql);
        //if user inputs correctly
        if ($result->num_rows === 1) 
        {
          $row = $result->fetch_assoc();
          if ($row['username'] === $uname && $row['password'] === $pass) 
          {
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
            exit();
          }
          else //when user inputs incorrectly
          {
            header("Location: login2.php?error=Incorect User name or password");
            exit();
          }
        }
        else //when user inputs incorrectly
        {
          header("Location: login2.php?error=Incorect User name or password");
          exit();
        }
      
      }
    $conn->close(); //closing the connection
    ?>
    <script src="script2.js"></script>
  </body>
</html>


