<?php
// Step 1: Session ko access karein
session_start();

// Step 2: Saare session variables ko khali (unset) karein
$_SESSION = array();

// Step 3: Agar session cookie use ho rahi hai to use khatam karein (Optional but Professional)
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Step 4: Session ko server se puri tarah destroy/khatam karein
session_destroy();

// Step 5: User ko login page par redirect karein
// Aap yahan index.php bhi likh sakte hain agar aap home page par bhejna chahte hain
header("Location: ../index.php");
exit();
?>