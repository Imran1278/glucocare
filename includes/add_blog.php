<?php
session_start();
include '../db.php'; // Kyunki ye includes folder mein hai, db bahar hai

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (!isset($_SESSION['patient_name'])) {
        echo "<script>alert('Please login first!'); window.location.href='../user/login.php';</script>";
        exit();
    }

    $patient_name = $_SESSION['patient_name'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $tags = mysqli_real_escape_string($conn, $_POST['tags']);

    // --- IMAGE UPLOAD LOGIC START ---
    $image_name = "default.jpg"; // Agar koi error aye to default image set ho

    if (isset($_FILES['blog_image']) && $_FILES['blog_image']['error'] == 0) {
        
        // IMPORTANT: '../' isliye taake includes folder se nikal kar main uploads folder mein jaye
        $target_dir = "../uploads/"; 
        
        // Folder check karein, agar nahi hai to banayein
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = time() . "_" . basename($_FILES["blog_image"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Sirf images allow karein
        $allowed_types = array("jpg", "jpeg", "png", "webp");
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["blog_image"]["tmp_name"], $target_file)) {
                $image_name = $file_name; // Database mein sirf naam save hoga
            }
        }
    }
    // --- IMAGE UPLOAD LOGIC END ---

    $sql = "INSERT INTO blogs (patient_name, title, content, image, tags) 
            VALUES ('$patient_name', '$title', '$content', '$image_name', '$tags')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Blog Published Successfully!');
                window.location.href='../index.php#blog';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>