<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: url("images/carbg2.jpg") center/cover no-repeat;
            font-family: Arial, sans-serif;
            min-height: 100vh;
        }

        .navbar {
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .logo {
            color: #ff7200;
            font-size: 30px;
            font-weight: bold;
        }

        .menu ul {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .menu ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: 0.3s;
        }

        .menu ul li a:hover {
            color: #ff7200;
        }

        .nn {
            background: #ff7200;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
        }

        .nn a {
            color: white;
            text-decoration: none;
        }

        .circle {
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }

        .phello {
            font-weight: bold;
            color: #333;
        }

        .overview {
            text-align: center;
            margin: 40px 0 20px;
            font-size: 32px;
            color: #222;
        }

        .filter-bar {
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-bar select, .search-bar input {
            padding: 10px;
            margin: 5px;
            border-radius: 25px;
            border: 1px solid #ccc;
            font-size: 16px;
            outline: none;
        }

        .car-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            padding: 0 30px 60px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .box img {
            width: 100%;
            max-width: 280px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .box h1 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .box h2 {
            font-size: 16px;
            color: #555;
            margin: 4px 0;
        }

        .utton {
            margin-top: 15px;
            background: #ff7200;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .utton:hover {
            background: #e06200;
        }

        .utton a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>

<?php 
    require_once('connection.php');
    session_start();
    $value = $_SESSION['email'];
    $sql="SELECT * FROM users WHERE EMAIL='$value'";
    $name = mysqli_query($con,$sql);
    $rows=mysqli_fetch_assoc($name);
    $sql2="SELECT * FROM cars WHERE AVAILABLE='Y'";
    $cars= mysqli_query($con,$sql2);
?>

<!-- Navigation Bar -->
<div class="navbar">
    <div class="logo">CaRs</div>
    <div class="menu">
        <ul>
            <li><a href="#">HOME</a></li>
            <li><a href="aboutus2.html">ABOUT</a></li>
            <li><a href="services2.html">SERVICES</a></li>
            <li><a href="contactus2.html">CONTACT</a></li>
            <li><a href="feedback/Feedbacks.php">FEEDBACK</a></li>
            <li><button class="nn"><a href="index.php">LOGOUT</a></button></li>
            <li><img src="images/profile.png" class="circle" alt="Profile"></li>
            <li class="phello">HELLO! <?php echo $rows['FNAME']." ".$rows['LNAME']?></li>
            <li><a href="bookinstatus.php">BOOKING STATUS</a></li>
        </ul>
    </div>
</div>

<h1 class="overview">OUR CARS OVERVIEW</h1>

<!-- Filters -->
<div class="filter-bar">
    <input type="text" id="searchInput" placeholder="Search by car name..." onkeyup="filterCars()">
    <select id="fuelFilter" onchange="filterCars()">
        <option value="">All Fuel Types</option>
        <option value="Petrol">Petrol</option>
        <option value="Diesel">Diesel</option>
        <option value="Electric">Electric</option>
    </select>
    <select id="priceFilter" onchange="filterCars()">
        <option value="">All Prices</option>
        <option value="1">Below ₹1000</option>
        <option value="2">₹1000 - ₹2000</option>
        <option value="3">Above ₹2000</option>
    </select>
</div>

<!-- Car Cards -->
<div class="car-list" id="carList">
<?php while($result= mysqli_fetch_array($cars)): ?>
    <div class="box car-item" 
         data-name="<?php echo strtolower($result['CAR_NAME']); ?>" 
         data-fuel="<?php echo strtolower($result['FUEL_TYPE']); ?>" 
         data-price="<?php echo $result['PRICE']; ?>">
        <img src="images/<?php echo $result['CAR_IMG']?>" alt="<?php echo $result['CAR_NAME'] ?>">
        <h1 class="car-name"><?php echo $result['CAR_NAME']?></h1>
        <h2>Fuel Type: <span><?php echo $result['FUEL_TYPE']?></span></h2>
        <h2>Capacity: <span><?php echo $result['CAPACITY']?></span></h2>
        <h2>Rent Per Day: <span>₹<?php echo $result['PRICE']?>/-</span></h2>
        <form action="booking.php" method="GET">
            <input type="hidden" name="id" value="<?php echo $result['CAR_ID']?>">
            <button class="utton" type="submit">Book</button>
        </form>
    </div>
<?php endwhile; ?>
</div>

<!-- JS Filter -->
<script>
function filterCars() {
    const searchVal = document.getElementById("searchInput").value.toLowerCase();
    const fuelType = document.getElementById("fuelFilter").value.toLowerCase();
    const priceOption = document.getElementById("priceFilter").value;

    document.querySelectorAll(".car-item").forEach(car => {
        const name = car.getAttribute("data-name");
        const fuel = car.getAttribute("data-fuel");
        const price = parseInt(car.getAttribute("data-price"));

        const matchName = name.includes(searchVal);
        const matchFuel = fuelType === "" || fuel === fuelType;
        let matchPrice = true;

        if (priceOption === "1") matchPrice = price < 1000;
        else if (priceOption === "2") matchPrice = price >= 1000 && price <= 2000;
        else if (priceOption === "3") matchPrice = price > 2000;

        car.style.display = (matchName && matchFuel && matchPrice) ? "block" : "none";
    });
}
</script>

</body>
</html>
