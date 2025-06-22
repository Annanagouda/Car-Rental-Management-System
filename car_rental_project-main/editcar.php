<?php
require_once('connection.php');

if (!isset($_GET['id'])) {
    echo "Car ID not provided.";
    exit;
}

$car_id = $_GET['id'];

// Fetch existing car details
$query = "SELECT * FROM cars WHERE CAR_ID = $car_id";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Car not found.";
    exit;
}

$car = mysqli_fetch_assoc($result);

// Update car data if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_name = $_POST['car_name'];
    $fuel_type = $_POST['fuel_type'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $available = $_POST['available'];

    $update = "UPDATE cars SET 
                CAR_NAME = '$car_name',
                FUEL_TYPE = '$fuel_type',
                CAPACITY = '$capacity',
                PRICE = '$price',
                AVAILABLE = '$available'
              WHERE CAR_ID = $car_id";

    if (mysqli_query($con, $update)) {
        echo "<script>alert('Car updated successfully.'); window.location.href='adminvehicle.php';</script>";
    } else {
        echo "Error updating car: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Car</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url("../images/carbg2.jpg") center/cover no-repeat;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #aaa;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #ff7200;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
        }
        button:hover {
            background-color: #e66000;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Car Details</h2>
        <form method="POST">
            <label for="car_name">Car Name</label>
            <input type="text" name="car_name" id="car_name" value="<?php echo $car['CAR_NAME']; ?>" required>

            <label for="fuel_type">Fuel Type</label>
            <select name="fuel_type" id="fuel_type" required>
                <option value="Petrol" <?php if($car['FUEL_TYPE'] == 'Petrol') echo 'selected'; ?>>Petrol</option>
                <option value="Diesel" <?php if($car['FUEL_TYPE'] == 'Diesel') echo 'selected'; ?>>Diesel</option>
                <option value="Electric" <?php if($car['FUEL_TYPE'] == 'Electric') echo 'selected'; ?>>Electric</option>
            </select>

            <label for="capacity">Capacity</label>
            <input type="number" name="capacity" id="capacity" value="<?php echo $car['CAPACITY']; ?>" required>

            <label for="price">Price (₹ per day)</label>
            <input type="number" name="price" id="price" value="<?php echo $car['PRICE']; ?>" required>

            <label for="available">Available</label>
            <select name="available" id="available" required>
                <option value="Y" <?php if($car['AVAILABLE'] == 'Y') echo 'selected'; ?>>Yes</option>
                <option value="N" <?php if($car['AVAILABLE'] == 'N') echo 'selected'; ?>>No</option>
            </select>

            <button type="submit">Update Car</button>
        </form>
    </div>
</body>
</html>
