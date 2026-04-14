<div class="header" style="margin-bottom: 20px;">
    <h2><i class="fas fa-calendar-check"></i> Appointment Settings</h2>
</div>
<?php 
/* ================= APPOINTMENTS MANAGEMENT (FINAL FIX) ================= */
if ($page == 'appointments') {
    
    // 1. Action Logic (Approve/Reject)
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $new_status = ($_GET['action'] == 'approve') ? 'Confirmed' : 'Rejected';
        
        $update_query = "UPDATE appointments SET status = '$new_status' WHERE id = '$id'";
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Appointment $new_status!'); window.location.href='admin_panel.php?page=appointments';</script>";
            exit();
        }
    }

    echo "<div class='card' style='padding: 20px; background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>
            <h3 style='margin-bottom: 20px; color: #1e293b;'>
                <i class='fas fa-calendar-check' style='margin-right: 10px; color: #4f46e5;'></i>Appointments Management
            </h3>
            <div style='overflow-x: auto;'>
            <table style='width: 100%; border-collapse: collapse; font-size: 14px;'>
                <tr style='background: #f8fafc; text-align: left;'>
                    <th style='padding: 12px; border-bottom: 2px solid #e2e8f0;'>Patient Name</th>
                    <th style='padding: 12px; border-bottom: 2px solid #e2e8f0;'>Doctor</th>
                    <th style='padding: 12px; border-bottom: 2px solid #e2e8f0;'>Schedule & Location</th>
                    <th style='padding: 12px; border-bottom: 2px solid #e2e8f0;'>Status</th>
                    <th style='padding: 12px; border-bottom: 2px solid #e2e8f0;'>Action</th>
                </tr>";

    $query = "SELECT * FROM appointments ORDER BY id DESC";
    $res = mysqli_query($conn, $query);
    
    if($res && mysqli_num_rows($res) > 0) {
        while ($a = mysqli_fetch_assoc($res)) {
            $s = $a['status'];
            $color = ($s == 'Confirmed') ? '#10b981' : (($s == 'Rejected') ? '#ef4444' : '#f59e0b');
            $bg_light = ($s == 'Confirmed') ? '#ecfdf5' : (($s == 'Rejected') ? '#fef2f2' : '#fffbeb');
            
            $p_id = $a['patient_id'];
            $p_name = "Unknown Patient"; 
            $p_query = mysqli_query($conn, "SELECT fname FROM patients WHERE id = '$p_id'");
            if($p_query && mysqli_num_rows($p_query) > 0) {
                $p_data = mysqli_fetch_assoc($p_query);
                $p_name = $p_data['fname'];
            }

            $d_id = $a['doctor_id'];
            $d_name = "Doctor ID: $d_id";
            $d_query = mysqli_query($conn, "SELECT name FROM doctors WHERE id = '$d_id'");
            if($d_query && mysqli_num_rows($d_query) > 0) {
                $d_data = mysqli_fetch_assoc($d_query);
                $d_name = "Dr. " . $d_data['name'];
            }

            echo "<tr style='border-bottom: 1px solid #f1f5f9;'>
                    <td style='padding: 12px;'>
                        <div style='font-weight: 700; color: #1e293b; text-transform: capitalize;'>$p_name</div>
                        <div style='font-size: 12px; color: #64748b;'><i class='fas fa-phone'></i> {$a['patient_phone']}</div>
                    </td>
                    <td style='padding: 12px;'>
                        <div style='font-weight: 600; color: #4f46e5;'>$d_name</div>
                        <div style='font-size: 11px; color: #94a3b8;'>Fee: \${$a['fee']}</div>
                    </td>
                    <td style='padding: 12px;'>
                        <div style='font-weight: 600;'>".date('d M, Y', strtotime($a['app_date']))."</div>
                        <div style='font-size: 12px; color: #64748b;'>{$a['app_time']} | <span style='color:#ef4444; font-weight:600;'>{$a['app_location']}</span></div>
                    </td>
                    <td style='padding: 12px;'>
                        <span style='color:$color; background:$bg_light; padding: 4px 10px; border-radius: 20px; font-weight:700; font-size: 11px; border: 1px solid $color;'>$s</span>
                    </td>
                    <td style='padding: 12px;'>";
                
                if($s == 'Pending') {
                    echo "
                    <a href='?page=appointments&action=approve&id={$a['id']}' 
                       style='background:#10b981; color:white; padding:6px 12px; border-radius:6px; text-decoration:none; font-size:11px; margin-right:5px; display:inline-block;'>Approve</a>
                    
                    <a href='?page=appointments&action=reject&id={$a['id']}' 
                       style='background:#ef4444; color:white; padding:6px 12px; border-radius:6px; text-decoration:none; font-size:11px; display:inline-block;'>Reject</a>";
                } else {
                    echo "<span style='color:#94a3b8; font-style: italic; font-size: 12px;'>Processed</span>";
                }
                
            echo "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='5' style='text-align:center; padding: 40px; color: #94a3b8;'>No appointments found.</td></tr>";
    }
    echo "</table></div></div>";
}
