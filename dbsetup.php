<?php
	// Set up the database for the application
	
	// set up the connection to mysql
	$host = "localhost";
	$username = "root";
	$password = "";
	
	global $connection;
	$connection = new mysqli($host, $username, $password); // gets use a connection object to use to access mysql
	
	// check the connection works
	if ($connection->connect_error)
	{
		die("Connection failed: " . $connection->connect_error);
		
	}
	else
	{
		echo "all good, captain";
	}

	// create the database for the application
	$sql_create_db = "CREATE DATABASE IF NOT EXISTS gamesdb"; 
	if ($connection->query($sql_create_db) === TRUE)
	{
		echo "Database gamesdbsdb created successfully!";
	}
	else
	{
		echo "<br>Error creating database: " . $connection->error;
	}
	
	// select database
	$connection->select_db("gamesdb");

    // creates the users table with three fields: ID, username and password
    // the ID field is the primary key for the table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL
    )";

    if ($connection->query($sql) === TRUE) 
    {
        echo "Table 'users' created successfully";
    } 
    else 
    {
        echo "Error creating table: " . $conn->error;
    }

    // create a table in the selected database
	// specifies three fields: ID, name and email
	// The ID field is the primary key for the table
	$sql = "CREATE TABLE IF NOT EXISTS games (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title TEXT,
        description TEXT,
        image_path VARCHAR(255) NOT NULL
    )";

    if ($connection->query($sql) === TRUE) 
    {
        echo "Table 'games' created successfully";
    } 
    else 
    {
        echo "Error creating table: " . $conn->error;
    }

	

	
	// close the database Connection
	$connection->close();


	// ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
?>

