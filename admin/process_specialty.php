<?php
include '../db.php';

// Add Specialty
if(isset($_POST['add_spec'])) {
    $name = mysqli_real_escape_string($conn, $_POST['spec_name']);
    $icon = mysqli_real_escape_string($conn, $_POST['spec_icon']);
    $color = mysqli_real_escape_string($conn, $_POST['spec_color']);

    $query = "INSERT INTO specialties (spec_name, spec_icon, spec_color) VALUES ('$name', '$icon', '$color')";
    if(mysqli_query($conn, $query)) {
        header("Location: admin_panel.php?success=SpecialtyAdded");
    }
}

// Delete Specialty
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM specialties WHERE id=$id");
    header("Location: admin_panel.php?deleted");
}
?>