<?php # Script 9.2 - mysqli_connect.php

// This file contains the database access information.
// This file also establishes a connection to MySQL,
// selects the database, and sets the encoding.

// Set the database access information as constants:
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "books";

    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password,$dbname);
    


// Make the connection:


// Set the encoding...
