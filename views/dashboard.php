<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$address = isset($_GET['address']) ? $_GET['address'] : '';
$latitude = isset($_GET['latitude']) ? $_GET['latitude'] : '';
$longitude = isset($_GET['longitude']) ? $_GET['longitude'] : '';

require_once '../config/database.php'; 

$user_id = 20;
//$user_id = $_SESSION['user_id']; // Get user_id from session

$query = "SELECT PICKUP_LOC FROM BOOKING WHERE USER_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_address = $row['PICKUP_LOC'];
} else {
    $current_address = "No address available.";
}
$stmt->close();

$book_id = null;

$query = "SELECT BOOK_ID FROM BOOKING WHERE USER_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($fetched_book_id);

if ($stmt->fetch()) {
    $book_id = $fetched_book_id; // Assign the fetched book_id
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
<input type="text" id="address" value="<?= htmlspecialchars($address ?: $current_address) ?>" readonly>

            <div class="info-container">
                <div class="tooltip"><i style="font-size:24px" class="fa">&#xf05a;</i>
                    <span class="tooltiptext">If you want to change your pickup location you can click the button to update your address</span>
                  </div>                  
               
                <p>Want to update your pickup location? Click below</p>
            </div>
            <a href="updateAdd.php"><button>Update Address</button></a>
            
            <label for="otp">OTP:</label>
            <input type="text" id="otp" readonly>
            <!-- <?php echo $user_id ?> -->
            <input type="hidden" id="booking_id" value="<?php echo htmlspecialchars($book_id); ?>">

        </div>
    </div>
    <script>    
    console.log(document.getElementById('booking_id').value);

    var map = L.map('map').setView([51.505, -0.09], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var latitude = <?php echo $latitude ? $latitude : 'null'; ?>;
    var longitude = <?php echo $longitude ? $longitude : 'null'; ?>;

    if (latitude && longitude) {
        var latlng = [latitude, longitude];
        
        var marker = L.marker(latlng).addTo(map);
        marker.bindPopup("Selected Location: " + "<?php echo $address; ?>").openPopup();

        map.setView(latlng, 13);
    }
</script>

</body>
</html>
