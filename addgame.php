<?php
// Start the session
session_start();

include "dbsetup.php";


if (isset($_SESSION['user_id']))
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        // Database connection configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "gamesdb";

        // Create connection
        $connection = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($connection->connect_error) 
        {
            die("Connection failed: " . $connection->connect_error);
        }

        $title = $_POST["title"];
        $description = $_POST["description"];

        // File upload configuration
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) 
        {
            $uploadOk = 1;
        } 
        else 
        {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 5000000) 
        {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") 
        {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) 
        {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } 
        else 
        {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) 
            {
                // Insert game details into database
                $stmt = $connection->prepare("INSERT INTO games (title, description, image_path) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $title, $description, $target_file);

                if ($stmt->execute()) 
                {
                    $connection->close();
                    header("Location: games.php");
                    exit();
                } 
                else 
                {
                    $connection->close();
                    $_SESSION["upload_error"] = true;
                    header("Location: addgame.php");
                    exit();
                }
            } 
            else 
            {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}
else
{
    header("Location: login.php");
    exit();
}




?>

<!DOCTYPE html>
<html>
<head>
    <title>Register an account</title>
    <link rel="stylesheet" href="style.css"></link>
</head>
<body>
<div class="topnav">
        <a href="index.php">Home</a>
        <a href="#news">News</a>
        <a class="active" href="games.php">Games</a>
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
    
    <div>

<?php
    if ($_SESSION["upload_error"] == true)
    {
        echo("<p>There was an error uploading the game.</p>");
    }
?>

        <form method="post" action=""  enctype="multipart/form-data">
            <label for="title">Title:</label><br>
            <input type="text" name="title" required><br>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="3" required></textarea>

            <label for="image">Choose Image:</label>
            <input type="file" name="image" id="image" required><br>

            <input type="submit" value="Upload">

        </form>
    </div>
</body>
</html>