<?php
// JSON Data load karna
$data = file_get_contents('../doctors.json');
$doctors = json_decode($data, true);
session_start();
include '../db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GlucoCares | All Doctor</title>
    <link rel="stylesheet" href="../styles/style.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="../pics/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/other.css">
    <style>
        .directory-container { padding: 80px 5%; background: #f8fafc; }
        .directory-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 40px auto;
        }
        .doc-card-main {
            background: #fff;
            border-radius: 25px;
            padding: 20px;
            text-align: center;
            border: 1px solid #e2e8f0;
            transition: 0.3s;
        }
        .doc-card-main:hover { transform: translateY(-10px); box-shadow: 0 20px 30px rgba(0,0,0,0.05); }
        .doc-card-main img { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; }
        .view-btn {
            display: block;
            background: #4f46e5;
            color: #fff;
            padding: 12px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            margin-top: 20px;
        }
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        .back-link {
            text-decoration: none;
            color: var(--secondary);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }
        .back-link:hover { color: var(--primary); transform: translateX(-5px); }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        :root {
            --primary: #4f46e5;
            --secondary: #1e293b;
            --bg: #f8fafc;
            --white: #ffffff;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg); 
            color: var(--secondary);
            margin: 0; padding: 0;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="container">
        <div class="top-nav">
            <a href="../index.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Return to Dashboard
            </a>
            <div class="logo" style="font-weight: 800; font-size: 20px; color: var(--primary);">GlucoCare.</div>
        </div>
    </div>

    <section class="directory-container">
        <div style="text-align: center;">
            <h2 style="font-size: 36px; color: #1e293b;">Meet Our Specialists</h2>
            <p style="color: #64748b;">Browse through our complete list of certified medical professionals.</p>
        </div>

        <div class="directory-grid">
            <?php foreach($doctors as $doc): ?>
            <div class="doc-card-main">
                <img src="../uploads/<?php echo $doc['image']; ?>" alt="">
                <h4 style="font-size: 20px; color: #1e293b;"><?php echo $doc['name']; ?></h4>
                <p style="color: #4f46e5; font-weight: 600; margin: 5px 0;"><?php echo $doc['specialty']; ?></p>
                <p style="font-size: 14px; color: #94a3b8;"><i class="fas fa-map-marker-alt"></i> Available in Clinic</p>
                <a href="../profile/doctorprofile.php?id=<?php echo $doc['id']; ?>" class="view-btn">View Full Profile</a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>