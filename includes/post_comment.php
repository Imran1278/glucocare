<?php
session_start();
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['patient_name'])) {
    $blog_id = mysqli_real_escape_string($conn, $_POST['blog_id']);
    $name = $_SESSION['patient_name'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $sql = "INSERT INTO comments (blog_id, patient_name, comment_text) VALUES ('$blog_id', '$name', '$comment')";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect wapas usi folder ki blog_details file par
        header("Location: blog_details.php?id=" . $blog_id);
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Unauthorized access.";
}
?>