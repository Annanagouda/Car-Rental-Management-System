<?php
require_once('connection.php');

if (isset($_GET['id']) && isset($_GET['bookid'])) {
    $carid = $_GET['id'];
    $book_id = $_GET['bookid'];

    // Get booking details
    $sql2 = "SELECT * FROM booking WHERE BOOK_ID = $book_id";
    $result2 = mysqli_query($con, $sql2);
    $res2 = mysqli_fetch_assoc($result2);

    // Get car details
    $sql = "SELECT * FROM cars WHERE CAR_ID = $carid";
    $result = mysqli_query($con, $sql);
    $res = mysqli_fetch_assoc($result);

    // Proceed with rejection regardless of AVAILABLE status
    $updateCar = "UPDATE cars SET AVAILABLE='Y' WHERE CAR_ID = $carid";
    $updateBooking = "UPDATE booking SET BOOK_STATUS='REJECTED' WHERE BOOK_ID = $book_id";

    mysqli_query($con, $updateCar);
    mysqli_query($con, $updateBooking);

    echo '<script>alert("BOOKING REJECTED SUCCESSFULLY")</script>';
    echo '<script> window.location.href = "adminbook.php";</script>';

} else {
    echo '<script>alert("Missing parameters!")</script>';
    echo '<script> window.location.href = "adminbook.php";</script>';
}
?>
