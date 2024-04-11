<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css"></link>
</head>

<body>

    <div class="topnav">
        <a class="active" href="#home">Home</a>
        <a href="#news">News</a>
        <a href="#contact">Contact</a>
        <a href="#about">About</a>

<?php
if (!isset($_SESSION['user_id']))
{
    echo("<a href='login.php'>Login</a>");
}
else
{
    echo("<a href='logout.php'>Log out</a>");
}

?>
    </div>

    <div style="padding-left:16px">
        <h2>Top Navigation Example</h2>
        <p>Some content..</p>
    </div>

</body>





    <!--<h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Username:</label><br>
        <input type="text" name="username"><br>
        <label>Password:</label><br>
        <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form> --?
    <?php if (isset($login_error)) echo "<p>$login_error</p>"; ?>

</html>