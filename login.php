<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Gets the username, password, host and database to add the data into.
    include 'conn.php';
    // Extracts the json request data into a raw JSON string.
    $jsondata = file_get_contents("php://input");
    // Makes an associative array with the raw JSON data that has been decoded and sorts them into username and password.
    $data = json_decode($jsondata, true);
    $username = $data['username'];
    $password = $data['password'];
    // Selects everything from the users table where username is equal to the request username and where the password is equal to the request password.
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    // If there is a row in the users table then echo the status "Success" back to the kotlin program for it to receive
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $values["status"] = "Success";
        $values["username"] = $row["username"];
        echo json_encode($values);
    }
    // If there isn't a row in the users table then echo the status "Failed" back to the kotlin program for it to receive
    else{
        $values["status"] = "Failed";
        echo json_encode($values);
    }
}
