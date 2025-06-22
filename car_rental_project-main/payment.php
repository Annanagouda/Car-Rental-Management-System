<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payment Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.1/css/all.min.css" />
  <style>
    @import url("https://fonts.googleapis.com/css?family=Poppins&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: orange url("images/paym.jpg") center/cover no-repeat;
      overflow: hidden;
    }

    .card {
      margin-left: -500px;
      background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.05));
      box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.5), -1px -1px 2px #aaa, 1px 1px 2px #555;
      backdrop-filter: blur(0.8rem);
      padding: 1.5rem;
      border-radius: 1rem;
      animation: 1s cubic-bezier(0.16, 1, 0.3, 1) cardEnter;
    }

    .card__row {
      display: flex;
      justify-content: space-between;
      padding-bottom: 2rem;
    }

    .card__title {
      font-weight: 500;
      font-size: 2.5rem;
      color: black;
      margin: 1rem 0 1.5rem;
      text-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
    }

    .card__col {
      padding-right: 2rem;
    }

    .card__input {
      background: none;
      border: none;
      border-bottom: dashed 0.2rem rgba(255, 255, 255, 0.15);
      font-size: 1.2rem;
      color: #fff;
      text-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
    }

    .card__input--large {
      font-size: 2rem;
    }

    .card__input::placeholder {
      color: rgba(255, 255, 255, 1);
      text-shadow: none;
    }

    .card__input:focus {
      outline: none;
      border-color: rgba(255, 255, 255, 0.6);
    }

    .card__label {
      display: block;
      color: #fff;
      text-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
      font-weight: 400;
    }

    .card__chip img {
      width: 3rem;
    }

    .card__brand {
      font-size: 3rem;
      color: #fff;
      text-align: right;
      text-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
    }

    @keyframes cardEnter {
      from {
        transform: translateY(100vh);
        opacity: 0.1;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .pay, .btn {
      width: 200px;
      background: #ff7200;
      border: none;
      height: 40px;
      font-size: 18px;
      border-radius: 5px;
      cursor: pointer;
      color: white;
      transition: 0.4s ease;
      margin: 10px 100px 0 0;
    }

    .btn a {
      text-decoration: none;
      color: white;
      font-weight: bold;
    }

    .payment {
      margin-top: -550px;
      margin-left: 1000px;
      color: white;
      font-size: 24px;
      text-shadow: 1px 1px 3px black;
    }
  </style>

  <script>
    function preventBack() {
      window.history.forward();
    }
    setTimeout(preventBack, 0);
    window.onunload = function () { null };
  </script>
</head>
<body>
<?php
  require_once('connection.php');
  session_start();
  $email = $_SESSION['email'];
  $sql = "SELECT * FROM booking WHERE EMAIL='$email' ORDER BY BOOK_ID DESC";
  $cname = mysqli_query($con, $sql);
  $emailData = mysqli_fetch_assoc($cname);
  $bid = $emailData['BOOK_ID'];
  $_SESSION['bid'] = $bid;

  if (isset($_POST['pay'])) {
    $cardno = mysqli_real_escape_string($con, $_POST['cardno']);
    $exp = mysqli_real_escape_string($con, $_POST['exp']);
    $cvv = mysqli_real_escape_string($con, $_POST['cvv']);
    $price = $emailData['PRICE'];

    if (empty($cardno) || empty($exp) || empty($cvv)) {
      echo '<script>alert("Please fill all fields.")</script>';
    } elseif (!preg_match('/^\d{16}$/', $cardno)) {
      echo '<script>alert("Card number must be 16 digits and contain only numbers.")</script>';
    } else {
      $sql2 = "INSERT INTO payment (BOOK_ID, CARD_NO, EXP_DATE, CVV, PRICE)
               VALUES ($bid, '$cardno', '$exp', $cvv, $price)";
      $result = mysqli_query($con, $sql2);
      if ($result) {
        header("Location: psucess.php");
      }
    }
  }
?>

<h2 class="payment">TOTAL PAYMENT : ₹<?php echo $emailData['PRICE']; ?>/-</h2>

<div class="card">
  <form method="POST" id="paymentForm">
    <h1 class="card__title">Enter Payment Information</h1>
    <div class="card__row">
      <div class="card__col">
        <label for="cardNumber" class="card__label">Card Number</label>
        <input type="text" class="card__input card__input--large" id="cardNumber"
               placeholder="Enter 16 digit number"
               name="cardno" maxlength="16"
               inputmode="numeric" pattern="\d{16}" required />
      </div>
      <div class="card__col card__chip">
        <img src="images/chip.svg" alt="chip" />
      </div>
    </div>

    <div class="card__row">
      <div class="card__col">
        <label for="cardExpiry" class="card__label">Expiry Date</label>
        <input type="text" class="card__input" id="cardExpiry" placeholder="MM/YY"
               name="exp" maxlength="5" required pattern="(0[1-9]|1[0-2])\/[0-9]{2}" />
      </div>
      <div class="card__col">
        <label for="cardCcv" class="card__label">CVV</label>
        <input type="password" class="card__input" id="cardCcv"
               placeholder="xxx" name="cvv" maxlength="3"
               pattern="\d{3}" inputmode="numeric" required />
      </div>
      <div class="card__col card__brand"><i id="cardBrand"></i></div>
    </div>

    <input type="submit" value="PAY NOW" class="pay" name="pay" />
    <button type="button" class="btn"><a href="cancelbooking.php">CANCEL</a></button>
  </form>
</div>

<script>
  document.getElementById("paymentForm").addEventListener("submit", function (e) {
    const cardNumber = document.getElementById("cardNumber").value.trim();
    const expiryInput = document.getElementById("cardExpiry").value.trim();
    const cardRegex = /^\d{16}$/;
    const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;

    if (!cardRegex.test(cardNumber)) {
      alert("Please enter a valid 16-digit numeric card number.");
      e.preventDefault();
      return;
    }

    if (!expiryRegex.test(expiryInput)) {
      alert("Please enter expiry date in MM/YY format.");
      e.preventDefault();
      return;
    }

    const [month, year] = expiryInput.split("/").map(Number);
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth() + 1;
    const currentYear = currentDate.getFullYear() % 100;

    if (year < currentYear || (year === currentYear && month < currentMonth)) {
      alert("Card has expired. Please use a valid expiry date.");
      e.preventDefault();
      return;
    }
  });
</script>
</body>
</html>
