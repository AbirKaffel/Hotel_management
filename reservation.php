<?php

session_start();


include('db_connect.php');


if (!isset($_SESSION['user_id'])) {
    
    header("Location: login.php");
    exit();  
}


if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];

    
    $query = "SELECT * FROM chambres WHERE ID = '$room_id'";
    $result = mysqli_query($conn, $query);

    
    if (mysqli_num_rows($result) > 0) {
        $room = mysqli_fetch_assoc($result);
    } else {
        $error_message = "Room not found.";
    }
} else {
    $error_message = "No room selected.";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $client_name = $_POST['client_name'];
    $client_email = $_POST['client_email'];

    
    if ($room['statut'] == 'disponible') {
        
        $check_reservation_query = "
            SELECT * FROM reservations 
            WHERE chambre_id = '$room_id' 
            AND (
                (date_debut BETWEEN '$start_date' AND '$end_date') 
                OR (date_fin BETWEEN '$start_date' AND '$end_date') 
                OR ('$start_date' BETWEEN date_debut AND date_fin)
            )
        ";
        $check_reservation_result = mysqli_query($conn, $check_reservation_query);

        if (mysqli_num_rows($check_reservation_result) > 0) {
            
            $error_message = "Sorry, this room is already reserved during the selected dates. Please try different dates or choose another room.";
        } else {
            
            $check_client_query = "SELECT ID FROM clients WHERE email = '$client_email' OR nom = '$client_name'";
            $check_result = mysqli_query($conn, $check_client_query);

            if (mysqli_num_rows($check_result) > 0) {
                
                $client = mysqli_fetch_assoc($check_result);
                $client_id = $client['ID'];
            } else {
                
                $insert_client_query = "INSERT INTO clients (nom, email) VALUES ('$client_name', '$client_email')";
                if (mysqli_query($conn, $insert_client_query)) {
                    
                    $client_id = mysqli_insert_id($conn);
                } else {
                    $error_message = "Error with client creation: " . mysqli_error($conn);
                }
            }

            
            if (!isset($error_message)) {
                $insert_reservation_query = "INSERT INTO reservations (chambre_id, client_id, date_debut, date_fin) 
                                             VALUES ('$room_id', '$client_id', '$start_date', '$end_date')";

                if (mysqli_query($conn, $insert_reservation_query)) {
                    
                    $update_room_status_query = "UPDATE chambres SET statut = 'occupée' WHERE ID = '$room_id'";
                    mysqli_query($conn, $update_room_status_query);

                    $success_message = "Reservation successful!";
                } else {
                    $error_message = "Error with reservation: " . mysqli_error($conn);
                }
            }
        }
    } else {
        $error_message = "This room is currently not available.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation - Hotel Management</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Hotel Management</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.html">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="reservation.php">Reservation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    
    <div class="container mt-4">
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger text-center">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($room)): ?>
            <h1 class="text-center">Reserve Room: <?php echo htmlspecialchars($room['type']); ?></h1>

            <?php if (isset($success_message)): ?>
                <div class="alert alert-success text-center">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            
            <form action="reservation.php?room_id=<?php echo $room_id; ?>" method="POST">
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>

                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>

                <div class="form-group">
                    <label for="client_name">Your Name</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" required>
                </div>

                <div class="form-group">
                    <label for="client_email">Your Email</label>
                    <input type="email" class="form-control" id="client_email" name="client_email" required>
                </div>

                <button type="submit" class="btn btn-success" style="margin-top:20px">Submit Reservation</button>
            </form>
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
