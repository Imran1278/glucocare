<?php
/* ================= HEADER SETTINGS SECTION ================= */
if ($page == 'header_settings') {

    // 1. Delete Link Logic
    if (isset($_GET['del_nav'])) {
        $del_id = intval($_GET['del_nav']);
        mysqli_query($conn, "DELETE FROM site_settings WHERE id = $del_id");
        echo "<script>window.location.href='admin_panel.php?page=header_settings';</script>";
    }

    // 2. Update Branding (Logo & Title) Logic
    if (isset($_POST['update_header'])) {
        $title = mysqli_real_escape_string($conn, $_POST['site_title']);
        
        // Title Update
        mysqli_query($conn, "UPDATE site_settings SET setting_value='$title' WHERE setting_key='site_title'");
        echo "<script>alert('Branding Updated!'); window.location.href='admin_panel.php?page=header_settings';</script>";
    }

    // 3. Add New Nav Link Logic
    if (isset($_POST['add_nav'])) {
        $label = "nav_" . mysqli_real_escape_string($conn, $_POST['nav_label']);
        $url = mysqli_real_escape_string($conn, $_POST['nav_url']);
        mysqli_query($conn, "INSERT INTO site_settings (setting_key, setting_value, setting_type) VALUES ('$label', '$url', 'link')");
        echo "<script>window.location.href='admin_panel.php?page=header_settings';</script>";
    }

    // 4. Current Title Fetch karein (Error Fix karne ke liye)
    $res_title = mysqli_query($conn, "SELECT setting_value FROM site_settings WHERE setting_key='site_title'");
    $row_title = mysqli_fetch_assoc($res_title);
    $current_site_title = $row_title['setting_value'] ?? 'GluCo';
?>

<div class="header" style="margin-bottom: 20px;">
    <h2><i class="fas fa-desktop"></i> Header & Navigation Settings</h2>
</div>

<div class="flex-container">
    <div class="card" style="flex:1;">
        <h3 style="margin-bottom:15px;"><i class="fas fa-paints-roller"></i> Identity</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="input-box">
                <label>Site Title (Brand Name)</label>
                <input type="text" name="site_title" value="<?php echo $current_site_title; ?>" required>
            </div>
            <button type="submit" name="update_header" class="btn-submit">Update Identity</button>
        </form>

        <hr style="margin:25px 0; border:0; border-top:1px solid var(--border);">

        <h3 style="margin-bottom:15px;"><i class="fas fa-plus-circle"></i> Add Nav Link</h3>
        <form method="POST">
            <div class="input-box">
                <label>Menu Label</label>
                <input type="text" name="nav_label" placeholder="e.g. Services" required>
            </div>
            <div class="input-box">
                <label>URL / Target</label>
                <input type="text" name="nav_url" placeholder="e.g. #services or services.php" required>
            </div>
            <button type="submit" name="add_nav" class="btn-add">Add to Menu</button>
        </form>
    </div>

    <div class="card" style="flex:1.5;">
        <h3 style="margin-bottom:15px;"><i class="fas fa-list"></i> Menu Management</h3>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Menu Label</th>
                        <th>Link/URL</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nav_res = mysqli_query($conn, "SELECT * FROM site_settings WHERE setting_type='link' ORDER BY id ASC");
                    if(mysqli_num_rows($nav_res) > 0){
                        while($n = mysqli_fetch_assoc($nav_res)) { ?>
                        <tr>
                            <td><strong><?php echo str_replace('nav_', '', $n['setting_key']); ?></strong></td>
                            <td><code><?php echo $n['setting_value']; ?></code></td>
                            <td style="text-align:right;">
                                <a href="?page=header_settings&del_nav=<?php echo $n['id']; ?>" 
                                   class="trash-btn" 
                                   onclick="return confirm('Kya aap ye link delete karna chahte hain?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } 
                    } else {
                        echo "<tr><td colspan='3' style='text-align:center;'>No links added yet.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php } ?>