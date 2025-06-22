<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administrator - Users</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      background: url("../images/carbg2.jpg") no-repeat center center fixed;
      background-size: cover;
      color: #333;
      min-height: 100vh;
    }
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 50px;
      background-color: rgba(255, 255, 255, 0.95);
    }
    .logo { font-size: 32px; color: #ff7200; font-weight: bold; }
    .menu ul {
      list-style: none;
      display: flex;
      gap: 30px;
      align-items: center;
    }
    .menu ul li a, .menu button a {
      text-decoration: none;
      color: black;
      font-weight: bold;
      transition: 0.3s;
    }
    .menu button {
      background: #ff7200;
      border: none;
      padding: 8px 16px;
      border-radius: 5px;
    }
    .container {
      padding: 40px 50px;
    }
    h1.header {
      font-size: 36px;
      color: black;
      text-shadow: 2px 2px 4px #000;
      text-align: center;
      margin-bottom: 30px;
    }
    .search-box {
      margin-bottom: 20px;
      text-align: center;
    }
    .search-box input {
      width: 300px;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 16px;
    }
    .content-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 20px rgba(0,0,0,0.15);
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
    .btn-delete {
      background-color: red;
      color: white;
      padding: 6px 12px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }
    .pagination {
      text-align: center;
      margin-top: 20px;
    }
    .pagination button {
      padding: 8px 12px;
      margin: 0 5px;
      border: none;
      background-color: #ff7200;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }
    .pagination button.active {
      background-color: #333;
    }
  </style>
</head>
<body>

<?php
require_once('connection.php');
$query = "SELECT * FROM users";
$result = mysqli_query($con, $query);
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
  <h1 class="header">Users</h1>

  <div class="search-box">
    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search by name or email..." />
  </div>

  <table class="content-table" id="userTable">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>License Number</th>
        <th>Phone Number</th>
        <th>Gender</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody id="userTableBody">
      <?php while ($res = mysqli_fetch_array($result)) { ?>
      <tr>
        <td><?php echo $res['FNAME'] . " " . $res['LNAME']; ?></td>
        <td><?php echo $res['EMAIL']; ?></td>
        <td><?php echo $res['LIC_NUM']; ?></td>
        <td><?php echo $res['PHONE_NUMBER']; ?></td>
        <td><?php echo $res['GENDER']; ?></td>
        <td>
          <button class="btn-delete" onclick="confirmDelete('<?php echo $res['EMAIL']; ?>')">DELETE</button>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <div class="pagination" id="pagination"></div>
</div>

<script>
  // Filter function for search
  function filterTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#userTable tbody tr");
    rows.forEach(row => {
      const name = row.cells[0].textContent.toLowerCase();
      const email = row.cells[1].textContent.toLowerCase();
      row.style.display = name.includes(input) || email.includes(input) ? "" : "none";
    });
  }

  // Delete confirmation
  function confirmDelete(email) {
    if (confirm("Are you sure you want to delete user: " + email + "?")) {
      window.location.href = "deleteuser.php?id=" + encodeURIComponent(email);
    }
  }

  // Initialize
  document.addEventListener("DOMContentLoaded", () => {
    showPage(1);
  });
</script>

</body>
</html>
