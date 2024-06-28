<?php
include 'connect.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

    $delete_query = "DELETE FROM `users` WHERE id = $id";
    $result = mysqli_query($con, $delete_query);

    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");

    if ($result) {
        header('Location: display.php');
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    echo "Invalid request. Please provide a valid delete ID.";
}
?>
