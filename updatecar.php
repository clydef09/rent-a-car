<?php
// Database connection
require_once('connection.php');

// Check if the form was submitted
if (isset($_POST['update'])) {
    // Retrieve form data
    $carid = $_POST['CAR_ID'];
    $carName = $_POST['CAR_NAME'];
    $fuelType = $_POST['FUEL_TYPE'];
    $capacity = $_POST['CAPACITY'];
    $price = $_POST['PRICE'];

    // Prepare and execute the update query
    $query = "UPDATE cars SET CAR_NAME = ?, FUEL_TYPE = ?, CAPACITY = ?, PRICE = ? WHERE CAR_ID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssiii", $carName, $fuelType, $capacity, $price, $carid);

    if (mysqli_stmt_execute($stmt)) {
        echo "Car details updated successfully!";
    } else {
        echo "Error updating car details: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
