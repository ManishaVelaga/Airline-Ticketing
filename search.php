<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Flight Search Results</title>
</head>

<style>
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
    <h1>Flight Search Results</h1>

    <?php
    // Database connection details
    $servername = "localhost:3310";
    $username = "root";
    $password = "";
    $dbname = "flights";

    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve search parameters from the form
    $searchDate = $_POST['searchDate'];
    $searchTime = $_POST['searchTime'];
    $fromAirport = $_POST['fromAirport'];
    $toAirport = $_POST['toAirport'];

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM flights WHERE departure_time >= :searchDateTime AND departure_city = :fromAirport AND arrival_city = :toAirport");
    $stmt->execute(array(':searchDateTime' => "$searchDate $searchTime", ':fromAirport' => $fromAirport, ':toAirport' => $toAirport));

    // Check if any flights were found
    if ($stmt->rowCount() > 0) {
        echo "<h2>Search Results:</h2>";

        // Display flight details and booking option
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="container">
                <h3>Flight Number: <?php echo $row['flight_number']; ?></h3>
                <p>Departure City: <?php echo $row['departure_city']; ?></p>
                <p>Arrival City: <?php echo $row['arrival_city']; ?></p>
                <p>Departure Time: <?php echo $row['departure_time']; ?></p>
                <p>Arrival Time: <?php echo $row['arrival_time']; ?></p>
                <form action="book.php" method="get">
                    <input type="hidden" name="flightNumber" value="<?php echo $row['flight_number']; ?>">
                    <button type="submit">Book this flight</button>
                </form>
                <hr>
            </div>
            <?php
        }
    } else {
        echo "<p>No flights found for the selected criteria.</p>";
    }

    // Close the database connection
    $conn = null;
    ?>

    <div class="button-container">
        <button onclick="window.location.href='search.html'">Back to Search</button>
    </div>
</body>
</html>








