<?php

session_start();


include('db_connect.php');


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    
    header('Location: login.php');
    exit;
}


if (isset($_POST['action']) && isset($_POST['id'])) {
    $action = $_POST['action'];
    $reservation_id = $_POST['id'];

    
    if (empty($reservation_id) || !in_array($action, ['confirm', 'cancel'])) {
        echo json_encode(["error" => "Invalid action or reservation ID."]);
        exit();
    }

    
    $new_status = ($action === 'confirm') ? 'confirmée' : 'annulée';

    $update_query = "UPDATE reservations SET statut = ? WHERE id = ?";

    
    if ($stmt = $conn->prepare($update_query)) {
        
        $stmt->bind_param("si", $new_status, $reservation_id);

        
        if ($stmt->execute()) {
            
            echo json_encode(["success" => "Status updated successfully.", "new_status" => $new_status]);
        } else {
            echo json_encode(["error" => "Error updating reservation status: " . $stmt->error]);
        }

        
        $stmt->close();
    } else {
        echo json_encode(["error" => "Failed to prepare query: " . $conn->error]);
    }
    exit();
}


$query = "SELECT reservations.id, clients.nom as client_name, chambres.type as room_type, 
                 reservations.date_debut, reservations.date_fin, 
                 chambres.statut as room_status, reservations.statut as reservation_status
          FROM reservations 
          JOIN clients ON reservations.client_id = clients.id 
          JOIN chambres ON reservations.chambre_id = chambres.id";
$result = $conn->query($query);


if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Hotel Management</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Reservation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="room_add.php">Add room</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="admin.php">Admin Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>

            </ul>
        </div>
    </nav>

    
    <div class="container mt-4">
        <h1 class="text-center">Admin Dashboard</h1>

        <h3>Reservations</h3>

        <?php if ($result->num_rows == 0) { ?>
            <p>No reservations found.</p>
        <?php } else { ?>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Room Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Room Status</th>
                        <th>Reservation Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($reservation = $result->fetch_assoc()) { ?>
                        <tr id="reservation-<?php echo $reservation['id']; ?>">
                            <td><?php echo htmlspecialchars($reservation['client_name']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['room_type']); ?></td>
                            <td><?php echo date("d-m-Y", strtotime($reservation['date_debut'])); ?></td>
                            <td><?php echo date("d-m-Y", strtotime($reservation['date_fin'])); ?></td>
                            <td><span class="badge badge-warning">Occupée</span></td>
                            <td id="status-<?php echo $reservation['id']; ?>">
                                <?php
                                switch ($reservation['reservation_status']) {
                                    case 'confirmée':
                                        echo '<span class="badge badge-success">Confirmée</span>';
                                        break;
                                    case 'annulée':
                                        echo '<span class="badge badge-danger">Annulée</span>';
                                        break;
                                    case 'en_attente':
                                        echo '<span class="badge badge-warning">En attente</span>';
                                        break;
                                    default:
                                        echo '<span class="badge badge-secondary">Statut inconnu</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($reservation['reservation_status'] === 'en_attente') { ?>
                                    <button class="btn btn-success btn-sm" onclick="updateStatus(<?php echo $reservation['id']; ?>, 'confirm')">Confirm</button>
                                    <button class="btn btn-danger btn-sm" onclick="updateStatus(<?php echo $reservation['id']; ?>, 'cancel')">Cancel</button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <script>
        function updateStatus(reservationId, action) {
            $.ajax({
                url: 'admin.php', 
                method: 'POST',
                data: { action: action, id: reservationId },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        var newStatusHtml = action === 'confirm' 
                            ? '<span class="badge badge-success">Confirmée</span>' 
                            : '<span class="badge badge-danger">Annulée</span>';
                        $('#status-' + reservationId).html(newStatusHtml);
                        $('#reservation-' + reservationId + ' .btn').prop('disabled', true);
                    } else {
                        alert(result.error);
                    }
                },
                error: function() {
                    alert("An error occurred while processing your request.");
                }
            });
        }
    </script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
