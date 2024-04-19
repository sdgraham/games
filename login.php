<?php
// Start the session
session_start();

include "dbsetup.php";

// Function to authenticate user
function authenticateUser($username, $password) 
{
    // Database connection
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $db = "gamesdb";


    global $connection;
    $connection = new mysqli($host, $dbusername, $dbpassword, $db);

    // Check connection
    if ($connection->connect_error) 
    {
        die("Connection failed: " . $connection->connect_error);
    }

    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) 
    {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) 
        {
            return $user;
        }
    }

    return null;
}

// Login process
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = authenticateUser($username, $password);

    if ($user) 
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION["upload_error"] = false;
        header("Location: index.php"); // Redirect to dashboard after successful login
        exit();
    } 
    else 
    {
        $login_error = "Invalid username or password";
    }
}

// Logout process
if (isset($_GET['logout'])) 
{
    session_destroy();
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css"></link>
</head>
<body>
<div class="topnav">
        <a href="index.php">Home</a>
        <a href="#news">News</a>
        <a href="games.php">Games</a>
        <a href="#contact">Contact</a>

<?php
if (!isset($_SESSION['user_id']))
{
    echo("<a class='active' href='login.php'>Login</a>");
}
else
{
    echo("<a href='logout.php'>Log out</a>");
}

?>
    </div>
    
    <form method="post" action="">
        <label>Username:</label><br>
        <input type="text" name="username"><br>
        <label>Password:</label><br>
        <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
    <div>
    <h2>No account? <a href="register.php">Register</a></h2>
    </div>
    <?php if (isset($login_error)) echo "<p>$login_error</p>"; ?>
</body>
</html>


