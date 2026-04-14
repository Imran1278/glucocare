<?php
session_start();
include '../db.php';
$msg = "";

// Agar admin pehle se login hai, toh dashboard bhejo
if (isset($_SESSION['admin_id'])) {
    header("Location: admin_panel.php");
    exit();
}

if (isset($_POST['login'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // 1. Check karein ke kya pehle se koi admin maujood hai?
    $checkAdmin = mysqli_query($conn, "SELECT * FROM admin LIMIT 1");
    
    if (mysqli_num_rows($checkAdmin) == 0) {
        // --- CASE 1: Koi admin nahi hai, toh naya admin SAVE karein ---
        $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
        $insert = "INSERT INTO admin (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_pass')";
        
        if (mysqli_query($conn, $insert)) {
            $new_id = mysqli_insert_id($conn);
            $_SESSION['admin_id'] = $new_id;
            $_SESSION['admin_name'] = $fullname;
            header("Location: admin_panel.php");
            exit();
        }
    } else {
        // --- CASE 2: Admin pehle se hai, toh sirf LOGIN check karein ---
        $row = mysqli_fetch_assoc($checkAdmin);
        
        // Email match check
        if ($email === $row['email']) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_name'] = $row['fullname'];
                header("Location: admin_panel.php");
                exit();
            } else {
                $msg = "<div class='alert-msg'>Invalid Password!</div>";
            }
        } else {
            $msg = "<div class='alert-msg'>Unauthorized Access! Admin already exists.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlucoCare | Admin Access</title>
    <link rel="icon" href="../pics/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .auth-container { width: 100%; max-width: 420px; padding: 40px; background: #ffffff; border-radius: 32px; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; }
        .auth-header { text-align: center; margin-bottom: 30px; }
        .logo-circle { width: 60px; height: 60px; background: #eef2ff; color: #4f46e5; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 15px; }
        h2 { font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; }
        .alert-msg { background: #fff1f2; color: #e11d48; padding: 12px; border-radius: 12px; font-size: 14px; text-align: center; margin-bottom: 20px; border: 1px solid #ffe4e6; font-weight: 600; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; }
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        input { width: 100%; padding: 14px 14px 14px 50px; border-radius: 14px; border: 1.5px solid #e2e8f0; background: #fcfcfd; outline: none; transition: 0.3s; font-size: 15px; }
        input:focus { border-color: #4f46e5; background: #ffffff; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); }
        .btn-auth { width: 100%; padding: 16px; border: none; border-radius: 16px; background: #0f172a; color: white; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn-auth:hover { background: #4f46e5; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2); }
        .auth-footer { text-align: center; margin-top: 25px; }
        .back-home { color: #94a3b8; text-decoration: none; font-size: 14px; font-weight: 600; }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-header">
        <div class="logo-circle"><i class="fas fa-user-shield"></i></div>
        <h2>Admin Login</h2>
        <p style="color:#64748b; font-size:14px; margin-top:5px;">Login to your account</p>
    </div>

    <?php echo $msg; ?>

    <form method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <div class="input-wrapper">
                <i class="fas fa-user"></i>
                <input type="text" name="fullname" placeholder="Enter Full Name" required>
            </div>
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <div class="input-wrapper">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="admin@example.com" required>
            </div>
        </div>
        <div class="form-group">
            <label>Password</label>
            <div class="input-wrapper">
                <i class="fas fa-key"></i>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
        </div>
        <button type="submit" name="login" class="btn-auth">Log In</button>
    </form>

    <div class="auth-footer">
        <a href="../index.php" class="back-home"><i class="fas fa-arrow-left"></i> Return to Site</a>
    </div>
</div>

</body>
</html>