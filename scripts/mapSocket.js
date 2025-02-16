console.log("rom rom");
const socket = io("http://192.168.66.115:3001", {
    reconnectionDelayMax: 10000,
    transports: ['websocket', 'polling'] // Add transport options
});
socket.on("connect",()=>{
    console.log(socket.id);
})
let room ="all";
socket.emit("rom",room )
socket.on("otherloc", (data) => {
    console.log(data);
    markcar(data.lat,data.long)
});
function sendloc(lat,long){
    socket.emit("loc",{room:room,lat:lat,long:long})
   
}
function markcar(lat,long){
    // Define the custom icon for the car
const carIcon = L.icon({
    iconUrl: '../assets/img/car.jpg', 
    iconSize: [50, 50], // Set the size of the icon (width, height)
    iconAnchor: [25, 50], // Anchor the icon to its center
    popupAnchor: [0, -50] // Position the popup above the icon
});

// Coordinates for the car marker
const carLocation = [lat, long]; // Replace with the actual coordinates

// Create the car marker with the custom icon and add it to the map
let carMarker = L.marker(carLocation, { icon: carIcon }).addTo(map);

// Optionally, bind a popup to the car marker
carMarker.bindPopup("Car is here.").openPopup();

}
