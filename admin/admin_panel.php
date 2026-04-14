<?php
    session_start();
    include '../db.php';

    if (!isset($_SESSION['admin_id'])) {
        header("Location: admin_login.php");
        exit();
    }
    $page = $_GET['page'] ?? 'doctors';

    /* ---------- STATUS UPDATE ---------- */
    if (isset($_GET['action'], $_GET['id'])) {
        $id = intval($_GET['id']);
        $status = ($_GET['action'] === 'approve') ? 'Confirmed' : 'Rejected';
        mysqli_query($conn, "UPDATE appointments SET status='$status' WHERE id=$id");
        header("Location: admin_panel.php?page=appointments");
        exit();
    }

    /* ---------- COUNTS ---------- */
    $total_doctors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM doctors"))['total'];
    $total_specs   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM specialties"))['total'];
    $total_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM appointments WHERE status='Pending'"))['total'];
    $total_nav     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM site_settings WHERE setting_type='link'"))['total'];
    $total_blogs   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM blogs"))['total'];
    $total_contact = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM site_info"))['total'];
    $total_hero = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM hero_settings"))['total'];
    $total_appliance = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM appliance_settings"))['total'];
    $total_footer = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM footer_settings"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlucoCare | Admin Dashboard</title>
    <link rel="icon" href="../pics/logo.png">
    <link rel="stylesheet" href="../styles/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
</head>
<body>

    <!-- SIDEBAR -->
    <?php 
        include 'admin_sidebar.php'; 
    ?>

    <!-- CONTENTS -->
    <?php   

        if($page == 'doctors'){
            include 'admin_doctors.php';
        }
        elseif($page == 'contact_settings'){
            include 'admin_contact.php';
        }
        elseif($page == 'appointments'){
            include 'admin_appointments.php';
        }
        elseif($page == 'specs'){
            include 'admin_specialty.php';
        }
        elseif($page == 'blogs'){
            include 'admin_blogs.php';
        }
        elseif($page == 'header_settings'){
            include 'admin_header.php';
        }
        elseif($page == 'hero_settings'){
            include 'admin_hero.php';
        }
        elseif($page == 'appliance_settings'){
            include 'admin_appliance.php';
        }
        elseif($page == 'footer_settings'){
            include 'admin_footer.php';
        }

    ?>


</body>
</html>