<?php
$conn = new mysqli("localhost", "root", ".", "registers_from_android");
if ($conn) {
    $values["status"] = "Success";
}
else {
    $values["status"] = "Error";
}
echo json_encode($values);

?>
