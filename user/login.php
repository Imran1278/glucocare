<?php
session_start();
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM patients WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Login success - Session store karein
            $_SESSION['patient_id'] = $row['id'];
            $_SESSION['patient_name'] = $row['fname']; 
            
            header("Location: ../index.php"); // Main page par bhej dein
        } else {
            echo "<script>alert('Invalid Password'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.location.href='login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GlucoCare | Patient Login</title>
  <link rel="icon" href="../pics/logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    :root {
      --primary: #10b981;
      --primary-hover: #059669;
      --text-dark: #1e293b;
      --text-light: #64748b;
      --bg-body: #f8fafc;
      --white: #ffffff;
      --border: #e2e8f0;
      --radius: 12px;
      --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

    body {
      background-color: var(--bg-body);
      background-image: radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.1) 0, transparent 50%),
                        radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.05) 0, transparent 50%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-card {
      width: 100%;
      max-width: 450px;
      background: var(--white);
      border-radius: 24px;
      padding: 50px 40px;
      box-shadow: var(--shadow);
      text-align: center;
    }

    .brand-logo {
      width: 60px;
      height: 60px;
      background: var(--primary);
      color: white;
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      margin: 0 auto 20px;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .header h2 { font-size: 28px; color: var(--text-dark); margin-bottom: 8px; }
    .header p { color: var(--text-light); font-size: 15px; margin-bottom: 35px; }

    .input-group { text-align: left; margin-bottom: 20px; }
    .input-group label { display: block; font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px; }
    
    .input-field { position: relative; display: flex; align-items: center; }
    .input-field i.icon { position: absolute; left: 15px; color: var(--text-light); font-size: 14px; }

    .input-field input {
      width: 100%;
      padding: 12px 15px 12px 40px;
      border: 1.5px solid var(--border);
      border-radius: var(--radius);
      font-size: 15px;
      outline: none;
      transition: 0.2s;
    }

    .input-field input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .pass-toggle { position: absolute; right: 15px; cursor: pointer; color: var(--text-light); }

    .forgot-pass { text-align: right; margin-top: 8px; }
    .forgot-pass a { font-size: 13px; color: var(--primary); text-decoration: none; font-weight: 600; }

    .btn-login {
      width: 100%;
      background: var(--primary);
      color: white;
      padding: 14px;
      border: none;
      border-radius: var(--radius);
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 25px;
    }
    .btn-login:hover { background: var(--primary-hover); transform: translateY(-1px); }

    .register-link { text-align: center; margin-top: 30px; font-size: 14px; color: var(--text-light); }
    .register-link a { color: var(--primary); text-decoration: none; font-weight: 700; }

    /* For Mobile View */
    @media (max-width: 480px) {
      .login-card { padding: 30px 20px; }
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="brand-logo">
    <i class="fa-solid fa-heart-pulse"></i>
  </div>
  
  <div class="header">
    <h2>Welcome Back</h2>
    <p>Please enter your credentials to login.</p>
  </div>

  <form action="login.php" method="POST">
    <div class="input-group">
      <label>Email Address</label>
      <div class="input-field">
        <i class="fa-regular fa-envelope icon"></i>
        <input type="email" name="email" placeholder="name@example.com" required>
      </div>
    </div>

    <div class="input-group">
      <label>Password</label>
      <div class="input-field">
        <i class="fa-solid fa-lock icon"></i>
        <input type="password" name="password" id="pass" placeholder="Enter your password" required>
        <i class="fa-regular fa-eye-slash pass-toggle" onclick="togglePass('pass')"></i>
      </div>
    </div>

    <button type="submit" class="btn-login">Sign In</button>
  </form>

  <p class="register-link">
    Don't have an account? <a href="register.php">Create Account</a>
  </p>
</div>

<script>
  // Password visibility toggle
  function togglePass(id) {
    const input = document.getElementById(id);
    const icon = event.target;
    if (input.type === "password") {
      input.type = "text";
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    } else {
      input.type = "password";
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    }
  }
</script>

</body>
</html>