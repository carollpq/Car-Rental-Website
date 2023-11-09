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
    <link rel="stylesheet" href="records.css">
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
                    if ($result->num_rows === 1) {
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
    
    <section class="main" id="main">
        <div class="heading">
            <h2>Reservations Log</h2>
        </div>
        <div class="main-container">
            <table>
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>Reservation ID</th>
                        <th>Reservation Date</th>
                        <th>Pick Up Date</th>
                        <th>Return Date</th>
                        <th>Pick Up Location</th>
                        <th>Vehicle ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //starting the connection
                    $reservation_date = $SESSION['reservation_date'] = date("Y-m-d");
                    $conn = connect($reservation_date);
                    //getting the details for Records page
                    $sql = "SELECT * FROM reservation ORDER BY reservation_date";
                    $reservations = $conn->query($sql);
                    if (mysqli_num_rows($reservations) > 0)
                    {
                        while($row2 = $reservations->fetch_assoc()){
                            $rows[] = $row2;
                        }
                        
                        foreach($rows as $row) {
                        
                        $reservation_id = $row['reservation_ID'];
                        $res_date = $row['reservation_date'];
                        $pick_up = $row['pick_up_date'];
                        $return = $row['return_date'];
                        $location = $row['pick_up_location'];
                        $car_id = $row['vehicle_ID'];
                        $cust_id = $row['customer_ID'];
                            
                        $customers = $conn->query("SELECT first_name, last_name FROM customer WHERE customer_ID = $cust_id");
                        if ($customers->num_rows === 1) {
                            $cust = $customers->fetch_assoc();
                            $f_name = $cust['first_name'];
                            $l_name = $cust['last_name'];
                        }  
                        ?>
                        <tr>
                            <td><?php echo $cust_id ?></td>
                            <td><?php echo $f_name . " " . $l_name ?></td>
                            <td><?php echo $reservation_id ?></td>
                            <td><?php echo $res_date ?></td>
                            <td><?php echo $pick_up ?></td>
                            <td><?php echo $return ?></td>
                            <td><?php echo $location?></td>
                            <td><?php echo $car_id ?></td>
                        </tr>
                        
                </tbody>
                <?php }   
                    } else
                        {
                        echo '<p class="success-message" style="padding-left: 590px;">No Records Shown.</p>';
                    }
                    $conn->close();
                    ?>
            </table>
        </div>
    </section>
    <footer>
        <a href="#top">Cars<span>GO</span></a>
        <p>Copyright All rights reserved. Powered by group 8</p>
    </footer>
    <!-- Link to JS -->
    <script src="script2.js"></script>
</body>
</html>