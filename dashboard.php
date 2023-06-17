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

// Retrieve user ID from the session or authentication process
$userId = $_SESSION['userId']; // Replace 'userId' with the actual session variable storing the user ID

// Retrieve the bookings made by the user
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = :userId");
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the bookings
if ($stmt->rowCount() > 0) {
    echo "<h1>My Bookings</h1>";
    echo "<table>";
    echo "<tr><th>Flight Number</th><th>Name</th><th>Email</th></tr>";
    foreach ($bookings as $booking) {
        echo "<tr>";
        echo "<td>" . $booking['flight_number'] . "</td>";
        echo "<td>" . $booking['name'] . "</td>";
        echo "<td>" . $booking['email'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No bookings found.</p>";
}

// Close the database connection
$conn = null;
?>

