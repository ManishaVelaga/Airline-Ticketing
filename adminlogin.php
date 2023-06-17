<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style1.css"/>
</head>
<style>
body{
    background-color: #99DBF5;
}
.container {
    margin: 0 auto;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    padding: 30px 25px;
    background: white;
    border-radius: 50px;
}

h3 {
    margin-top: 5px;
    padding-top: 1px;
    color: white;
}

h3:hover {
    color: red;
}

ul {
    list-style-type: none;
    margin: 0px;
    padding: 12px;
    overflow: hidden;
    background-color: #00204fff;
    position: fixed;
    width: 99%;
    top: -2px;
    left: -2px;
}

li {
    float: left;
    position: relative;
    top: -5px;
}

li img {
    float: left;
    position: relative;
    max-width: 100%;
    height: auto;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 10px 10px;
    text-decoration: none;
    float: left;
}

li a:hover {
    color: rgb(224, 87, 41);
}
</style>
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

<body>
<div class="Navigation">
        <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="Contact">Contact</a></li>
        </ul>
    </div>
<?php
session_start();

// Database connection details
$servername = "localhost:3310";
$username = "root";
$password = "";
$dbname = "flights";

// Create a new PDO instance
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_username = $_POST['username'];
    $admin_password = $_POST['password'];

    // Query to check if the admin credentials are valid
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $admin_username);
    $stmt->bindParam(':password', $admin_password);
    $stmt->execute();

    // If a matching admin record is found, set the session variable and redirect to the admin dashboard
    if ($stmt->rowCount() === 1) {
        $_SESSION['admin_username'] = $admin_username;
        header("Location: adminafterlogin.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<div class="container">
    <h1>Admin Login</h1>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>

        <?php if (isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
    </form>
</div>

</body>
</html>
