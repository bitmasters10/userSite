<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../config/database.php';

// Initialize variables with default values
$user_id = 36; // Replace with $_SESSION['user_id'] when using sessions
$current_address = ""; 
$book_id = ""; 
$latitude = null;
$longitude = null;

// Fetch user bookings
$query = "SELECT PICKUP_LOC, LATITUDE, LONGITUDE, BOOK_ID, DATE FROM BOOKING WHERE USER_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
    
    // If no current address is set, use the first booking's pickup location
    if (empty($current_address)) {
        $current_address = $row['PICKUP_LOC'];
    }
}

$stmt->close();
$conn->close();
include("../includes/header.html");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/myBookings.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>My Bookings</title>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.socket.io/4.7.4/socket.io.min.js"></script>
</head>
<body>
<div class="container">
    <div id="map"></div>

    <div class="info-box">
        <label for="address">Current Address:</label>
        <input type="text" id="address" value="<?php echo htmlspecialchars($current_address); ?>" readonly>

        <div class="info-container">
            <div class="tooltip"><i style="font-size:24px" class="fa">&#xf05a;</i>
                <span class="tooltiptext">If you want to change your pickup location, click the button to update your address</span>
            </div>                  
            <p>Want to update your pickup location? Click below</p>
        </div>
        <button id="updateAddressBtn">Update Address</button>

        <label for="otp">OTP:</label>
        <input type="text" id="otp" readonly>

        <input type="hidden" id="booking_id" value="<?php echo htmlspecialchars($book_id); ?>">    
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Bookings data from PHP
    const bookingsData = <?php echo json_encode($bookings); ?>;

    // Map Initialization
    var map = L.map('map').setView([19.0760, 72.8777], 13); // Default to Mumbai

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Socket Configuration
    const socket = io("http://localhost:3001", {
        reconnectionDelayMax: 10000,
        transports: ["websocket", "polling"],
    });
    
    socket.on("connect", () => {
        console.log(`Connected: ${socket.id}`);
    });
    
    socket.on("connect_error", (error) => {
        console.error("Connection error:", error);
    });

    let room = "all";
    let selectedBookId = null;
    let carMarker = null;

    // Join global room on connection
    socket.on("connect", () => {
        socket.emit("room", room);
    });

    // Function to join booking-specific room
    function joinBookingRoom(bookingId) {
        if (!bookingId) return;

        let bookingRoom = `${bookingId}`;
        console.log(`Joining room: ${bookingRoom}`);
        socket.emit("room", bookingRoom);
    }

    // Handle receiving car locations
    socket.on("otherloc", (data) => {
        console.log("Location received:", data);
        markCar(data.lat, data.long);
    });

    // Function to mark car on map
    function markCar(lat, long) {
        const carIcon = L.icon({
            iconUrl: "../assets/img/car.jpg",
            iconSize: [50, 50],
            iconAnchor: [25, 50],
            popupAnchor: [0, -50],
        });

        if (carMarker) {
            carMarker.setLatLng([lat, long]); // Update existing marker
        } else {
            carMarker = L.marker([lat, long], { icon: carIcon }).addTo(map);
            carMarker.bindPopup("Car is here.").openPopup();
        }
    }

    // OTP and Booking Logic
    let intervalId = null;

    function fetchOTP() {
        if (!selectedBookId) return;
console.log("test")
        const date = new Date().toISOString().split("T")[0];
        fetch(`http://localhost:3000/user/book/${selectedBookId}/${date}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    document.getElementById("otp").value = data[0].OTP;
                    clearInterval(intervalId);
                }
            })
            .catch(error => console.error("Error fetching OTP:", error));
    }

    function createDropdown(bookings) {
        const container = document.querySelector(".info-box");

        const label = document.createElement("label");
        label.textContent = "Select Booking:";
        container.appendChild(label);

        const dropdown = document.createElement("select");
        dropdown.id = "bookingDropdown";
        container.appendChild(dropdown);

        bookings.forEach(booking => {
            let option = document.createElement("option");
            option.value = booking.BOOK_ID;
            option.textContent = `Booking ${booking.BOOK_ID} - ${booking.DATE}`;
            dropdown.appendChild(option);
        });

        dropdown.addEventListener("change", function () {
            selectedBookId = this.value;
            if (intervalId) clearInterval(intervalId);
            intervalId = setInterval(fetchOTP, 30000);
            joinBookingRoom(selectedBookId);
        });

        // If only one booking, auto-select
        if (bookings.length === 1) {
            dropdown.value = bookings[0].BOOK_ID;
            dropdown.dispatchEvent(new Event('change'));
        }
    }

    // Initial dropdown creation if bookings exist
    if (bookingsData.length > 0) {
        createDropdown(bookingsData);
    }

    // Update Address Button
    document.getElementById('updateAddressBtn').addEventListener('click', function() {
        // Implement address update logic here
        alert('Address update functionality to be implemented');
    });
});
</script>

</body>
</html>