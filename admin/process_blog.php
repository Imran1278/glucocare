<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    exit("Access Denied");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Pehle image ka naam nikalte hain taake folder se bhi delete ho jaye
    $query = mysqli_query($conn, "SELECT image FROM blogs WHERE id = $id");
    $data = mysqli_fetch_assoc($query);
    
    if ($data['image'] != 'default.jpg') {
        unlink("../uploads/" . $data['image']);
    }

    mysqli_query($conn, "DELETE FROM blogs WHERE id = $id");
    header("Location: admin_panel.php");
    exit();
}
?>