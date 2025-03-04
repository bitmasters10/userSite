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
