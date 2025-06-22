<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administrator - Cars</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      background: url("../images/carbg2.jpg") no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      color: #333;
    }
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: rgba(255, 255, 255, 0.9);
      padding: 15px 50px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .logo { font-size: 32px; font-weight: bold; color: #ff7200; }
    .menu ul {
      list-style: none;
      display: flex;
      gap: 30px;
    }
    .menu ul li a,
    .menu ul li button a {
      text-decoration: none;
      color: black;
      font-weight: bold;
      transition: 0.3s;
    }
    .menu ul li a:hover { color: #ff7200; }
    .menu button {
      background-color: #ff7200;
      border: none;
      padding: 8px 16px;
      border-radius: 5px;
      cursor: pointer;
    }
    .container {
      padding: 40px 50px;
    }
    h1.header {
      font-size: 36px;
      margin-bottom: 30px;
      text-align: center;
      color: black;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .add {
      display: block;
      margin: 0 auto 30px auto;
      background: #ff7200;
      color: white;
      font-size: 16px;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .add a {
      text-decoration: none;
      color: white;
      font-weight: bold;
    }
    .search-box {
      text-align: center;
      margin-bottom: 20px;
    }
    .search-box input {
      width: 300px;
      padding: 8px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .content-table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
      border-radius: 10px;
      overflow: hidden;
    }
    .content-table thead {
      background-color: orange;
      color: white;
    }
    .content-table th, .content-table td {
      padding: 12px 15px;
      text-align: left;
    }
    .content-table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .btn-delete,
    .btn-edit {
      padding: 6px 12px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }
    .btn-delete {
      background-color: red;
      color: white;
    }
    .btn-edit {
      background-color: #007bff;
      color: white;
    }
    @media (max-width: 768px) {
      .navbar, .menu ul {
        flex-direction: column;
        align-items: flex-start;
      }
      .menu ul { gap: 10px; }
      .container { padding: 20px; }
      .content-table { font-size: 12px; }
    }
  </style>
</head>
<body>

<?php
require_once('connection.php');
$query = "SELECT * FROM cars";
$queryy = mysqli_query($con, $query);
?>

<div class="navbar">
  <div class="logo">CaRs</div>
  <div class="menu">
    <ul>
      <li><a href="adminvehicle.php">VEHICLE MANAGEMENT</a></li>
      <li><a href="adminusers.php">USERS</a></li>
      <li><a href="admindash.php">FEEDBACKS</a></li>
      <li><a href="adminbook.php">BOOKING REQUEST</a></li>
      <li><button><a href="index.php">LOGOUT</a></button></li>
    </ul>
  </div>
</div>

<div class="container">
  <h1 class="header">CARS</h1>
  <button class="add"><a href="addcar.php">+ ADD CARS</a></button>
  <div class="search-box">
    <input type="text" id="searchInput" onkeyup="filterCars()" placeholder="Search by Name or Fuel Type...">
  </div>

  <table class="content-table" id="carTable">
    <thead>
      <tr>
        <th>CAR ID</th>
        <th>CAR NAME</th>
        <th>FUEL TYPE</th>
        <th>CAPACITY</th>
        <th>PRICE</th>
        <th>AVAILABLE</th>
        <th>EDIT</th>
        <th>DELETE</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($res = mysqli_fetch_array($queryy)) { ?>
      <tr>
        <td><?php echo $res['CAR_ID']; ?></td>
        <td><?php echo $res['CAR_NAME']; ?></td>
        <td><?php echo $res['FUEL_TYPE']; ?></td>
        <td><?php echo $res['CAPACITY']; ?></td>
        <td><?php echo $res['PRICE']; ?></td>
        <td><?php echo $res['AVAILABLE'] == 'Y' ? 'YES' : 'NO'; ?></td>
        <td>
          <a href="editcar.php?id=<?php echo $res['CAR_ID']; ?>" class="btn-edit">EDIT</a>
        </td>
        <td>
          <a href="deletecar.php?id=<?php echo $res['CAR_ID']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this car?')">DELETE</a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script>
  function filterCars() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#carTable tbody tr");
    rows.forEach(row => {
      const name = row.cells[1].textContent.toLowerCase();
      const fuel = row.cells[2].textContent.toLowerCase();
      row.style.display = name.includes(input) || fuel.includes(input) ? "" : "none";
    });
  }
</script>

</body>
</html>
