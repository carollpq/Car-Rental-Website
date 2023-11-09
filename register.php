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
    <link rel="stylesheet" href="register.css">
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
            <li><a href="record.php">Records</a></li>
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
                <form action="" name="date" method="post" >
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
        //starting the connection
            $reservation_date = $SESSION['reservation_date'] = date("Y-m-d");
            $conn = connect($reservation_date);

            //from Reservation page
            if (isset($_POST['Select']))
            { 
                $_SESSION['vehicle_ID'] = str_replace("Reserve ", "", $_POST['Select']);
                    // echo '<script>window.location="register.php"</script>';
            }

            //Display all cars
            $cars = getProduct($conn);              
        ?>

        <!-- Individual boxes -->
        <div class="services-container">
        <?php foreach($cars as $car) { ?>
            <div class="box">
                <div class="box-img">
                    <img src="<?php echo $car['photo'] ?>" alt="">
                </div>
                <p><?php echo $car['category'] ?></p>
                <h4><?php echo $car['model'] ?></h4>
                <h3><?php echo $car['car_vehicle_ID']?></h3>
                <h2>RM    <?php echo $car['price_per_day'] ?> <span>/day</span></h2>
                <form method="post" action="">
                    <input type="submit" class="btn" name="Select" 
                    value="<?php echo 'Reserve '.$car['car_vehicle_ID']?>"></input></a>
                </form>
            </div>

            <?php
                }
            ?>
        </div>
    </section>

    <!-- Reservation Form -->
    <div class="popup-delete center">
    <!-- Couldn't find where the close button -->
    <div class="close-icon"><a href="reservation.php">&#x2715;</a></div>
        <section class="reservation-box" id="reservation-box">
        <div class="container" id="reservation">
            <label class="reservation">Client Details</label>
                <form action="register.php" class="form" method="post" onsubmit="return validateRegistration(this)">
                    <div class="input-box">
                    <label>First Name</label>
                    <input type="text" name="firstname" id="firstname" placeholder="Enter first name" required />
                    </div>

                    <div class="input-box">
                    <label>Last Name</label>
                    <input type="text" name="lastname" id="lastname" placeholder="Enter last name" required />
                    </div>
            
                    <div class="input-box">
                    <label>Email Address</label>
                    <input type="text" name="email" id="email" placeholder="hello@world.com" required />
                    </div>
            
                    <div class="input-box">
                    <label>Phone Number</label>
                    <input type="number" name="phone_num" id="phone_num" placeholder="+60123456789" required />
                    </div>

                    <div class="input-box">
                    <label>Pick Up Location</label>
                    <input type="text" name="location" id="location" placeholder="Enter Location" required />
                </div>
        </div>

        <!-- Reservation Form 2 -->
        <div class="empty-box">
            <div class="container" id="reservation">
                <label class="reservation">Car Selection</label>
                        <div class="input-box-2">
                            <label>Pickup Date: <span><?php echo $_SESSION["booked_date"] ?></span></label>
                            <label>Return Date: <span><?php echo $_SESSION["return_date"] ?></span></label>
                            <label>Available:  <span><?php echo $_SESSION['vehicle_ID'] ?></span>
                            </label>
                            <div class="box-img">
                                <?php
                                    $vehicle_id = $_SESSION['vehicle_ID'];
                                    $sql5 = "SELECT photo from vehicle WHERE car_vehicle_ID = '$vehicle_id'";
                                    $result = $conn->query($sql5);
                                    if (mysqli_num_rows($result) > 0 )
                                    {
                                        while($car = $result->fetch_assoc()){
                                            $car_photo = $car['photo'];
                                        }
                                    }
                                ?>
                                <img src="<?php echo $car_photo?>" alt="">
                            </div>
                        </div>
                        <input class="button" type="submit" name="Confirm" value="Confirm Reservation">
        
                </form>

                    <?php
                    if (isset($_POST['Confirm']))
                    {
                        $f_name = $_POST['firstname'];
                        $l_name = $_POST['lastname'];
                        $email = $_POST['email'];
                        $phone = $_POST['phone_num'];
                        $location = $_POST['location'];

                        //Register the customer and make reservation
                        $customer_id = registerCustomer($conn, $f_name, $l_name, $email, $phone);
                        $_SESSION['reservation_id'] = makeReservation($conn, $customer_id, $reservation_date, $_SESSION["booked_date"], $location, $_SESSION["return_date"], $_SESSION['vehicle_ID']);
                
                        ?>
            </div>
        </div>
        </section>
    </div>

      <?php  
            } 
            $conn->close(); //close the connection?>
   
    <!-- Link to JS -->
    <script src="script2.js"></script>
</body>
</html>