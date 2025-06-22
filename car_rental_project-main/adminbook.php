<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administrator - Bookings</title>
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
    .search-box {
      margin-bottom: 20px;
      text-align: center;
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
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
    }
    .content-table thead {
      background-color: orange;
      color: white;
      text-align: left;
    }
    .content-table th,
    .content-table td {
      padding: 12px 15px;
    }
    .content-table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .action-btn {
      padding: 6px 12px;
      border-radius: 5px;
      font-weight: bold;
      text-decoration: none;
      color: white;
    }
    .btn-approve { background-color: green; }
    .btn-reject { background-color: red; border: none; }
    .btn-returned { background-color: #007bff; }
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
    @media (max-width: 768px) {
      .navbar, .menu ul {
        flex-direction: column;
        align-items: flex-start;
      }
      .menu ul { gap: 10px; }
      .container { padding: 20px; }
      .content-table { font-size: 12px; }
      .search-box input { width: 90%; }
    }
  </style>
</head>
<body>
  <?php
    require_once('connection.php');
    $query = "SELECT * FROM booking ORDER BY BOOK_ID DESC";
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
    <h1 class="header">Bookings</h1>
    <div class="search-box">
      <input type="text" id="searchInput" placeholder="Search by Email or Status..." onkeyup="filterTable()" />
    </div>
    <table class="content-table" id="bookingTable">
      <thead>
        <tr>
          <th>CAR ID</th>
          <th>EMAIL</th>
          <th>BOOK PLACE</th>
          <th>BOOK DATE</th>
          <th>DURATION</th>
          <th>PHONE NUMBER</th>
          <th>DESTINATION</th>
          <th>RETURN DATE</th>
          <th>BOOKING STATUS</th>
          <th>APPROVE</th>
          <th>REJECT</th>
          <th>RETURNED</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($res = mysqli_fetch_array($queryy)) { ?>
          <tr>
            <td><?php echo $res['CAR_ID']; ?></td>
            <td><?php echo $res['EMAIL']; ?></td>
            <td><?php echo $res['BOOK_PLACE']; ?></td>
            <td><?php echo $res['BOOK_DATE']; ?></td>
            <td><?php echo $res['DURATION']; ?></td>
            <td><?php echo $res['PHONE_NUMBER']; ?></td>
            <td><?php echo $res['DESTINATION']; ?></td>
            <td><?php echo $res['RETURN_DATE']; ?></td>
            <td><?php echo $res['BOOK_STATUS']; ?></td>
            <td><a href="approve.php?id=<?php echo $res['BOOK_ID']; ?>" class="action-btn btn-approve">APPROVE</a></td>
            <td>
              <form action="Reject.php" method="GET">
                <input type="hidden" name="id" value="<?php echo $res['CAR_ID']; ?>">
                <input type="hidden" name="bookid" value="<?php echo $res['BOOK_ID']; ?>">
                <button type="submit" class="action-btn btn-reject">REJECT</button>
              </form>
            </td>
            <td><a href="adminreturn.php?id=<?php echo $res['CAR_ID']; ?>&bookid=<?php echo $res['BOOK_ID']; ?>" class="action-btn btn-returned">RETURNED</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="pagination" id="pagination"></div>
  </div>

  <script>
    function filterTable() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const rows = document.querySelectorAll("#bookingTable tbody tr");
      rows.forEach(row => {
        const email = row.cells[1].textContent.toLowerCase();
        const status = row.cells[8].textContent.toLowerCase();
        row.style.display = email.includes(input) || status.includes(input) ? "" : "none";
      });
    }
  </script>
</body>
</html>
