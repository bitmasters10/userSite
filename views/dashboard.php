<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../config/database.php';

$user_id = 35; // Replace with $_SESSION['user_id'] when using sessions

$query = "SELECT PICKUP_LOC, LATITUDE, LONGITUDE, BOOK_ID, DATE FROM BOOKING WHERE USER_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];

while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

$stmt->close();
$conn->close();

// Return bookings as a JSON array
header('Content-Type: application/json');
echo json_encode($bookings);
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
    let selectedBookId = null;
    let intervalId = null;

    function fetchOTP() {
        if (!selectedBookId) return;

        const date = new Date().toISOString().split("T")[0]; // Format YYYY-MM-DD
        fetch(`/user/book/${selectedBookId}/${date}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    document.getElementById("otp").value = data[0].OTP;
                    clearInterval(intervalId); // Stop fetching once OTP is found
                }
            })
            .catch(error => console.error("Error fetching OTP:", error));
    }
    const socket = io("http://localhost:3001", {
  reconnectionDelayMax: 10000,
  transports: ["websocket", "polling"],
});

socket.on("connect", () => {
  console.log(`Connected: ${socket.id}`);
});
    function loadBookings() {
        fetch("loadBookings.php") // Load bookings from PHP
            .then(response => response.json())
            .then(bookings => {
                if (bookings.length > 0) {
                    createDropdown(bookings);
                    
                    // If only one booking, automatically select it
                    if (bookings.length === 1) {
                        selectedBookId = bookings[0].BOOK_ID;
                        const dropdown = document.getElementById("bookingDropdown");
                        dropdown.value = selectedBookId;
                        
                        // Trigger interval for OTP and join booking room
                        intervalId = setInterval(fetchOTP, 30000);
                        joinBookingRoom(selectedBookId);
                    }
                } else {
                    console.log("No bookings found.");
                }
            })
            .catch(error => console.error("Error fetching bookings:", error));
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
            intervalId = setInterval(fetchOTP, 30000); // Fetch OTP every 30 seconds
            joinBookingRoom(selectedBookId);
        });
    }

    loadBookings(); // Fetch bookings on page load
});

// Existing socket and location handling code remains the same
function joinBookingRoom(bookingId) {
  if (!bookingId) return;

  let bookingRoom = `booking_${bookingId}`;

  console.log(`Joining room: ${bookingRoom}`);
  socket.emit("rom", bookingRoom);
}
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
    console.log("rom rom");

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
socket.emit("room", room); // Join global room

function joinBookingRoom(bookingId) {
  if (!bookingId) return;

  let bookingRoom = `booking_${bookingId}`;

  console.log(`Joining room: ${bookingRoom}`);
  socket.emit("room", bookingRoom);
}

// Handle receiving car locations from "all" and booking-specific rooms
socket.on("otherloc", (data) => {
  console.log("Location received:", data);
  markCar(data.lat, data.long);
});

// Function to dynamically update the car marker
let carMarker = null;
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

// Detect booking selection and join the room
document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("bookingDropdown")
    ?.addEventListener("change", function () {
      selectedBookId = this.value;
      joinBookingRoom(selectedBookId);
    });
});

</script>

</body>
</html>
