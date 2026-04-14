<?php
// JSON Data load karna
$data = file_get_contents('../doctors.json');
$doctors = json_decode($data, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GlucoCare | Schedule Appointment</title>
    <link rel="icon" href="../pics/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; margin: 0; padding: 0; }
        .schedule-container { padding: 40px 5% 80px; max-width: 1100px; margin: 0 auto; position: relative; }
        
        /* BACK BUTTON STYLING */
        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #64748b;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 30px;
            transition: 0.3s;
            padding: 10px 15px;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #e2e8f0;
        }
        .back-home:hover {
            color: #4f46e5;
            background: #eef2ff;
            border-color: #dbeafe;
            transform: translateX(-5px);
        }

        .page-header { text-align: center; margin-bottom: 50px; }
        .schedule-card {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 25px;
            border: 1px solid #e2e8f0;
            transition: 0.3s;
        }
        .schedule-card:hover { border-color: #4f46e5; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        
        .doc-info-mini { display: flex; align-items: center; gap: 15px; flex: 1.5; }
        .doc-info-mini img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #f1f5f9; }
        
        .time-slots-container { flex: 2; }
        .time-label { display: block; font-size: 12px; color: #94a3b8; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; }
        
        .slot-pill {
            display: inline-block;
            padding: 10px 20px;
            background: #eef2ff;
            color: #4f46e5;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            border: 1px solid #dbeafe;
        }

        .book-now-btn {
            background: #1e293b;
            color: white;
            padding: 12px 25px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            transition: 0.3s;
            display: inline-block;
        }
        .book-now-btn:hover { background: #4f46e5; transform: translateY(-2px); }

        @media (max-width: 768px) {
            .schedule-card { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

<div class="schedule-container">
    <a href="../index.php" class="back-home">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>

    <div class="page-header">
        <h2 style="font-size: 36px; color: #1e293b; font-weight: 800;">Doctor Schedules</h2>
        <p style="color: #64748b;">Find the perfect time for your consultation</p>
    </div>

    <?php if($doctors): ?>
        <?php foreach($doctors as $doc): ?>
        <div class="schedule-card">
            <div class="doc-info-mini">
                <img src="../uploads/<?php echo $doc['image']; ?>" alt="Doctor">
                <div>
                    <h4 style="margin:0; color:#1e293b; font-size: 20px;"><?php echo $doc['name']; ?></h4>
                    <span style="color:#6366f1; font-weight:600; font-size: 14px;"><?php echo $doc['specialty']; ?></span>
                </div>
            </div>

            <div class="time-slots-container">
                <span class="time-label"><i class="far fa-clock"></i> Available Hours</span>
                <div class="slot-pill">
                    <?php echo isset($doc['timing']) ? $doc['timing'] : 'By Appointment Only'; ?>
                </div>
            </div>

            <div style="text-align: right;">
                <a href="../includes/book_appointment.php?id=<?php echo $doc['id']; ?>" class="book-now-btn">Book Now</a>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center; color: #94a3b8;">No schedules available right now.</p>
    <?php endif; ?>
</div>

</body>
</html>