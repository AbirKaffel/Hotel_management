<?php

include('db_connect.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $room_num = mysqli_real_escape_string($conn, $_POST['room_num']);
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $room_price = mysqli_real_escape_string($conn, $_POST['room_price']);
    $room_capacity = mysqli_real_escape_string($conn, $_POST['room_capacity']);
    $room_status = 'disponible'; 

    
    $image_path = NULL; 
    if (isset($_FILES['room_image']) && $_FILES['room_image']['error'] == 0) {
        
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jfif', 'image/webp']; 
        $file_type = $_FILES['room_image']['type'];

        
        if (!in_array($file_type, $allowed_types)) {
            echo "<p class='alert alert-danger'>Invalid image type. Please upload a JPEG, PNG, GIF, JFIF, webp image.</p>";
            exit;
        }

        
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['room_image']['name']);
        $target_file = $upload_dir . uniqid() . '-' . $file_name;
        
        if (move_uploaded_file($_FILES['room_image']['tmp_name'], $target_file)) {
            $image_path = $target_file; 
        } else {
            echo "<p class='alert alert-danger'>Failed to upload image.</p>";
            exit;
        }
    }

    
    $query = "INSERT INTO chambres (`numero`, `type`, `prix`, `capacite`, `statut`, `image`) 
              VALUES ('$room_num', '$room_type', '$room_price', '$room_capacity', '$room_status', '$image_path')";
    
    if (mysqli_query($conn, $query)) {
        echo "<p class='alert alert-success'>Room added successfully!</p>";
    } else {
        echo "<p class='alert alert-danger'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Hotel Management</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="home.html">Home</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="index.php">Reservation</a>
                </li>
            <li class="nav-item active">
                <a class="nav-link" href="room_add.php">Add Room</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Admin Dashboard</a>
            </li>
        </ul>
    </div>
</nav>


<div class="container mt-4">
    <h1 class="text-center">Add New Room</h1>
    <form method="POST" action="room_add.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="room_num">Room Number</label>
            <input type="text" class="form-control" id="room_num" name="room_num" required>
        </div>
        <div class="form-group">
            <label for="room_type">Room Type</label>
            <input type="text" class="form-control" id="room_type" name="room_type" required>
        </div>
        <div class="form-group">
            <label for="room_price">Price</label>
            <input type="number" step="0.01" class="form-control" id="room_price" name="room_price" required>
        </div>
        <div class="form-group">
            <label for="room_capacity">Capacity</label>
            <input type="number" class="form-control" id="room_capacity" name="room_capacity" required>
        </div>
        <div class="form-group">
            <label for="room_image">Room Image</label>
            <input type="file" class="form-control" id="room_image" name="room_image" accept="image/jpeg, image/png, image/gif, image/jfif">
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:20px">Add Room</button>
    </form>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
