<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password

    $sql = "INSERT INTO patients (fname, lname, email, password) VALUES ('$fname', '$lname', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Patient registered successfully!');
                window.location.href='login.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GlucoCare | Patient Registration</title>
  <link rel="icon" href="../pics/logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    :root {
      --primary: #10b981; /* Green for Patient/Health focus */
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
      background-image: radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0, transparent 50%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .reg-container {
      width: 100%;
      max-width: 950px;
      display: grid;
      grid-template-columns: 1fr 1.2fr;
      background: var(--white);
      border-radius: 24px;
      overflow: hidden;
      box-shadow: var(--shadow);
    }

    /* Left Panel */
    .info-panel {
      background: var(--primary);
      background-image: linear-gradient(rgba(16, 185, 129, 0.9), rgba(5, 150, 105, 0.95)), 
                        url('https://images.unsplash.com/photo-1505751172107-573957a2482c?auto=format&fit=crop&q=80&w=1000');
      background-size: cover;
      padding: 60px;
      color: var(--white);
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .info-panel h1 { font-size: 32px; font-weight: 800; margin-bottom: 20px; }
    .info-panel p { font-size: 17px; line-height: 1.6; opacity: 0.9; margin-bottom: 30px; }
    
    .feature-list { list-style: none; }
    .feature-list li { margin-bottom: 15px; display: flex; align-items: center; gap: 10px; }
    .feature-list i { color: var(--primary); background: white; padding: 5px; border-radius: 50%; font-size: 10px; }

    /* Right Panel (Form) */
    .form-panel { padding: 50px; background: var(--white); }
    .form-header { margin-bottom: 30px; }
    .form-header h2 { font-size: 26px; color: var(--text-dark); margin-bottom: 5px; }
    .form-header p { color: var(--text-light); font-size: 14px; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    .full-width { grid-column: span 2; }

    .input-group { margin-bottom: 18px; }
    .input-group label { display: block; font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px; }
    
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

    .btn-submit {
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
      margin-top: 15px;
    }
    .btn-submit:hover { background: var(--primary-hover); transform: translateY(-1px); }

    .login-link { text-align: center; margin-top: 25px; font-size: 14px; color: var(--text-light); }
    .login-link a { color: var(--primary); text-decoration: none; font-weight: 700; }

    @media (max-width: 850px) {
      .reg-container { grid-template-columns: 1fr; }
      .info-panel { display: none; }
      .form-grid { grid-template-columns: 1fr; }
      .full-width { grid-column: span 1; }
    }
  </style>
</head>
<body>

<div class="reg-container">
  <div class="info-panel">
    <h1>Patient Portal</h1>
    <p>Take control of your health. Track your glucose levels and connect with your doctor instantly.</p>
    
    <ul class="feature-list">
      <li><i class="fa-solid fa-check"></i> Personalized Health Dashboard</li>
      <li><i class="fa-solid fa-check"></i> Easy Appointment Booking</li>
      <li><i class="fa-solid fa-check"></i> Secure Messaging with Doctors</li>
    </ul>
  </div>

  <div class="form-panel">
    <div class="form-header">
      <h2>Patient Registration</h2>
      <p>Fill in your details to get started.</p>
    </div>

    <form action="register.php" method="POST">
      <input type="hidden" name="role" value="patient">

      <div class="form-grid">
        <div class="input-group">
          <label>First Name</label>
          <div class="input-field">
            <i class="fa-regular fa-user icon"></i>
            <input type="text" name="fname" placeholder="Enter first name" required>
          </div>
        </div>

        <div class="input-group">
          <label>Last Name</label>
          <div class="input-field">
            <i class="fa-regular fa-user icon"></i>
            <input type="text" name="lname" placeholder="Enter last name" required>
          </div>
        </div>

        <div class="input-group full-width">
          <label>Email Address</label>
          <div class="input-field">
            <i class="fa-regular fa-envelope icon"></i>
            <input type="email" name="email" placeholder="name@example.com" required>
          </div>
        </div>

        <div class="input-group full-width">
          <label>Password</label>
          <div class="input-field">
            <i class="fa-solid fa-lock icon"></i>
            <input type="password" name="password" id="pass" placeholder="Create a password" required>
            <i class="fa-regular fa-eye-slash pass-toggle" onclick="togglePass('pass')"></i>
          </div>
        </div>

        <div class="input-group full-width">
          <label>Confirm Password</label>
          <div class="input-field">
            <i class="fa-solid fa-lock icon"></i>
            <input type="password" name="cpassword" id="cpass" placeholder="Repeat password" required>
            <i class="fa-regular fa-eye-slash pass-toggle" onclick="togglePass('cpass')"></i>
          </div>
        </div>
      </div>

      <button type="submit" class="btn-submit">Register as Patient</button>
    </form>

    <p class="login-link">
      Already a member? <a href="login.php">Login here</a>
    </p>
  </div>
</div>

<script>
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