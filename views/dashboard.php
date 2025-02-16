<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../config/database.php';

$user_id = 20;
//$user_id = $_SESSION['user_id']; // Get user_id from session
$query = "SELECT PICKUP_LOC, LATITUDE, LONGITUDE, BOOK_ID FROM BOOKING WHERE USER_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_address = $row['PICKUP_LOC'];
    $latitude = $row['LATITUDE'];
    $longitude = $row['LONGITUDE'];
    $book_id = $row['BOOK_ID'];
} else {
    $current_address = "No address available.";
    $latitude = null;
    $longitude = null;
    $book_id = null;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dashboard</title>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.socket.io/4.7.4/socket.io.min.js"></script>
    <script src="../scripts/mapSocket.js"></script>
</head>
<body>

<div class="top-bar">
    <h1>Welcome!</h1>
    <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    <form action="../logout.php" method="post">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>
<div class="container">
    <div id="map"></div>

    <div class="info-box">
        <label for="address">Current Address:</label>
        <input type="text" id="address" value="<?= htmlspecialchars($current_address) ?>" readonly>

        <div class="info-container">
            <div class="tooltip"><i style="font-size:24px" class="fa">&#xf05a;</i>
                <span class="tooltiptext">If you want to change your pickup location, click the button to update your address</span>
            </div>                  
            <p>Want to update your pickup location? Click below</p>
        </div>
        <button id="updateAddressBtn">Update Address</button>

        <label for="otp">OTP:</label>
        <input type="text" id="otp" readonly>

        <input type="hidden" id="booking_id" value="<?= htmlspecialchars($book_id); ?>">    
    </div>
</div>

<script>    
    document.addEventListener("DOMContentLoaded", function () {
        var bookId = document.getElementById('booking_id').value;
        console.log("Booking ID:", bookId);

        function redirectToUpdate() {
            if (bookId) {
                window.location.href = "updateAdd.html?book_id=" + bookId;
            } else {
                alert("No booking ID found.");
            }
        }

        document.getElementById("updateAddressBtn").addEventListener("click", redirectToUpdate);
    });

    var map = L.map('map').setView([51.505, -0.09], 13); // Default view

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    <?php if ($latitude && $longitude): ?>
        var latitude = <?= json_encode($latitude) ?>;
        var longitude = <?= json_encode($longitude) ?>;
        var currentAddress = <?= json_encode($current_address) ?>;

        var marker = L.marker([latitude, longitude]).addTo(map)
            .bindPopup(currentAddress).openPopup();
        map.setView([latitude, longitude], 13);
    <?php endif; ?>

</script>

</body>
</html>
