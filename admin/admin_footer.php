<?php
include '../db.php';

// Update Logic
if(isset($_POST['update_footer'])) {
    $name = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $desc = mysqli_real_escape_string($conn, $_POST['brand_description']);
    $fb = mysqli_real_escape_string($conn, $_POST['fb_link']);
    $tw = mysqli_real_escape_string($conn, $_POST['tw_link']);
    $inst = mysqli_real_escape_string($conn, $_POST['inst_link']);
    $copy = mysqli_real_escape_string($conn, $_POST['copyright_text']);

    // Check if copyright column exists, if not, update others or add it to table
    $update = "UPDATE footer_settings SET 
                brand_name='$name', 
                brand_description='$desc', 
                fb_link='$fb', 
                tw_link='$tw', 
                inst_link='$inst' 
               WHERE id=1";
    
    if(mysqli_query($conn, $update)) {
        $success = true;
    }
}

$res = mysqli_query($conn, "SELECT * FROM footer_settings WHERE id=1");
$footer = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Management | Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header Styling */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .admin-header h1 {
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .admin-header p {
            color: var(--text-muted);
            margin-top: 5px;
        }

        /* Main Card */
        .settings-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary);
        }

        /* Form Controls */
        .grid-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 16px;
        }

        input, textarea {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-family: inherit;
            font-size: 15px;
            color: var(--text-main);
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        textarea {
            padding-left: 15px;
            resize: vertical;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        /* Social Media Inputs */
        .social-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        /* Submit Button */
        .footer-actions {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
        }

        .btn-update {
            background: var(--primary);
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-update:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        /* Success Toast */
        .toast {
            background: var(--success);
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            position: fixed;
            top: 30px;
            right: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s ease forwards;
            z-index: 1000;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @media (max-width: 768px) {
            .grid-inputs, .social-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<?php if(isset($success)): ?>
    <div class="toast" id="successToast">
        <i class="fas fa-check-circle"></i>
        Footer Settings Updated Successfully!
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('successToast').style.display = 'none';
        }, 3000);
    </script>
<?php endif; ?>

<div class="container">
    <div class="admin-header">
        <div>
            <h1>Footer Customization</h1>
            <p>Manage your brand identity and footer links from one place.</p>
        </div>
        <a href="../index.php" target="_blank" style="text-decoration: none; color: var(--primary); font-weight: 700;">
            <i class="fas fa-external-link-alt"></i> View Site
        </a>
    </div>

    <form method="POST">
        <div class="settings-card">
            
            <div class="section-title">
                <i class="fas fa-id-badge"></i> Brand Identity
            </div>
            
            <div class="form-group">
                <label>Brand Name</label>
                <div class="input-wrapper">
                    <i class="fas fa-hospital"></i>
                    <input type="text" name="brand_name" value="<?php echo htmlspecialchars($footer['brand_name']); ?>" placeholder="e.g. GlucoCare" required>
                </div>
            </div>

            <div class="form-group">
                <label>Brand Description (Bio)</label>
                <textarea name="brand_description" rows="4" placeholder="Briefly describe your healthcare services..."><?php echo htmlspecialchars($footer['brand_description']); ?></textarea>
            </div>

            <hr style="border: 0; border-top: 1px solid var(--border); margin: 30px 0;">

            <div class="section-title">
                <i class="fas fa-share-nodes"></i> Social Connections
            </div>
            
            <div class="social-grid">
                <div class="form-group">
                    <label>Facebook Link</label>
                    <div class="input-wrapper">
                        <i class="fab fa-facebook-f"></i>
                        <input type="text" name="fb_link" value="<?php echo htmlspecialchars($footer['fb_link']); ?>" placeholder="https://facebook.com/...">
                    </div>
                </div>
                <div class="form-group">
                    <label>Twitter/X Link</label>
                    <div class="input-wrapper">
                        <i class="fab fa-twitter"></i>
                        <input type="text" name="tw_link" value="<?php echo htmlspecialchars($footer['tw_link']); ?>" placeholder="https://twitter.com/...">
                    </div>
                </div>
                <div class="form-group">
                    <label>Instagram Link</label>
                    <div class="input-wrapper">
                        <i class="fab fa-instagram"></i>
                        <input type="text" name="inst_link" value="<?php echo htmlspecialchars($footer['inst_link']); ?>" placeholder="https://instagram.com/...">
                    </div>
                </div>
            </div>

            <div class="footer-actions">
                <button type="submit" name="update_footer" class="btn-update">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </div>
    </form>
</div>

</body>
</html>