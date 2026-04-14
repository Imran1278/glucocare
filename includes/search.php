<?php
include '../db.php'; // Connection file path

// 1. Get and Clean Search Query
$search_query = isset($_GET['query']) ? mysqli_real_escape_string($conn, trim($_GET['query'])) : '';

if (empty($search_query)) {
    echo "<script>alert('Please enter a doctor name or specialty'); window.location.href='../index.php';</script>";
    exit;
}

/* 2. STRICT FILTERING LOGIC:
   Name par LIKE chalega (takay partial name search ho sakay)
   Lekin Specialty par EXACT match chalega takay Urology/Neurology clash na hon.
*/
$sql = "SELECT * FROM doctors 
        WHERE (name LIKE '%$search_query%') 
        OR (specialty = '$search_query')"; 

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlucoCare | Search Results</title>
    <link rel="icon" href="../pics/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-soft: #eef2ff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --bg-page: #f8fafc;
            --white: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--bg-page);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
        }

        /* Custom Header for Search Page */
        .search-top-nav {
            background: var(--white);
            padding: 20px 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .back-btn {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .back-btn:hover { color: var(--primary); }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .search-meta {
            margin-bottom: 40px;
        }

        .search-meta h1 {
            font-size: 32px;
            font-weight: 800;
            margin: 0;
        }

        .search-meta span { color: var(--primary); }

        /* Doctor Cards Grid */
        .doctor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .card {
            background: var(--white);
            border-radius: 24px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            border-color: var(--primary);
        }

        .avatar-box {
            width: 90px;
            height: 90px;
            background: var(--primary-soft);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 35px;
            margin-bottom: 15px;
        }

        .specialty-tag {
            background: #f0fdf4;
            color: #16a34a;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .doc-name {
            font-size: 20px;
            font-weight: 700;
            margin: 15px 0 5px 0;
        }

        .doc-desc {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .action-btn {
            width: 100%;
            background: var(--primary);
            color: var(--white);
            text-decoration: none;
            padding: 14px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 14px;
            transition: 0.3s;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
        }

        .action-btn:hover {
            background: #4338ca;
            box-shadow: 0 10px 15px rgba(79, 70, 229, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 100px 20px;
        }

        .empty-state i {
            font-size: 60px;
            color: #cbd5e1;
            margin-bottom: 20px;
        }
        /* --- Image Styling --- */
        .doctor-img-container {
            width: 110px;
            height: 110px;
            margin: 0 auto 15px;
            position: relative;
        }

        .doctor-img {
            width: 100%;
            height: 100%;
            border-radius: 50%; /* Circular Image */
            object-fit: cover;
            border: 3px solid var(--primary);
            padding: 3px;
            background: white;
        }
    </style>
</head>
<body>

    <nav class="search-top-nav">
        <a href="../index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
        <div style="font-weight: 800; color: var(--primary); font-size: 20px;">Gluco<span>Care</span>.</div>
    </nav>

    <div class="container">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="search-meta">
                <h1>Results for <span>"<?php echo htmlspecialchars($search_query); ?>"</span></h1>
                <p style="color: var(--text-muted);">We found <?php echo mysqli_num_rows($result); ?> specialist(s) for you.</p>
            </div>

            <div class="doctor-grid">
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card">
                        <div class="doctor-img-container">
                            <?php 
                                $imagePath = "../uploads/" . $row['image']; 
                                if (!empty($row['image']) && file_exists($imagePath)) {
                                    echo '<img src="'.$imagePath.'" class="doctor-img" alt="Doctor">';
                                }
                            ?>
                        </div>
                        <span class="specialty-tag"><?php echo $row['specialty']; ?></span>
                        <div class="doc-name"><?php echo $row['name']; ?></div>
                        <p class="doc-desc">Top rated specialist in <?php echo $row['specialty']; ?> with over 10 years of experience.</p>
                        
                        <a href="../profile/doctorprofile.php?id=<?php echo $row['id']; ?>" class="action-btn">
                            Book Appointment To Vist Doctor Profile
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-search"></i>
                <h2>No Doctors Found</h2>
                <p style="color: var(--text-muted);">We couldn't find any specialist for "<?php echo htmlspecialchars($search_query); ?>".</p>
                <a href="../index.php" class="action-btn" style="max-width: 200px; display: inline-block; margin-top: 20px;">Try Again</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>