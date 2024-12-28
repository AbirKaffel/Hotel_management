<?php
session_start();
include('db_connect.php');


if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    
    $query = "SELECT * FROM clients WHERE email = ? LIMIT 1";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            
            $client = mysqli_fetch_assoc($result);

           
            if (password_verify($password, $client['password'])) {
                
                $_SESSION['user_id'] = $client['id'];
                $_SESSION['user_role'] = $client['role']; 
                $_SESSION['user_name'] = $client['nom'];

                
                if ($_SESSION['user_role'] == 'admin') {
                    header('Location: admin.php'); 
                } else {
                    header('Location: index.php'); 
                }
                exit;
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "No client found with that email!";
        }

        
        mysqli_stmt_close($stmt);
    } else {
        $error = "Database error: unable to prepare query.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
        
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Hotel Management</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="client_register.php">Register Now</a>
                </li>
                <a class="nav-link" href="index.php">Reservation</a>
                </li>

            </ul>
        </div>
    </nav>


<div class="container mt-5">
    <h1 class="text-center">Login</h1>
    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:20px">Login</button>
    </form>

    <?php if (isset($error)) { echo "<p class='alert alert-danger mt-3'>$error</p>"; } ?>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
