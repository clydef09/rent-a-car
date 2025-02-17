<?php
// Database connection
require_once('connection.php');

// Get car ID from URL parameter
$carid = isset($_GET['id']) ? $_GET['id'] : null;

if ($carid !== null) {
    // Fetch current car details from the database
    $query = "SELECT * FROM cars WHERE CAR_ID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $carid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $car = mysqli_fetch_assoc($result);

    if (!$car) {
        echo "<p>Car not found.</p>";
        exit;
    }

    mysqli_close($conn);
} else {
    echo "<p>Car ID is missing from the URL.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Car Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url("images/ct.webp") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="POST" action="updatecar.php">
        <h2>Update Car Details</h2>
        <input type="hidden" name="CAR_ID" value="<?php echo htmlspecialchars($car['CAR_ID']); ?>">

        <label for="CAR_NAME">Car Name:</label>
        <input type="text" id="CAR_NAME" name="CAR_NAME" value="<?php echo htmlspecialchars($car['CAR_NAME']); ?>" required>

        <label for="FUEL_TYPE">Fuel Type:</label>
        <input type="text" id="FUEL_TYPE" name="FUEL_TYPE" value="<?php echo htmlspecialchars($car['FUEL_TYPE']); ?>" required>

        <label for="CAPACITY">Capacity:</label>
        <input type="number" id="CAPACITY" name="CAPACITY" value="<?php echo $car['CAPACITY']; ?>" required>

        <label for="PRICE">Rent Per Day:</label>
        <input type="number" id="PRICE" name="PRICE" value="<?php echo $car['PRICE']; ?>" required>

        <button type="submit" name="update">Update Car</button>
    </form>
</body>
</html>
