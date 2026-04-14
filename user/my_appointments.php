<?php
session_start();
include '../db.php'; 

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

// --- Cancel Appointment Logic ---
if (isset($_GET['cancel_id'])) {
    $cancel_id = mysqli_real_escape_string($conn, $_GET['cancel_id']);
    // Sirf wahi appointment delete ho jo is patient ki ho aur status 'Pending' ho
    $del_query = "DELETE FROM appointments WHERE id = '$cancel_id' AND patient_id = '$patient_id' AND status = 'Pending'";
    if (mysqli_query($conn, $del_query)) {
        echo "<script>alert('Appointment cancelled successfully.'); window.location.href='my_appointments.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlucoCare | My Bookings</title>
    <link rel="icon" href="../pics/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root { --primary: #4f46e5; --bg: #f8fafc; --white: #ffffff; --text-main: #1e293b; --text-muted: #64748b; --border: #e2e8f0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text-main); margin: 0; padding: 40px 20px; }
        .container { max-width: 1100px; margin: auto; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .btn-back { display: flex; align-items: center; gap: 8px; text-decoration: none; color: var(--text-muted); font-weight: 600; font-size: 14px; transition: 0.3s; }
        .btn-back:hover { color: var(--primary); }
        .main-card { background: var(--white); border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid var(--border); }
        .card-header { padding: 25px 30px; border-bottom: 1px solid var(--border); background: #fff; }
        .card-header h2 { margin: 0; font-size: 20px; font-weight: 700; }
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; background: #fcfcfd; padding: 16px 30px; color: var(--text-muted); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 20px 30px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .doc-info { display: flex; align-items: center; gap: 12px; }
        .doc-icon { width: 40px; height: 40px; background: #eef2ff; color: var(--primary); display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 18px; }
        .status { padding: 6px 14px; border-radius: 10px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; }
        .status::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
        .pending { background: #fffbeb; color: #92400e; } .pending::before { background: #f59e0b; }
        .confirmed { background: #f0fdf4; color: #166534; } .confirmed::before { background: #22c55e; }
        .rejected { background: #fef2f2; color: #991b1b; } .rejected::before { background: #ef4444; }
        .btn-cancel { color: #ef4444; cursor: pointer; font-size: 18px; transition: 0.3s; background: none; border: none; }
        .btn-cancel:hover { transform: scale(1.1); }
        @media (max-width: 600px) { td, th { padding: 15px; } }
    </style>
</head>
<body>

<div class="container">
    <div class="top-bar">
        <a href="../index.php" class="btn-back"><i class="fas fa-chevron-left"></i> Back to Home</a>
    </div>

    <div class="main-card">
        <div class="card-header">
            <h2>My Appointments</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin: 5px 0 0;">Track your healthcare visits and status.</p>
        </div>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Schedule</th>
                        <th>Location</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // SQL Join to get doctor details and appointment location
                    $query = "SELECT a.*, d.name as doc_name, d.specialty 
                              FROM appointments a 
                              JOIN doctors d ON a.doctor_id = d.id 
                              WHERE a.patient_id = '$patient_id' 
                              ORDER BY a.id DESC";
                    
                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $status = $row['status'];
                            $class = strtolower($status);
                    ?>
                    <tr>
                        <td>
                            <div class="doc-info">
                                <div class="doc-icon"><i class="fas fa-user-md"></i></div>
                                <div>
                                    <div style="font-weight:700;">Dr. <?php echo $row['doc_name']; ?></div>
                                    <div style="color:var(--text-muted); font-size:12px;"><?php echo $row['specialty']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:600; font-size:14px;"><?php echo date('d M, Y', strtotime($row['app_date'])); ?></div>
                            <div style="color:var(--text-muted); font-size:12px;"><i class="far fa-clock"></i> <?php echo $row['app_time']; ?></div>
                        </td>
                        <td>
                            <div style="font-size:13px; font-weight:500;"><i class="fas fa-map-marker-alt" style="color:#ef4444; margin-right:5px;"></i> <?php echo $row['app_location'] ?? 'Not Specified'; ?></div>
                        </td>
                        <td style="font-weight:700;">$<?php echo $row['fee']; ?></td>
                        <td>
                            <span class="status <?php echo $class; ?>">
                                <?php echo ucfirst($status); ?>
                            </span>
                        </td>
                        <td>
                            <?php if($status == 'Pending'): ?>
                                <a href="?cancel_id=<?php echo $row['id']; ?>" class="btn-cancel" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                    <i class="fas fa-times-circle"></i>
                                </a>
                            <?php else: ?>
                                <span style="color:var(--text-muted); font-size:12px;">--</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center; padding: 60px; color: var(--text-muted);'><i class='fas fa-calendar-times' style='font-size:40px; margin-bottom:15px; display:block;'></i>No appointments found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>