<?php
// Start the session
session_start();

// Check if the user is logged in or retrieve user information from the session

// Database connection details
$servername = "localhost:3310";
$username = "root";
$password = "";
$dbname = "flights";

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve the username from the admin session
$adminUsername = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : null;



    // Check if the name is set
    if ($name) {
        // Retrieve the user details from the users table based on name
       $stmt = $conn->prepare("SELECT name FROM users WHERE username = :adminUsername");
$stmt->bindParam(':adminUsername', $adminUsername);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists
        if ($user) {
    // Retrieve the name from the user record
    $name = $user['name'];

    // Retrieve the bookings made by the user based on the matching name
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE name = :name");
    $stmt->bindParam(':name', $name);
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
        } else {
            echo "<p>User not found.</p>";
        }
    } else {
        echo "<p>Name not found.</p>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>

