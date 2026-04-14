<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlucoCare</title>
    <link rel="icon" href="./pics/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/other.css">
    <style>
    .search-results-section {
        padding: 60px 5%;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    .section-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-title h2 {
        font-size: 32px;
        color: #1e293b;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .doctors-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .doctor-card {
        background: white;
        padding: 25px;
        border-radius: 24px;
        text-align: center;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
        position: relative;
    }

    .doctor-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        border-color: #6366f1;
    }

    .doctor-card img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 4px solid #f8fafc;
    }

    .doctor-card h3 {
        font-size: 20px;
        color: #1e293b;
        margin: 10px 0 5px;
    }

    .specialty {
        color: #6366f1;
        font-weight: 600;
        font-size: 14px;
        background: #eef2ff;
        display: inline-block;
        padding: 5px 15px;
        border-radius: 50px;
        margin-bottom: 20px;
    }

    .btn-profile {
        display: block;
        background: #1e293b;
        color: white;
        text-decoration: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-profile:hover {
        background: #6366f1;
    }

    .btn-clear {
        display: inline-block;
        margin-top: 30px;
        padding: 12px 30px;
        background: transparent;
        border: 2px solid #e2e8f0;
        color: #64748b;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-clear:hover {
        background: #fee2e2;
        color: #ef4444;
        border-color: #fecaca;
    }

    .error-message {
        max-width: 500px;
        margin: 0 auto;
        border: 2px dashed #e2e8f0;
    }
    /* --- Custom Cursor (Mint Theme) --- */
        #cursor {
            position: fixed;
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            pointer-events: none;
            z-index: 10000;
        }

        #cursor-follower {
            position: fixed;
            width: 40px; height: 40px;
            border: 1px solid var(--accent);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            opacity: 0.4;
            transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }
        

    </style>

</head>
<body>

    <!-- HEADER -->
    <?php 
        include './includes/header.php'; 
    ?>
    <!-- HERO -->
    <?php 
        include './includes/hero.php'; 
    ?>
    <!-- DOCTORS -->
    <?php 
        include './includes/doctors.php'; 
    ?>
    <!-- SPECIALITIES -->
    <?php 
        include './includes/specialities.php'; 
    ?>
    <!-- APPLIANCE -->
    <?php 
        include './includes/appliance.php'; 
    ?>
    <!-- BLOG -->
    <?php 
        include './includes/blog.php'; 
    ?>
    <!-- CONTACT -->
    <?php 
        include './includes/contact.php'; 
    ?>
    <!-- JS CODE -->
    <script 
        src="./js/script.js">
    </script>
    <!-- FOOTER CODE -->
    <?php 
        include './includes/footer.php'; 
    ?>



</body>
</html>