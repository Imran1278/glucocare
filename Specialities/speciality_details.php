<?php
session_start();
include('../db.php'); // Ensure this path is correct for your DB connection

// 1. URL se speciality nikalna
$spec_type = isset($_GET['type']) ? $_GET['type'] : 'General';

// 2. JSON load karna (Doctors list ke liye)
$json_path = '../doctors.json';
$all_doctors = [];
if (file_exists($json_path)) {
    $json_data = file_get_contents($json_path);
    $all_doctors = json_decode($json_data, true) ?: [];
}

// 3. Filter doctors based on specialty
$filtered_doctors = array_filter($all_doctors, function($doc) use ($spec_type) {
    return strcasecmp($doc['specialty'] ?? '', $spec_type) == 0;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $spec_type; ?> Specialists | GlucoCare</title>
    <link rel="icon" href="../pics/logo.png">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #eef2ff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-light); 
            color: var(--text-dark);
            margin: 0;
        }

        .page-container { 
            display: grid; 
            grid-template-columns: 300px 1fr; 
            gap: 40px; 
            padding: 40px 6%; 
            max-width: 1440px; 
            margin: 0 auto; 
        }

        /* --- HERO HEADER --- */
        .spec-hero-header {
            background: white;
            padding: 40px;
            border-radius: 30px;
            margin-bottom: 40px;
            border: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            background-image: radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.05) 0px, transparent 50%), 
                              radial-gradient(at 100% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%);
        }

        .hero-content h1 { font-size: 42px; font-weight: 800; margin: 0; color: var(--text-dark); letter-spacing: -1px; }
        .hero-stats { display: flex; gap: 30px; }
        .hero-stat-item { text-align: center; }
        .hero-stat-item .count { display: block; font-size: 28px; font-weight: 800; color: var(--primary); }
        .hero-stat-item .label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; font-weight: 700; }

        /* --- SIDEBAR --- */
        .sidebar-sticky { position: sticky; top: 30px; }
        .sidebar-card { background: white; padding: 24px; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; margin-bottom: 25px; }
        
        .emergency-box {
            background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 100%);
            color: white; padding: 30px 24px; border-radius: 24px; position: relative; overflow: hidden;
        }

        .spec-list-item {
            display: flex; align-items: center; padding: 12px 15px; margin-bottom: 8px; border-radius: 12px;
            text-decoration: none; color: var(--text-muted); font-weight: 500; transition: 0.3s;
        }
        .spec-list-item:hover, .spec-list-item.active { background: var(--primary-light); color: var(--primary); }

        /* --- DOCTOR CARD --- */
        .doctor-card { 
            background: white; border-radius: 30px; padding: 30px; 
            display: grid; grid-template-columns: 180px 1fr 200px; gap: 30px;
            margin-bottom: 30px; border: 1px solid #f1f5f9; transition: all 0.4s ease;
        }
        .doctor-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.06); border-color: var(--primary); }

        .doc-img-wrapper { position: relative; width: 180px; height: 180px; }
        .doc-img { width: 100%; height: 100%; border-radius: 24px; object-fit: cover; }
        .verify-badge {
            position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);
            background: #10b981; color: white; padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 700;
        }

        .spec-tag {
            display: inline-block; color: var(--primary); background: var(--primary-light);
            padding: 4px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; margin-bottom: 12px; text-transform: uppercase;
        }

        .fee-section { border-left: 1px solid #f1f5f9; padding-left: 30px; text-align: center; display: flex; flex-direction: column; justify-content: center; }
        .price-tag { font-size: 32px; font-weight: 800; color: var(--text-dark); margin: 5px 0; }
        
        .btn-book {
            background: var(--primary); color: white !important; padding: 14px; border-radius: 16px;
            text-decoration: none; font-weight: 700; margin-top: 15px; transition: 0.3s; display: block;
        }
        .btn-book:hover { background: #4338ca; box-shadow: 0 10px 15px rgba(79, 70, 229, 0.3); }

        .empty-state { text-align: center; padding: 80px; background: white; border-radius: 30px; border: 2px dashed #e2e8f0; }
    </style>
</head>
<body>

<header style="background:white; padding: 20px 6%; border-bottom: 1px solid #f1f5f9;">
    <nav style="display:flex; justify-content:space-between; align-items:center;">
        <a href="../index.php" class="logo" style="font-size:24px; font-weight:800; text-decoration:none; color:var(--primary);">Gluco<span>Care</span></a>
        <div>
            <?php if(isset($_SESSION['patient_name'])): ?>
                <span style="font-size:14px;">Hi, <b style="color:var(--primary)"><?php echo $_SESSION['patient_name']; ?></b></span>
            <?php endif; ?>
        </div>
    </nav>
</header>

<div class="page-container">
    <aside>
        <div class="sidebar-sticky">
            <div class="emergency-box">
                <i class="fas fa-ambulance" style="position:absolute; right:-10px; bottom:-10px; font-size:80px; opacity:0.1;"></i>
                <h4 style="margin:0; font-size:18px;">Emergency?</h4>
                <p style="font-size:13px; opacity:0.8; margin:10px 0;">Get immediate assistance from our experts.</p>
                <h3 style="margin:0; font-size:20px;">+92 300 1234567</h3>
            </div>
            <br>
            <div class="sidebar-card">
                <h4 style="margin:0 0 20px 0;">Specialities</h4>
                <?php
                $side_specs = mysqli_query($conn, "SELECT * FROM specialties");
                while($ss = mysqli_fetch_assoc($side_specs)) {
                    $active = (strcasecmp($ss['spec_name'], $spec_type) == 0) ? 'active' : '';
                    echo "<a href='?type=".urlencode($ss['spec_name'])."' class='spec-list-item $active'>
                            <i class='{$ss['spec_icon']}' style='width:25px'></i> {$ss['spec_name']}
                          </a>";
                }
                ?>
            </div>
        </div>
    </aside>

    <main>
    <div class="spec-hero-header">
    <div class="hero-content">
        <a href="../index.php" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px; color: var(--primary); font-weight: 700; font-size: 14px; margin-bottom: 15px; transition: 0.3s;" onmouseover="this.style.transform='translateX(-5px)'" onmouseout="this.style.transform='translateX(0)'">
            <i class="fas fa-arrow-left"></i> Back to Main Page
        </a>
        <br>
        <span class="spec-tag">Verified Department</span>
        <h1><?php echo $spec_type; ?> <span style="color: var(--primary);">Experts</span></h1>
        <p style="color: var(--text-muted); margin-top: 10px; font-size: 16px;">
            Find and book appointments with the best doctors for <?php echo $spec_type; ?>.
        </p>
    </div>
    <div class="hero-stats">
        <div class="hero-stat-item">
            <span class="count"><?php echo count($filtered_doctors); ?></span>
            <span class="label">Specialists</span>
        </div>
        <div class="hero-stat-item" style="border-left: 1px solid #e2e8f0; padding-left: 30px;">
            <span class="count">4.9</span>
            <span class="label">Avg Rating</span>
        </div>
    </div>
</div>
        <?php if(empty($filtered_doctors)): ?>
            <div class="empty-state">
                <i class="fas fa-user-md" style="font-size: 50px; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h3>No Specialists Available</h3>
                <p style="color: var(--text-muted);">We are currently adding more doctors to this category.</p>
                <a href="../index.php" style="color:var(--primary); font-weight:700; text-decoration:none;">Back to Home</a>
            </div>
        <?php else: ?>
            <?php foreach($filtered_doctors as $doc): ?>
            <div class="doctor-card">
                <div class="doc-img-wrapper">
                    <img src="../uploads/<?php echo $doc['image']; ?>" class="doc-img">
                    <span class="verify-badge"><i class="fas fa-check-circle"></i> VERIFIED</span>
                </div>
                
                <div class="doc-info">
                    <span class="spec-tag"><?php echo $doc['specialty']; ?></span>
                    <h2 style="margin-top:0;"><?php echo $doc['name']; ?></h2>
                    <div style="display:flex; gap:20px; margin-bottom:15px; font-size:14px; color:var(--text-muted);">
                        <span><i class="fas fa-star" style="color:#fbbf24"></i> 4.9 (120+ Reviews)</span>
                        <span><i class="fas fa-award" style="color:var(--primary)"></i> <?php echo $doc['exp']; ?>+ Years Exp</span>
                    </div>
                    <p style="font-size:14px; line-height:1.6; color:var(--text-muted);">
                        <?php echo substr($doc['bio'], 0, 160); ?>...
                    </p>
                    <div style="margin-top:15px;">
                        <span style="font-size:12px; background:#f1f5f9; padding:6px 12px; border-radius:8px; color:var(--text-muted);">
                            <i class="fas fa-university"></i> <?php echo $doc['university']; ?>
                        </span>
                    </div>
                </div>

                <div class="fee-section">
                    <span style="font-size:12px; font-weight:700; color:var(--text-muted); text-transform:uppercase;">Fee</span>
                    <div class="price-tag">$<?php echo $doc['price']; ?></div>
                    <a href="../includes/book_appointment.php?id=<?php echo $doc['id']; ?>" class="btn-book">Book Now</a>
                    <a href="../profile/doctorprofile.php?id=<?php echo $doc['id']; ?>" style="margin-top:12px; font-size:13px; color:var(--text-muted); text-decoration:none; font-weight:600;">View Profile</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</div>

</body>
</html>