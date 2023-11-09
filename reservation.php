<?php session_start() ?>
<?php include "functions.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarsGO reservation page</title>
    <!--Link to CSS-->
    <link rel="stylesheet" href="reservation.css">
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
    <!-- Reservation -->
    <section class="services" id="services">
        <div class="heading-2">
            <span>Make A Reservation</span>
            <h1>Choose Your Car</h1>
        </div>
        <!-- Filter, pickup, return-->
        <div class="form-container-2">
                <form action="reservation.php" name="date" method="post" onsubmit="return validateDate(this)">
                    <div class="services-container">
                        <div class="select-menu">
                            <div class="select-btn">
                                <span class="sBtn-text">Select your option</span>
                                    <select name="car_type" class="">
                                        <option class="sBtn-txt" value="All">All</option>
                                        <option class="sBtn-txt" value="Luxurious Car">Luxurious Car</option>
                                        <option class="sBtn-txt" value="Sports Car">Sports Car</option>
                                        <option class="sBtn-txt" value="Classics Car">Classics Car</option>
                                    </select>
                            </div>                    
                        </div>
                    </div>
                    <div class="input-box-2">
                        <span>Pick-Up Date</span>
                        <input type="date" name="booked_date">
                    </div>
                    <div class="input-box-2">
                        <span>Return Date</span>
                        <input type="date" name="return_date">
                    </div>
                    <input type="submit" name="submit-2" class="btn">
                </form>
        </div>
        <?php
            $reservation_date = $SESSION['reservation_date'] = date("Y-m-d");
            $conn = connect($reservation_date);

            //Default
            $_SESSION["booked_date"] = '0000-00-00';
            $_SESSION["return_date"] = '0000-00-00';
            //if user clicks on 'Submit'
            if (isset($_POST['submit-2']))
            {

                //getting the pickup date and return date
                if(isset($_POST['booked_date']) && isset($_POST['return_date']))
                {
                    $booked_date = $_SESSION['booked_date'] = $_POST['booked_date'];
                    $return_date = $_SESSION['return_date'] = $_POST['return_date'];
                    //getting the category of the car
                    if(!empty($_POST['car_type'])) 
                    {
                        $category = $_POST['car_type'];
                    }
                    else 
                    {
                        $category = "All";
                    }
                    //checks and filters the cars that are available
                    $cars = checkBookingDate($conn, $category, $booked_date, $return_date);
                }
            }
            else
            {
                //Get all cars
                $cars = getProduct($conn);
            }               
        ?>
        <!-- Individual boxes -->
        <div class="services-container">
        <?php if($cars != FALSE) {
        foreach($cars as $car) { 
            ?>
            <div class="box">
                <div class="box-img">
                    <img src="<?php echo $car['photo'] ?>" alt="">
                </div>
                <p><?php echo $car['category'] ?></p>
                <h4><?php echo $car['model'] ?></h4>
                <h3><?php echo $car['car_vehicle_ID']?></h3>
                <h2>RM    <?php echo $car['price_per_day'] ?> <span>/day</span></h2>
                <form method="post" action="register.php" <?php if($_SESSION["booked_date"] == '0000-00-00' && $_SESSION["return_date"] == '0000-00-00') {echo 'onsubmit="return validateDate(date)"'; }?>> 
                    <input type="submit" class="btn" name="Select" 
                    value="<?php echo 'Reserve '.$car['car_vehicle_ID']?>"></input></a>
                </form>
            </div>
            <?php
                }
            }
                $conn->close();
            ?>
        </div>
    </section>
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