<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
body{
    background-color: #99DBF5;
}
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
 padding-left: 400px;
  }
  
   a {
    text-decoration: none;
    color: white;
    font-size: 1.2rem;
    padding: 0.3rem;
  }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {background-color: #f5f5f5;}

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
<div class="Navigation">
        <ul>
            <li><a href="adminlogin.php">Logout</a></li>
        </ul>
    </div>
<?php
    session_start();

    // Check if the admin is logged in
    if (!isset($_SESSION['admin_username'])) {
        // Redirect to the admin login page
        header("Location: admin_login.php");
        exit();
    }

    // Database connection details
    $servername = "localhost:3310";
    $username = "root";
    $password = "";
    $dbname = "flights";

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle add flight form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_flight'])) {
        $flight_number = $_POST['flight_number'];
        $departure = $_POST['departure'];
        $arrival = $_POST['arrival'];

        // Insert the new flight into the database
        $stmt = $conn->prepare("INSERT INTO flights (flight_number, departure_city, arrival_city) VALUES (:flight_number, :departure, :arrival)");
        $stmt->bindParam(':flight_number', $flight_number);
        $stmt->bindParam(':departure', $departure);
        $stmt->bindParam(':arrival', $arrival);
        $stmt->execute();
    }

    // Handle remove flight form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_flight'])) {
        if (isset($_POST['flight_number'])) {
            $flight_number = $_POST['flight_number'];

            // Delete the flight from the database
            $stmt = $conn->prepare("DELETE FROM flights WHERE flight_number = :flight_number");
            $stmt->bindParam(':flight_number', $flight_number);
            $stmt->execute();
        }
    }

    // Fetch flight details based on flight number and time
    $bookings = array();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view_bookings'])) {
        $flight_number = $_POST['flight_number'];

        // Retrieve bookings for the specified flight number from the database
        $stmt = $conn->prepare("SELECT * FROM bookings WHERE flight_number = :flight_number");
        $stmt->bindParam(':flight_number', $flight_number);
        $stmt->execute();

        // Fetch all the bookings into an array
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<div class="container">
    <h1>Admin Dashboard</h1>
    <h2>Add Flight</h2>
    <form method="post" action="">
        <label for="flight_number">Flight Number:</label>
        <input type="text" id="flight_number" name="flight_number" required>

        <label for="departure">Departure:</label>
        <input type="text" id="departure" name="departure" required>

        <label for="arrival">Arrival:</label>
        <input type="text" id="arrival" name="arrival" required>

        <button type="submit" name="add_flight">Add Flight</button>
    </form>

    <h2>Remove Flight</h2>
    <form method="post" action="">
        <label for="flight_number">Flight Number:</label>
        <input type="text" id="flight_number" name="flight_number" required>

        <button type="submit" name="remove_flight">Remove Flight</button>
    </form>

    <h2>View Bookings</h2>
    <form method="post" action="">
        <label for="flight_number">Flight Number:</label>
        <input type="text" id="flight_number" name="flight_number" required>

        <button type="submit" name="view_bookings">View Bookings</button>
    </form>

    <!-- Display Bookings -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view_bookings'])): ?>
        <?php if (!empty($bookings) && is_array($bookings)): ?>
            <h2>Bookings for Flight <?php echo $flight_number; ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Flight Number</th>
                        <th>Passenger Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['flight_number']; ?></td>
                            <td><?php echo $booking['name']; ?></td>
                            <td><?php echo $booking['email']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No bookings found for Flight <?php echo $flight_number; ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <a href="adminlogin.php">Logout</a>
</div>

</body>
</html>
