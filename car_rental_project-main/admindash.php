<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrator - Feedbacks</title>
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
    .logo {
      font-size: 32px;
      font-weight: bold;
      color: #ff7200;
    }
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
      margin-bottom: 20px;
      text-align: center;
      color: black;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
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
$query = "SELECT * FROM feedback ORDER BY FED_ID DESC LIMIT 50";
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
  <h1 class="header">FEEDBACKS</h1>
  <div class="search-box">
    <input type="text" id="searchInput" onkeyup="filterFeedbacks()" placeholder="Search by Email or Comment...">
  </div>
  <table class="content-table" id="feedbackTable">
    <thead>
      <tr>
        <th>Feedback ID</th>
        <th>Email</th>
        <th>Comment</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($res = mysqli_fetch_array($queryy)) { ?>
        <tr>
          <td><?php echo $res['FED_ID']; ?></td>
          <td><?php echo $res['EMAIL']; ?></td>
          <td><?php echo $res['COMMENT']; ?></td>
          <td><a href="deletefeedback.php?id=<?php echo $res['FED_ID']; ?>" class="btn-delete">DELETE</a></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<script>
  function filterFeedbacks() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#feedbackTable tbody tr");
    rows.forEach(row => {
      const email = row.cells[1].textContent.toLowerCase();
      const comment = row.cells[2].textContent.toLowerCase();
      row.style.display = email.includes(input) || comment.includes(input) ? "" : "none";
    });
  }
</script>
</body>
</html>
