<?php
// Start the session
session_start();

include "dbsetup.php";

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$db = "gamesdb";

$conn = new mysqli($host, $username, $password, $db);

// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

// Function to authenticate user
function authenticateUser($username, $password) 
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
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
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="">
        <label>Username:</label><br>
        <input type="text" name="username"><br>
        <label>Password:</label><br>
        <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
    <?php if (isset($login_error)) echo "<p>$login_error</p>"; ?>
</body>
</html>


