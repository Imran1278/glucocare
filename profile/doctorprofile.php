<?php
$data = file_get_contents('../doctors.json');
$doctors = json_decode($data, true);
$id = isset($_GET['id']) ? $_GET['id'] : null; 

$current_doctor = null;
foreach ($doctors as $doc) {
    if ($doc['id'] == $id) {
        $current_doctor = $doc;
        break;
    }
}

if (!$current_doctor) { 
    header("Location: ../index.php");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $current_doctor['name']; ?> - Professional Profile</title>
    <link rel="icon" href="../pics/logo.png">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-soft: #eef2ff;
            --secondary: #0ea5e9;
            --bg: #f8fafc;
            --white: #ffffff;
            --text-dark: #0f172a;
            --text-light: #64748b;
            --border: #e2e8f0;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* --- Floating Back Button --- */
        .back-home {
            position: fixed;
            top: 25px;
            left: 25px;
            z-index: 1000;
            background: var(--white);
            color: var(--text-dark);
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .back-home:hover {
            transform: translateX(-5px);
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .container {
            max-width: 1200px;
            margin: 80px auto;
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 40px;
            padding: 0 20px;
        }

        /* Sidebar Styling */
        .sidebar { display: flex; flex-direction: column; gap: 25px; }

        .profile-card, .booking-card, .info-card, .academic-card {
            background: var(--white);
            border-radius: 24px;
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        .doctor-image {
            width: 100%;
            height: 380px;
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 25px;
        }

        .contact-list { display: flex; flex-direction: column; gap: 18px; }
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            font-size: 14px;
            color: var(--text-light);
        }
        .contact-item i {
            color: var(--primary);
            background: var(--primary-soft);
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            flex-shrink: 0;
        }

        .booking-card { 
            background: linear-gradient(135deg, var(--primary), #6366f1);
            color: white;
            text-align: center;
        }
        .booking-card h3 { font-size: 20px; margin-bottom: 10px; }
        .booking-card p { font-size: 14px; opacity: 0.9; margin-bottom: 20px; }

        .btn-link {
            display: block;
            background: white;
            color: var(--primary);
            padding: 14px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
        }
        .btn-link:hover { transform: scale(1.02); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2); }

        /* Main Content */
        .main-content { display: flex; flex-direction: column; gap: 30px; }

        .header-section {
            background: var(--white);
            padding: 40px;
            border-radius: 24px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }
        .header-section::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 150px; height: 150px;
            background: radial-gradient(circle, var(--primary-soft) 0%, transparent 70%);
            z-index: 0;
        }

        .specialty-tag {
            background: var(--primary-soft);
            color: var(--primary);
            padding: 8px 20px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 700;
            display: inline-block;
        }

        .header-section h1 {
            font-size: 36px;
            margin: 20px 0;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 35px;
            border-top: 1px solid var(--border);
            padding-top: 30px;
        }

        .stat-item b { font-size: 24px; color: var(--primary); display: block; }
        .stat-item span { font-size: 13px; color: var(--text-light); font-weight: 600; }

        /* Academic & Schedule Grid */
        .academic-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .info-card h3, .academic-card h3 { 
            font-size: 18px; 
            margin-bottom: 20px; 
            display: flex; 
            align-items: center; 
            gap: 10px;
        }

        .work-grid { display: flex; flex-direction: column; gap: 12px; }
        .work-day {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 18px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        /* Responsive */
        @media (max-width: 1000px) {
            .container { grid-template-columns: 1fr; margin-top: 100px; }
            .academic-grid { grid-template-columns: 1fr; }
            .back-home { top: 15px; left: 15px; }
        }
    </style>
</head>
<body>

<a href="../index.php" class="back-home">
    <i class="fa-solid fa-arrow-left"></i> Back to Directory
</a>

<div class="container">
    <aside class="sidebar">
        <div class="profile-card">
            <img src="../uploads/<?php echo $current_doctor['image']; ?>" class="doctor-image" alt="Doctor">
            <div class="contact-list">
                <div class="contact-item">
                    <i class="fa-solid fa-phone"></i> 
                    <div><small style="display:block">Phone Number</small><b><?php echo $current_doctor['phone']; ?></b></div>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-envelope"></i> 
                    <div><small style="display:block">Official Email</small><b><?php echo $current_doctor['email']; ?></b></div>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-location-dot"></i> 
                    <div><small style="display:block">Location</small><b><?php echo $current_doctor['address']; ?></b></div>
                </div>
            </div>
        </div>

        <div class="booking-card">
            <h3>Need a Consultation?</h3>
            <p>Book your slot today for a priority checkup.</p>
            <a href="../includes/book_appointment.php?id=<?php echo $current_doctor['id']; ?>" class="btn-link">
                <i class="fa-regular fa-calendar-check"></i> Book Appointment
            </a>
        </div>
    </aside>

    <main class="main-content">
        <section class="header-section">
            <span class="specialty-tag"><i class="fa-solid fa-stethoscope"></i> <?php echo $current_doctor['specialty']; ?> Specialist</span>
            <h1><?php echo $current_doctor['name']; ?></h1>
            <p style="font-size: 16px; color: var(--text-light);"><?php echo $current_doctor['bio']; ?></p>
            
            <div class="stats-bar">
                <div class="stat-item"><b><?php echo $current_doctor['exp']; ?>+</b><span>Years Experience</span></div>
                <div class="stat-item"><b><?php echo $current_doctor['patients']; ?></b><span>Satisfied Patients</span></div>
                <div class="stat-item"><b><?php echo $current_doctor['awards']; ?></b><span>Merit Awards</span></div>
            </div>
        </section>

        <div class="academic-grid">
            <section class="academic-card">
                <h3><i class="fa-solid fa-graduation-cap" style="color:var(--secondary)"></i> Qualifications</h3>
                <div class="contact-list">
                    <div class="contact-item">
                        <i class="fa-solid fa-university"></i>
                        <div><small style="display:block">Medical University</small><b><?php echo $current_doctor['university']; ?></b></div>
                    </div>
                    <div class="contact-item">
                        <i class="fa-solid fa-language"></i>
                        <div><small style="display:block">Languages Spoken</small><b><?php echo $current_doctor['languages']; ?></b></div>
                    </div>
                </div>
            </section>

            <section class="info-card">
                <h3><i class="fa-regular fa-clock" style="color: var(--primary)"></i> Clinical Hours</h3>
                <div class="work-grid">
                    <?php 
                    $sched = is_array($current_doctor['schedule']) ? $current_doctor['schedule'] : json_decode($current_doctor['schedule'], true);
                    foreach ($sched as $day => $info): 
                        if(!empty($info['time'])): ?>
                        <div class="work-day">
                            <div style="font-weight:700; font-size:13px;"><?php echo $day; ?></div>
                            <div style="text-align: right;">
                                <small style="color: var(--primary); font-weight:700; display:block;"><?php echo $info['time']; ?></small>
                                <small style="font-size:10px; color:var(--text-light)"><?php echo $info['location']; ?></small>
                            </div>
                        </div>
                    <?php endif; endforeach; ?>
                </div>
            </section>
        </div>
    </main>
</div>

</body>
</html>