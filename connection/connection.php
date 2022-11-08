<?php
    $severname = "localhost";
    $user = "root";
    $pass = "";
    $database = "rent_bicycle";

    $conn=mysqli_connect($severname, $user, $pass, $database);

    if(mysqli_connect_error())
    {
        echo "Cannot connect";
    }

?>