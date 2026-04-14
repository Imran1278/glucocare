<?php
session_start();
include '../db.php'; 

if (isset($_POST['quick_login_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['patient_email']);

    $sql = "SELECT * FROM patients WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Session set karein
        $_SESSION['patient_id'] = $row['id'];
        $_SESSION['patient_name'] = $row['fname']; 

        // SUCCESS MESSAGE SHOW KAREIN PHIR REDIRECT KAREIN
        echo "<script>
                alert('Success: Welcome back, " . $row['fname'] . "! Logging you in...');
                window.location.href='../index.php';
              </script>";
        exit();
        
    } else {
        // ERROR MESSAGE
        echo "<script>
                alert('Error: This email is not registered. Please register first.');
                window.location.href='../user/register.php';
              </script>";
        exit();
    }
}
?>