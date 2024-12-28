<?php

include('db_connect.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $client_last_name = mysqli_real_escape_string($conn, $_POST['client_last_name']);  
    $client_first_name = mysqli_real_escape_string($conn, $_POST['client_first_name']); 
    $client_email = mysqli_real_escape_string($conn, $_POST['client_email']);
    $client_phone = mysqli_real_escape_string($conn, $_POST['client_phone']);
    $client_password = mysqli_real_escape_string($conn, $_POST['client_password']); 

    
    $hashed_password = password_hash($client_password, PASSWORD_DEFAULT);

    
    $query = "INSERT INTO clients (nom, prenom, email, telephone, password) 
              VALUES ('$client_last_name', '$client_first_name', '$client_email', '$client_phone', '$hashed_password')";
    if (mysqli_query($conn, $query)) {
        
        $client_id = mysqli_insert_id($conn);

        
        echo "<p class='alert alert-success'>Registration successful! Thank you for signing up.</p>";
    } else {
        echo "<p class='alert alert-danger'>Error saving client information. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registration</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Hotel Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Reservation</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="client_register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    
    <div class="container mt-4">
        <h1 class="text-center">Client Registration</h1>
        
        
        <form method="POST" action="client_register.php">
            <div class="form-group">
                <label for="client_last_name">Last Name</label>
                <input type="text" class="form-control" id="client_last_name" name="client_last_name" required>
            </div>
            <div class="form-group">
                <label for="client_first_name">First Name</label>
                <input type="text" class="form-control" id="client_first_name" name="client_first_name" required>
            </div>
            <div class="form-group">
                <label for="client_email">Email</label>
                <input type="email" class="form-control" id="client_email" name="client_email" required>
            </div>
            <div class="form-group">
                <label for="client_phone">Phone</label>
                <input type="text" class="form-control" id="client_phone" name="client_phone" required>
            </div>
            <div class="form-group">
                <label for="client_password">Password</label>
                <input type="password" class="form-control" id="client_password" name="client_password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top:20px">Register</button>
        </form>
    </div>

    
    <footer class="bg-light py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 Hotel Management. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
