<?php

include('db_connect.php');
session_start();


$query = "SELECT * FROM chambres";
$result = mysqli_query($conn, $query);


if(mysqli_num_rows($result) == 0) {
    $no_rooms_message = "Currently, no rooms are available. Please check back later.";
}


if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management - Reservations</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Hotel Management</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            
            <li class="nav-item active">
                <a class="nav-link" href="home.html">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Reservation</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="home.html#contact">Contact</a>
            </li>
        </ul>

        
        <ul class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['user_role'] == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Admin Dashboard</a>
                    </li>
                <?php endif; ?>
                
                <li class="nav-item">
                    <a class="nav-link" href="?logout=true">Logout</a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="client_register.php">Register Now</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>


    
    <div class="container mt-4">
        <h1 class="text-center">Welcome to Our Hotel</h1>
        <p class="text-center">Find your perfect room and book it online!</p>
        
        
        <?php if (isset($no_rooms_message)): ?>
            <div class="alert alert-warning text-center">
                <?php echo htmlspecialchars($no_rooms_message); ?>
            </div>
        <?php else: ?>
            
            <div class="row">
                <?php while ($room = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            
                            <img src="<?php echo htmlspecialchars($room['image']) ? htmlspecialchars($room['image']) : 'assets/images/default_room.jpg'; ?>" class="card-img-top" alt="Room Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($room['type']); ?></h5>
                                <p class="card-text">Price: <?php echo htmlspecialchars($room['prix']); ?> €</p>
                                <p class="card-text">Capacity: <?php echo htmlspecialchars($room['capacite']); ?> people</p>
                                <p class="card-text">Status: Available</p>
                                <a href="reservation.php?room_id=<?php echo urlencode($room['id']); ?>" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

    
    <footer class="bg-light py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 Hotel Management. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
