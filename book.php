<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Flight Booking</title>
</head>

<style>
.Navigation {
    display: flex;
    justify-content: space-between;
    display:inline;
    
  }
  
  ul {
    display: flex;
    align-items:center;
    padding-left: 1000px;
    padding-top: -10px;
    background-color: #000000;
  }
      
   li {
    list-style: none;
    padding: 1rem;
  }
  
   a {
    text-decoration: none;
    color: white;
    font-size: 1.2rem;
    padding: 0.3rem;
  }
body {
    background-color: #E3F2C1;
}
.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.button-container {
    text-align: right;
}

.button-container button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

.button-container button:hover {
    background-color: #45a049;
}

</style>
<body>
<div class="Navigation">
        <ul>
            <li><a href="bookings.php">View Bookings</a></li>
            <li><a href="usser_log.php">Logout</a></li>
        </ul>
    </div>

    <h1>Flight Booking</h1>

    <?php
    // Start the session or authenticate the user

    // Check if the user is logged in or retrieve user information from the session

    // Database connection details
    $servername = "localhost:3310";
    $username = "root";
    $password = "";
    $dbname = "flights";

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve the flight number from the URL parameter
    $flightNumber = $_GET['flightNumber'];

    // Retrieve the flight details from the database
    $stmt = $conn->prepare("SELECT * FROM flights WHERE flight_number = :flightNumber");
    $stmt->bindParam(':flightNumber', $flightNumber);
    $stmt->execute();
    $flight = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the flight exists
    if (!$flight) {
        echo "Flight not found.";
        exit;
    }

    // Handle the booking form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the form data
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Perform validation on the form data
        // You can add more validation rules as per your requirements

        if (empty($name) || empty($email)) {
            echo "Please fill in all the required fields.";
            exit;
        }

        // Check seat availability for the flight
        // Assuming the default seat count is 60
        $seatsAvailable = 60; // You can retrieve the actual seat count from the flight record in the database

        if ($seatsAvailable > 0) {
            // Insert the booking into the database
            $stmt = $conn->prepare("INSERT INTO bookings (flight_number, name, email) VALUES (:flightNumber, :name, :email)");
            $stmt->bindParam(':flightNumber', $flightNumber);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Update the seat count for the flight
            $seatsAvailable--;

            // Display a success message to the user
            echo "Booking successful. Your seat has been reserved.";
        } else {
            // Display an error message if no seats are available
            echo "Sorry, the flight is fully booked.";
        }
    }
    ?>

    <h2>Flight Details</h2>
    <table>
        <tr>
            <th>Flight Number:</th>
            <td><?php echo $flight['flight_number']; ?></td>
        </tr>
        <tr>
            <th>Departure City:</th>
            <td><?php echo $flight['departure_city']; ?></td>
        </tr>
        <tr>
            <th>Arrival City:</th>
            <td><?php echo $flight['arrival_city']; ?></td>
        </tr>
        <tr>
            <th>Departure Time:</th>
            <td><?php echo $flight['departure_time']; ?></td>
        </tr>
        <tr>
            <th>Arrival Time:</th>
            <td><?php echo $flight['arrival_time']; ?></td>
        </tr>
    </table>

    <h2>Passenger Information</h2>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Book Now">
    </form>
</body>
</html>

