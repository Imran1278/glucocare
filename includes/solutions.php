<?php
$data = file_get_contents('../doctors.json');
$doctors = json_decode($data, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GlucoCare | Get Your Solution</title>
    <link rel="icon" href="../pics/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f8; margin: 0; }
        .solution-container { padding: 40px 5%; max-width: 1200px; margin: 0 auto; }
        
        /* Back Button */
        .back-btn {
            display: inline-flex; align-items: center; gap: 8px;
            text-decoration: none; color: #1e293b; font-weight: 700;
            margin-bottom: 30px; padding: 10px 20px; background: #fff;
            border-radius: 50px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .back-btn:hover { background: #1e293b; color: #fff; transform: translateX(-5px); }

        .header { text-align: center; margin-bottom: 50px; }
        .header h2 { font-size: 38px; color: #1e293b; font-weight: 800; }

        /* Solution Grid */
        .solution-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .solution-card {
            background: #fff; border-radius: 24px; padding: 30px;
            border: 1px solid #e2e8f0; position: relative; overflow: hidden;
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .solution-card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px rgba(0,0,0,0.1); border-color: #4f46e5; }

        .solution-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 6px; height: 100%;
            background: #4f46e5;
        }

        .doctor-meta { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .doctor-meta img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; }

        .expertise-list { list-style: none; padding: 0; margin: 20px 0; }
        .expertise-list li {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 12px; font-size: 15px; color: #475569;
        }
        .expertise-list li i { color: #10b981; font-size: 18px; }

        .btn-consult {
            display: block; text-align: center; background: #f1f5f9;
            color: #1e293b; padding: 15px; border-radius: 12px;
            text-decoration: none; font-weight: 700; transition: 0.3s;
        }
        .btn-consult:hover { background: #4f46e5; color: #fff; }
    </style>
</head>
<body>

<div class="solution-container">
    <a href="../index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>

    <div class="header">
        <h2>Find Your Medical <span>Solution</span></h2>
        <p style="color: #64748b; font-size: 18px;">Expert care tailored to your specific health concerns</p>
    </div>

    <div class="solution-grid">
        <?php foreach($doctors as $doc): ?>
        <div class="solution-card">
            <div class="doctor-meta">
                <img src="../uploads/<?php echo $doc['image']; ?>" alt="">
                <div>
                    <h4 style="margin:0; font-size: 20px;"><?php echo $doc['name']; ?></h4>
                    <span style="color: #4f46e5; font-weight: 700; font-size: 14px;"><?php echo $doc['specialty']; ?></span>
                </div>
            </div>

            <p style="font-weight: 800; color: #1e293b; margin-top: 10px;">Common Solutions for:</p>
            <ul class="expertise-list">
                <?php if(str_contains(strtolower($doc['specialty']), 'neuro')): ?>
                    <li><i class="fas fa-check-circle"></i> Chronic Migraines & Headaches</li>
                    <li><i class="fas fa-check-circle"></i> Sleep Disorders</li>
                <?php elseif(str_contains(strtolower($doc['specialty']), 'cardio')): ?>
                    <li><i class="fas fa-check-circle"></i> Heart Rate Monitoring</li>
                    <li><i class="fas fa-check-circle"></i> Blood Pressure Management</li>
                <?php else: ?>
                    <li><i class="fas fa-check-circle"></i> General Health Consultation</li>
                    <li><i class="fas fa-check-circle"></i> Specialized Treatment Plan</li>
                <?php endif; ?>
            </ul>

            <a href="../profile/doctorprofile.php?id=<?php echo $doc['id']; ?>" class="btn-consult">Get Solution Now</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>