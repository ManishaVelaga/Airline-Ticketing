<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="style1.css"/>
</head>
<style>
    body{
     
      background-color: #99DBF5;
}
.form {
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
        left:-2px;
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
<body>
<?php
    require('connection.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `users` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['username'] = $username;
            // Redirect to user dashboard page
            header("Location: search.html");
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='usser_log.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
?>
 
    <ul>
    
      
      
      <li style="float:right"><a href="contact.html"><font size="5">Contact</font></a></li>
      <li style="float:right"><a href="Home.html"><font size="5">Home</font></a></li>
  </ul>           
    <form class="form" method="post" name="login">
        <h1 class="login-title">Login</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/>
        <input type="submit" value="Login" name="submit" class="login-button"/>
        <p class="link"><a href="user_reg.php">New Registration</a></p>
  </form>
<?php
    }
?>
</body>
</html>