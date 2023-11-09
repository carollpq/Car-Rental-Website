<?php 
	//function to create a connection
	function connect($date){
		$mysqli = new mysqli('localhost', 'root', '', 'COMP1044_database');
		if($mysqli->connect_errno != 0){
			return $mysqli->connect_error;
		}else{
			$mysqli->set_charset("utf8mb4");	
		}
		//Deletes past records and where it has passed its reservation duration
		$mysqli->query("DELETE FROM reservation WHERE return_date < '$date'");
		return $mysqli; //returns the current connection
	}

	//function to select all car models
	function getProduct($mysqli){
		$res = $mysqli->query("SELECT * FROM vehicle");
		while($row = $res->fetch_assoc()){
			$products[] = $row;
		}
		return $products;
	}

	//function to delete the reservation from the database
	function deleteReservation($mysqli, $id){
		if ($id == NULL) //if user did not insert any id
		{
			return; //Does nothing and returns out of function
		}
		else
		{
			$sql = "DELETE FROM reservation WHERE reservation_ID = $id";
			$res = $mysqli->query($sql);
			if ($res === TRUE) //if deletion is successful, display success message
			{
				echo '<p class="success-message">Reservation deleted successfully.</p>';
			}
			else //if deletion is not successful, display error message
			{
				echo '<p class="success-message">Reservation was not deleted successfully.</p>';
				echo "Error: " . $sql . "<br>" . $mysqli->error;
			}
		}
	}

	//function to retrieve the information of a specific car model for display
	function getOneProduct($mysqli, $id){
		$res = $mysqli->query("SELECT * FROM vehicle WHERE car_vehicle_ID = '$id'");
		while($row = $res->fetch_assoc()){
			$products[] = $row;
		}
		return $products;
	}

	//function to retrieve reservation details 
	function getReservation($mysqli, $id)
	{
		$res = $mysqli->query("SELECT * FROM reservation WHERE reservation_ID = $id");
		if (mysqli_num_rows($res) === 0) //if ID doesn't exist
		{
			echo '<p class="success-message">Reservation does not exist. Please input a valid ID.</p>';
			return false;
		}
		else 
		{
			while($row = $res->fetch_assoc()){
				$products[] = $row;
			}
			return $products;
		}
	}

	//function to retrieve the information of cars (for display) based on their categories
	function getProductCategory($mysqli, $category){
		$res = $mysqli->query("SELECT * FROM vehicle WHERE category = '$category'");
		while($row = $res->fetch_assoc()){
			$products[] = $row;
		}
		return $products;
	}

	//function to filter out the vehicles based on its availability
	function checkBookingDate($mysqli, $category, $booked_date, $return_date)
	{
		if ($category == "All") //If the category chosen is "All"
		{
			//Check whether there are clashing dates / the dates chosen are not available
			//Selects for unavailable cars
			$count = $mysqli->query("SELECT DISTINCT vehicle_ID FROM reservation 
			WHERE ('$booked_date' >= pick_up_date AND '$return_date' <= return_date)
			OR
			('$booked_date' = '$return_date' AND ('$booked_date' >= pick_up_date AND '$booked_date' <= return_date))
			OR
			('$booked_date' < pick_up_date AND '$return_date' >= pick_up_date AND '$return_date' <= return_date)
			OR
			('$booked_date' <= return_date AND '$booked_date' >= pick_up_date AND '$return_date' > return_date)
			OR
			('$booked_date' < pick_up_date AND '$return_date' > return_date)");
			 if (mysqli_num_rows($count) === 0) // if all cars are available
			 {
				return getProduct($mysqli); //Display all the cars
			 }
			 else
			 {
				//Filter out the unavailable cars and display the ones that are available on the chosen dates
				$res = $mysqli->query("SELECT DISTINCT vehicle.car_vehicle_ID, vehicle.category, vehicle.model, vehicle.price_per_day, vehicle.photo 
				FROM vehicle, reservation WHERE vehicle.car_vehicle_ID 
				NOT IN (SELECT DISTINCT vehicle_ID FROM reservation 
				WHERE ('$booked_date' >= pick_up_date AND '$return_date' <= return_date)
				OR
				('$booked_date' = '$return_date' AND ('$booked_date' >= pick_up_date AND '$booked_date' <= return_date))
				OR
				('$booked_date' < pick_up_date AND '$return_date' >= pick_up_date AND '$return_date' <= return_date)
				OR
				('$booked_date' <= return_date AND '$booked_date' >= pick_up_date AND '$return_date' > return_date)
				OR
				('$booked_date' < pick_up_date AND '$return_date' > return_date))");
			 }
		}
		else //If user chooses a specific category to filter through
		{
			//Check whether there are clashing dates / the dates chosen are not available
			$count = $mysqli->query("SELECT DISTINCT reservation.vehicle_ID FROM reservation, vehicle
			WHERE (('$booked_date' >= reservation.pick_up_date AND '$return_date' <= reservation.return_date)
			OR
			('$booked_date' = '$return_date' AND ('$booked_date' >= reservation.pick_up_date AND '$booked_date' <= reservation.return_date))
			OR
			('$booked_date' < reservation.pick_up_date AND '$return_date' >= reservation.pick_up_date AND '$return_date' <= reservation.return_date)
			OR
			('$booked_date' <= reservation.return_date AND '$booked_date' >= reservation.pick_up_date AND '$return_date' > reservation.return_date)
			OR
			('$booked_date' < reservation.pick_up_date AND '$return_date' > reservation.return_date)) AND vehicle.category = '$category'");
			 if (mysqli_num_rows($count) === 0) // if all cars are available
			 {
				return getProductCategory($mysqli, $category); //Display all the cars by its category
			 }
			 else
			 {
				//Filter out the unavailable cars and display the ones that are available on the chosen dates, based on the chosen category
				$res = $mysqli->query("SELECT DISTINCT vehicle.car_vehicle_ID, vehicle.category, vehicle.model, vehicle.price_per_day, vehicle.photo 
				FROM vehicle, reservation WHERE vehicle.category = '$category' AND vehicle.car_vehicle_ID NOT IN (SELECT DISTINCT reservation.vehicle_ID FROM reservation, vehicle
				WHERE ('$booked_date' >= reservation.pick_up_date AND '$return_date' <= reservation.return_date)
				OR
				('$booked_date' < reservation.pick_up_date AND '$return_date' > reservation.return_date)
				OR
				('$booked_date' = '$return_date' AND ('$booked_date' >= reservation.pick_up_date AND '$booked_date' <= reservation.return_date))
				OR
				('$booked_date' < reservation.pick_up_date AND '$return_date' >= reservation.pick_up_date AND '$return_date' <= reservation.return_date)
				OR
				('$booked_date' <= reservation.return_date AND '$booked_date' >= reservation.pick_up_date AND '$return_date' > reservation.return_date))");
			 }
		}
		
		if (mysqli_num_rows($res) > 0 )
		{
			while($row2 = $res->fetch_assoc()){
				$products[] = $row2;
			}
			return $products;
		} //if no car of that category is available
		else
		{
			echo '<p style="color: black; padding:100px 440px;">No Car of This Category is Available. Please Enter Again.</p>';
			return FALSE;
		}

	} 

	//function to register customer's details into the database
	function registerCustomer($mysqli, $f_name, $l_name, $email, $phone)
	{
		//Making sure the names are capitalised correctly
		$f_name = ucwords(strtolower($f_name));
		$l_name = ucwords(strtolower($l_name));
		//Check if customer has previously registered or not
		$res = $mysqli->query("SELECT customer_ID FROM customer WHERE first_name = '$f_name' AND last_name = '$l_name'");
		if (mysqli_num_rows($res) === 0) //if the customer is newly registered
		{
			//Make sure there's no duplicate before setting it as a new customer_ID
			do
			{
				//Randomly generate a new customer ID
				$customer_id = rand(400000, 500000);
			}
			while (mysqli_num_rows($mysqli->query("SELECT * FROM customer WHERE customer_ID = $customer_id")) > 0);
			$sql = "INSERT INTO customer (customer_ID, first_name, last_name, contact_no, email)
			VALUES ($customer_id, '$f_name', '$l_name', $phone, '$email')";
			$res2 = $mysqli->query($sql);
		}
		else //if customer has registered before
		{
			//Retrieve the registered customer's ID
			while($cust = $res->fetch_assoc()){
				$customer_id = $cust['customer_ID'];
			}
		}
		//Returns the customer ID
		return $customer_id;
	}

	//function to make a new reservation
	function makeReservation($mysqli, $customer_id, $reservation_date, $booked_date, $location, $return_date, $vehicle_id)
	{
		$location = ucwords(strtolower($location));
		//Make sure there's no duplicate before setting it as reservation_ID
		do
		{
			//Randomly generate a new reservation ID
			$reservation_id = rand(100000, 300000);
		}
		while (mysqli_num_rows($mysqli->query("SELECT * FROM reservation WHERE reservation_ID = $reservation_id")) > 0);
		//insert new reservation into database
		$res = $mysqli->query("INSERT INTO reservation (reservation_ID, customer_ID, reservation_date, pick_up_date, pick_up_location, return_date, vehicle_ID)
		VALUES ($reservation_id, $customer_id, '$reservation_date', '$booked_date', '$location', '$return_date', '$vehicle_id')");

		if ($res === TRUE) //if customer is registered succesfully
		{
			echo '<script>window.location="confirmation.php"</script>';
		}
		else //if not successful
		{
			echo "Error: " . $sql . "<br>" . $mysqli->error;
		}

		return $reservation_id;
	}

	//function to update reservation
	function updateReservation($conn, $id, $pickup_date, $dropoff_date) {
		$sql = "UPDATE reservation SET pick_up_date = ?, return_date = ? WHERE reservation_ID = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ssi", $pickup_date, $dropoff_date, $id);
		$stmt->execute();
		$stmt->close();
	  }

	
	//function to check the availability of the car on newly selected dates
	function checkAvailability($mysqli, $booked_date, $return_date, $car_id, $reservation_id)
	{
		$count = $mysqli->query("SELECT DISTINCT reservation_ID FROM reservation 
		WHERE vehicle_ID = '$car_id' AND (('$booked_date' >= pick_up_date AND '$return_date' <= return_date)
		OR
		('$booked_date' = '$return_date' AND ('$booked_date' >= pick_up_date AND '$booked_date' <= return_date))
		OR
		('$booked_date' < pick_up_date AND '$return_date' >= pick_up_date AND '$return_date' <= return_date)
		OR
		('$booked_date' <= return_date AND '$booked_date' >= pick_up_date AND '$return_date' > return_date)
		OR
		('$booked_date' < pick_up_date AND '$return_date' > return_date))");
		if (mysqli_num_rows($count) === 0) // if the car is available on the selected dates / no clashing dates
		{
			//if selected dates are available, update the reservation
			updateReservation($mysqli, $reservation_id, $booked_date, $return_date);
			//Direct user to another page
			echo '<script>window.location="updated.php"</script>';
		}
		else //check if clashing dates are from the same reservation
		{
			$check = $mysqli->query("SELECT DISTINCT reservation_ID FROM reservation WHERE $reservation_id = (SELECT DISTINCT reservation_ID FROM reservation 
			WHERE vehicle_ID = '$car_id' AND (('$booked_date' >= pick_up_date AND '$return_date' <= return_date)
			OR
			('$booked_date' = '$return_date' AND ('$booked_date' >= pick_up_date AND '$booked_date' <= return_date))
			OR
			('$booked_date' < pick_up_date AND '$return_date' >= pick_up_date AND '$return_date' <= return_date)
			OR
			('$booked_date' <= return_date AND '$booked_date' >= pick_up_date AND '$return_date' > return_date)
			OR
			('$booked_date' < pick_up_date AND '$return_date' > return_date)))");
			//its the same reservation_id 
			if (mysqli_num_rows($check) > 0)
			{
				//if selected dates are available, update the reservation
				updateReservation($mysqli, $reservation_id, $booked_date, $return_date);
				//Direct user to another page
				echo '<script>window.location="updated.php"</script>';

			}
			else
			{
				//if the selected dates are not available, echo this message
				echo '<p class="success-message">Car is not available on selected dates. <br> Please Enter Again.</p>';
			}
		}
	}
?>

