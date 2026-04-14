<?php
session_start();
include '../db.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../user/login.php");
    exit();
}

if (isset($_POST['book_now'])) {
    // 1. Basic Data Get karein
    $patient_id    = $_SESSION['patient_id'];
    $doctor_id     = mysqli_real_escape_string($conn, $_POST['doctor_id']);
    $patient_phone = mysqli_real_escape_string($conn, $_POST['patient_phone']);
    $app_date      = mysqli_real_escape_string($conn, $_POST['app_date']);
    $app_time      = mysqli_real_escape_string($conn, $_POST['app_time']);
    $app_notes     = mysqli_real_escape_string($conn, $_POST['app_notes']);
    $app_location  = mysqli_real_escape_string($conn, $_POST['app_location']);
    
    // 2. Doctor ki Fee JSON se nikaalein
    $json_data = file_get_contents("../doctors.json");
    $doctors = json_decode($json_data, true);
    $fee = "0.00"; 
    
    foreach ($doctors as $doc) {
        if ($doc['id'] == $doctor_id) {
            $fee = $doc['price'];
            break;
        }
    }

    // 3. App Type set karein
    $app_type = "In-Clinic";

    // 4. Validation
    if(empty($app_date) || empty($app_time)) {
        echo "<script>alert('Error: Please select a valid date and time slot.'); window.history.back();</script>";
        exit();
    }

    if(empty($app_location)) {
        $app_location = "Main Clinic"; 
    }

    // 5. Insert Query
    $query = "INSERT INTO appointments (doctor_id, patient_id, patient_phone, app_date, app_time, app_type, app_notes, fee, status, app_location) 
              VALUES ('$doctor_id', '$patient_id', '$patient_phone', '$app_date', '$app_time', '$app_type', '$app_notes', '$fee', 'Pending', '$app_location')";

    if (mysqli_query($conn, $query)) {
        // Success Message (Simple Alert)
        echo "<script>
                alert('Appointment Booked Successfully!\\nDate: $app_date\\nTime: $app_time\\nLocation: $app_location');
                window.location.href = '../user/my_appointments.php'; 
              </script>";
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>