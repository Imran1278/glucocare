<?php
include '../db.php'; // Database connection file
session_start();

// Search Logic (Database based)
$search_query = isset($_GET['q']) ? mysqli_real_escape_string($conn, trim($_GET['q'])) : '';

if ($search_query !== '') {
    // Name, Specialty, Address ya Exp mein se kuch bhi search ho sakega
    $query = "SELECT * FROM doctors WHERE 
              name LIKE '%$search_query%' OR 
              specialty LIKE '%$search_query%' OR 
              address LIKE '%$search_query%'";
} else {
    $query = "SELECT * FROM doctors";
}

$result = mysqli_query($conn, $query);
$filtered_doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlucoCare | Search Doctors</title>
    <link rel="icon" href="../pics/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
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

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* --- HEADER NAVIGATION --- */
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

        /* --- SEARCH SECTION --- */
        .search-hero-card {
            background: var(--white);
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            border: 1px solid #f1f5f9;
            margin-bottom: 50px;
        }

        .search-form {
            display: flex;
            gap: 15px;
            background: #f8fafc;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
        }

        .search-form input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 15px 20px;
            font-size: 16px;
            font-family: inherit;
            outline: none;
        }

        .main-search-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }
        .main-search-btn:hover { background: var(--secondary); }

        /* --- DOCTOR CARD DESIGN --- */
        .doc-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .pro-card {
            background: var(--white);
            padding: 25px;
            border-radius: 24px;
            display: grid;
            grid-template-columns: 120px 1fr 200px;
            align-items: center;
            gap: 30px;
            border: 1px solid #f1f5f9;
            transition: 0.4s;
        }

        .pro-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.06);
            border-color: var(--primary);
        }

        .pro-card img {
            width: 120px; height: 120px;
            border-radius: 20px;
            object-fit: cover;
            background: #f8fafc;
        }

        .doc-info h2 { margin: 0; font-size: 22px; font-weight: 800; }
        .doc-info p { margin: 8px 0; color: #64748b; font-size: 15px; }

        .tag-row { display: flex; gap: 10px; margin-top: 15px; }
        .tag {
            padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700;
        }
        .tag-blue { background: #eef2ff; color: var(--primary); }
        .tag-green { background: #dcfce7; color: #10b981; }

        .doc-cta {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-prime {
            background: var(--secondary);
            color: white;
            padding: 12px;
            border-radius: 12px;
            text-decoration: none;
            text-align: center;
            font-weight: 700;
            font-size: 14px;
        }

        .btn-outline {
            border: 2px solid #e2e8f0;
            color: var(--secondary);
            padding: 10px;
            border-radius: 12px;
            text-decoration: none;
            text-align: center;
            font-weight: 700;
            font-size: 14px;
            transition: 0.3s;
        }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }

        /* Responsive */
        @media (max-width: 850px) {
            .pro-card {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .pro-card img { margin: 0 auto; }
            .tag-row { justify-content: center; }
            .search-form { flex-direction: column; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="top-nav">
        <a href="../index.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Return to Dashboard
        </a>
        <div class="logo" style="font-weight: 800; font-size: 20px; color: var(--primary);">GlucoCare.</div>
    </div>

    <div class="search-hero-card">
        <h1 style="margin-top:0; font-size: 32px; font-weight: 800;">Search Specialist Doctors</h1>
        <p style="color:#64748b; margin-bottom: 25px;">Enter doctor name or specialty to find the best match for your health.</p>
        
        <form action="" method="GET" class="search-form">
            <i class="fas fa-search" style="margin-left:20px; color:#94a3b8; font-size: 18px; display:flex; align-items:center;"></i>
            <input type="text" name="q" placeholder="e.g. Dr. Sarah, Neurologist, Cardiologist..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit" class="main-search-btn">Find Experts</button>
        </form>
    </div>

    <div class="doc-list">
        <?php if(count($filtered_doctors) > 0): ?>
            <?php foreach($filtered_doctors as $doc): ?>
            <div class="pro-card">
                <img src="../uploads/<?php echo $doc['image']; ?>" alt="Doctor">
                
                <div class="doc-info">
                    <div class="tag-row">
                        <span class="tag tag-blue"><?php echo $doc['specialty']; ?></span>
                        <span class="tag tag-green"><i class="fas fa-check-circle"></i> Verified</span>
                    </div>
                    <h2><?php echo $doc['name']; ?></h2>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo $doc['address']; ?></p>
                    <p>
                        <i class="fas fa-briefcase" style="color:#4f46e5;"></i> 
                        <?php echo $doc['exp']; ?> Years Experience 
                        <span style="color:#e2e8f0; margin:0 5px;">|</span> 
                    </p>
                </div>

                <div class="doc-cta">
                    <a href="../profile/doctorprofile.php?id=<?php echo $doc['id']; ?>" class="btn-prime">View Profile</a>
                    <a href="../includes/book_appointment.php?id=<?php echo $doc['id']; ?>" class="btn-outline">Book Appointment</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align:center; padding: 60px;">
                <i class="fas fa-user-md-slash" style="font-size: 50px; color:#e2e8f0; margin-bottom: 20px;"></i>
                <h2>No Doctors Found</h2>
                <p>We couldn't find any specialist matching "<?php echo htmlspecialchars($search_query); ?>"</p>
                <a href="search-doctors.php" style="color:var(--primary); font-weight:700;">Clear Search</a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>