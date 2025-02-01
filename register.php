<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gets the username, password, host and database to add the data into.
    include 'conn.php';
    // Extracts the json request data into a raw JSON string.
    $jsondata = file_get_contents("php://input");
    // Makes an associative array with the raw JSON data that has been decoded and sorts them into username and password.
    $data = json_decode($jsondata, true);
    $username = $data['username'];
    $password = $data['password'];
    // Selects everything from the users table where username is equal to the request username.
    $sqlValidate = "SELECT * FROM users WHERE username = '$username'";
    // If there is a row in the users table then echo the isRegistered "Yes" back to the kotlin program for it to receive
    if ($sqlValidate = mysqli_num_rows(mysqli_query($conn, $sqlValidate)) > 0) {
        $values["isRegistered"] = "Yes";
        echo json_encode($values);
    }
    else {
        // If there isn't a row in the users table then insert the request username and password into the users table.
        $values["isRegistered"] = "No";
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        $result = mysqli_query($conn, $sql);
        // If the data is successfully added to the database then echo back "Success" to the kotlin program.
        if ($result) {
            $values["status"] = "Success";
            echo json_encode($values);
        } else {
            // If the data failed to be added to the database then echo back "Failed" to the kotlin program.
            $values["status"] = "Failed";
            echo json_encode($values);
        }
    }
    mysqli_close($conn);
}