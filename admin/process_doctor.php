<?php
include '../db.php';

// Function to Sync Database with JSON
function syncDoctorsToJson($conn) {
    $res = mysqli_query($conn, "SELECT * FROM doctors ORDER BY id DESC");
    $data = array();
    while ($row = mysqli_fetch_assoc($res)) {
        // Schedule database mein JSON string hoti hai, usay array banayein taake JSON mein clean dikhe
        $row['schedule'] = json_decode($row['schedule'], true); 
        $data[] = $row;
    }
    // JSON_PRETTY_PRINT se file readable format mein save hoti hai
    file_put_contents('../doctors.json', json_encode($data, JSON_PRETTY_PRINT));
}

// ADD DOCTOR
if(isset($_POST['add_doctor'])) {
    // Basic Info
    $name = mysqli_real_escape_string($conn, $_POST['doc_name']);
    $spec = $_POST['doc_specialty'];
    $price = $_POST['doc_price'];
    $avail = $_POST['doc_avail'];
    $bio = mysqli_real_escape_string($conn, $_POST['doc_bio']);
    
    // Nayi Fields
    $exp = mysqli_real_escape_string($conn, $_POST['doc_exp']);
    $university = mysqli_real_escape_string($conn, $_POST['doc_uni']);
    $languages = mysqli_real_escape_string($conn, $_POST['doc_lang']);
    $address = mysqli_real_escape_string($conn, $_POST['doc_address']);
    
    // Contact Info
    $phone = mysqli_real_escape_string($conn, $_POST['doc_phone']);
    $email = mysqli_real_escape_string($conn, $_POST['doc_email']);
    
    // Schedule array ko JSON string mein convert karna database ke liye
    $schedule_json = json_encode($_POST['schedule']);

    // Image Upload Logic
    $image_name = time() . "_" . basename($_FILES["doc_image"]["name"]);
    $target_file = "../uploads/" . $image_name;

    if (move_uploaded_file($_FILES["doc_image"]["tmp_name"], $target_file)) {
        // Query mein saari nayi fields add kar di gayi hain
        $sql = "INSERT INTO doctors (name, specialty, bio, image, phone, email, address, exp, university, languages, price, availability, schedule, patients, awards) 
                VALUES ('$name', '$spec', '$bio', '$image_name', '$phone', '$email', '$address', '$exp', '$university', '$languages', '$price', '$avail', '$schedule_json', '1k+', '5')";
        
        if(mysqli_query($conn, $sql)) {
            syncDoctorsToJson($conn); // Database save hone ke baad JSON update karein
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    header("Location: admin_panel.php?page=doctors");
}

// DELETE DOCTOR
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // Pehle image delete karein folder se
    $img_query = mysqli_query($conn, "SELECT image FROM doctors WHERE id=$id");
    $img_data = mysqli_fetch_assoc($img_query);
    if($img_data && !empty($img_data['image'])) { 
        @unlink("../uploads/".$img_data['image']); 
    }
    
    // Phir database se record delete karein
    mysqli_query($conn, "DELETE FROM doctors WHERE id=$id");
    
    // Phir JSON ko sync karein
    syncDoctorsToJson($conn);
    header("Location: admin_panel.php?page=doctors");
}
?>