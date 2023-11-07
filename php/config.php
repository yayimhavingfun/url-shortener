<?php
    global $con;
    $con = mysqli_connect("localhost", "root", "1234", "urls");
    if (!$con) {
        echo "Database connection error" . mysqli_connect_error();
    }
