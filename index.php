<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Game site home</title>
    <link rel="stylesheet" href="style.css"></link>
</head>

<body>

    <div class="topnav">
        <a class="active" href="#home">Home</a>
        <a href="#news">News</a>
        <a href="games.php">Games</a>
        <a href="#contact">Contact</a>

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

    <div class="container">
        <h2>Welcome to THE GAME ZONE</h2>
<?php
if (!isset($_SESSION['username']))
{
    echo("Greetings, guest gamer.");
}
else
{
    echo("Greetings, " .  $_SESSION['username']);
}

?>


    </div>

</body>



</html>