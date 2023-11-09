<?php session_start() ?>
<?php include "functions.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Website</title>
    <!--Link to CSS-->
    <link rel="stylesheet" href="update.css">
    <!--Box Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <a href="index.php" class="logo">Cars<span>GO</span></a>
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a href="reservation.php">Reservation</a></li>
            <li><a href="records.php">Records</a></li>
        </ul>
        <!-- Drop down menu -->
        <?php
        // Check if user is logged in and retrieve user information
        if (isset($_SESSION['username'])) {
            $mysqli = new mysqli('localhost', 'root', '', 'COMP1044_database');
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM staff WHERE username='$username'";
            $result = $mysqli->query($sql);
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $username = $row['username'];
                $staff_ID = $row['staff_ID'];
                $position = $row['position'];
                $contact_no = $row['contact_no'];
            }
            $mysqli->close();
        }
        ?>
        <div class="header-btn">
          <a href="#" class="profile-btn"><i class="bx bxs-user" onclick="toggleMenu()"></i></a>
        </div>
    </div>
    <div class="sub-menu-wrap" id="subMenu">
      <div class="sub-menu">
        <div class="user-info">
          <img src="user_img/profile.png">
          <?php        
            // Check if user is logged in and retrieve user information
            if (isset($_SESSION['username'])) {
              $mysqli = new mysqli('localhost', 'root', '', 'COMP1044_database');
              $username = $_SESSION['username'];
              $sql = "SELECT * FROM staff WHERE username='$username'";
              $result = $mysqli->query($sql);
              if ($result->num_rows === 1) 
              {
                $row = $result->fetch_assoc();
                $fname = $row['first_name'];
                $lname = $row['last_name'];
                $staff_ID = $row['staff_ID'];
                $position = $row['position'];
                $contact_no = $row['contact_no'];
                echo "<h4>$username</h4>";
                echo "<h6>Name:<span>$fname $lname</span></h6>";
                echo "<h6>Staff ID:<span>$staff_ID</span></h6>";
                echo "<h6>Position:<span>$position</span></h6>";
                echo "<h6>Contact No: <span>$contact_no</span></h6>";
              }
            $mysqli->close();
          ?>
          <hr>
          <form action="logout.php" method="post">
            <button type="submit" class="sub-menu-link" name="logout">
            <img src="user_img/logout.png">
            <p>Logout</p>
            <span> > </span>
            </button>
          </form>
          <?php
            } else {
              // User is not logged in, display default text
              echo '<a href="login.php" class="login-link"><h5>Login</h5></a>';
            }
          ?>
        </div>
      </div>
    </div>
    </header>
    <!-- Main page -->
    <section class="main" id="main">
      <div class="heading">
        <span>How It Works</span>
          <h1>Select Your Course of Actions</h1>
      </div>
      <div class="main-container">
        <a href="reservation.php">
          <div class="box">
            <i class="bx bxs-car"></i>
              <h2>Make New Reservation</h2>
          </div>
        </a>
        <a href="update.php" id="open-popup-btn-change">  
          <div class="box">
            <i class="bx bxs-calendar-check"></i>
            <h2>Change/Update Reservation</h2>
          </div>
        </a>
        <a href="delete.php" id="open-popup-btn">
          <div class="box">
            <i class="bx bxs-calendar-star"></i>
            <h2>Cancel Reservation</h2>
          </div>
        </a>
      </div>
    </section>
    <!-- Update Form -->
    <div class="popup-delete center">
  <div class="close-icon"><a href="index.php">&#x2715;</a></div>
  <h2>Cars<span>GO</span></h2>
  <div class="title">
    Enter Your Reservation ID (Update)
    <form method="post" action="">
      <input type="number" name="reservation-id"></input>
      <input id="open-description-btn" type="submit" name="submit-update" value="Search"></input>
    </form>
  </div>
  <div class="description">
    <?php
    //starting the connection
    $reservation_date = $SESSION['reservation_date'] = date("Y-m-d");
    $conn = connect($reservation_date);
    //if user clicked on the 'search' button
    if(isset($_POST['submit-update'])) 
    {
      //if user entered something in the search box
      if (!empty($_POST['reservation-id'])) {
        $id = $_SESSION['id'] = $_POST['reservation-id'];
        $reservations = getReservation($conn, $id);
        //if reservation ID exists, retrieve and display its details
        if ($reservations != FALSE) {
        foreach($reservations as $reservation) {
          $_SESSION['current_booked_date'] = $reservation['pick_up_date'];
          $_SESSION['current_return_date'] = $reservation['return_date'];
    ?>
    
    <form method="post" action="update.php" onsubmit="return validateDate(this)">
      <input type="hidden" name="reservation-id" value="<?php echo $reservation['reservation_ID']?>"></input>
          <div class="description-inner">
            <h3>Reservation ID</h3>
            <p><?php echo $reservation['reservation_ID']?></p>
          </div>
          <div class="description-inner">
            <h3>Vehicle</h3>
            <p><?php echo $reservation['vehicle_ID']?></p>
          </div>
          <div class="description-inner">
            <h3>Pickup Location</h3>
            <p><?php echo $reservation['pick_up_location']?></p>
          </div>
          <div class="description-inner">
            <h3>Pickup Date</h3>
            <p><?php echo $reservation['pick_up_date']?></p>
          </div>
          <div class="description-inner"> 
            <h3>Dropoff Date</h3>
            <p><?php echo $reservation['return_date']?></p>
          </div>
          <div class="description-inner">
            <h3>Update Pickup Date</h3>
            <input type="date" name="booked_date" value="<?php echo $reservation['pick_up_date']?>"></input>
          </div>
            <div class="description-inner">
              <h3>Update Dropoff Date</h3>
              <input type="date" name="return_date" value="<?php echo $reservation['return_date']?>"></input>
            </div>
            <div class="dismiss-btn">
              <button id="dismiss-popup-btn" type="submit" name="update-button">
                Update
              </button>
            </div>
          </form>
    <?php }
        }
      } else { //if reservation does not exist

        echo '<p class="success-message">Reservation does not exist. Please input a valid ID.</p>';
        $reservations = FALSE;
  
      }
    }
    ?>
    </div>
    <?php
      // when user clicks on 'update' button
      if(isset($_POST['update-button'])) 
      {
        $id = $_POST['reservation-id'];
        $reservations = getReservation($conn, $id);
        if ($reservations != FALSE)
        {
            foreach($reservations as $reservation){
              $car_id = $reservation['vehicle_ID'];
              $pickup_date = $_SESSION['pickup_date'] = $_POST['booked_date'];
              $dropoff_date = $_SESSION['dropoff_date'] = $_POST['return_date'];
            }
            //Check availability of cars and update
            checkAvailability($conn, $pickup_date, $dropoff_date, $car_id, $id);
        }
      }
          $conn->close(); //closing the connection
    ?>
  </div>
    <!-- Footer -->
    <footer>
        <a href="#top">Cars<span>GO</span></a>
        <p>Copyright All rights reserved. Powered by group 8</p>
    </footer>
    <!-- ScollReveal -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <!-- Link to JS -->
    <script src="script2.js"></script>
</body>
</html>