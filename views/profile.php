<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
include("../includes/header.html");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Profile</title>
</head>
<body>
<div class="top-bar">
    <h1>Welcome!</h1>
    <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    <form action="../logout.php" method="post">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>
</body>
</html>