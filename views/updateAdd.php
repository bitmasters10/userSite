<?php
session_start();
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "User not logged in."]);
        exit();
    }

    if (!isset($_POST['address']) || !isset($_POST['latitude']) || !isset($_POST['longitude'])) {
        echo json_encode(["status" => "error", "message" => "Invalid data received."]);
        exit();
    }

    // $user_id = $_SESSION['user_id'];
    $user_id = 20;
    $book_id = $_POST['book_id'];
    $address = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $query = "UPDATE BOOKING SET PICKUP_LOC = ?, LATITUDE = ?, LONGITUDE = ? WHERE USER_ID = ? AND BOOK_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssii", $address, $latitude, $longitude, $user_id, $book_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Location updated successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update location."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>