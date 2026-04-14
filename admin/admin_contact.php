<div class="header" style="margin-bottom: 20px;">
    <h2><i class="fas fa-address-book"></i> Contact Info Settings</h2>
</div>
<?php 
/* ================= CONTACT SETTINGS SECTION ================= */
if ($page == 'contact_settings') {
    
    // Delete Logic
    if (isset($_GET['del_info'])) {
        $del_id = intval($_GET['del_info']);
        mysqli_query($conn, "DELETE FROM site_info WHERE id = $del_id");
        echo "<script>window.location.href='admin_panel.php?page=contact_settings';</script>";
    }

    // Save Logic
    if (isset($_POST['save_contact'])) {
        $type = mysqli_real_escape_string($conn, $_POST['info_type']);
        $label = mysqli_real_escape_string($conn, $_POST['info_label']); // Label like 'WhatsApp', 'Work', 'Home'
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        
        // Auto Icon Selection based on type and label
        $icon = 'fas fa-info-circle';
        if ($type == 'Phone') {
            $icon = ($label == 'WhatsApp') ? 'fab fa-whatsapp' : 'fas fa-phone';
        } elseif ($type == 'Email') {
            $icon = 'fas fa-envelope';
        } elseif ($type == 'Location') {
            $icon = 'fas fa-map-marker-alt';
        } elseif ($type == 'Link') {
            $icon = 'fas fa-globe';
        }

        $final_type = $label . " " . $type; // e.g., "WhatsApp Phone" or "Office Location"

        mysqli_query($conn, "INSERT INTO site_info (info_type, content, icon) VALUES ('$final_type', '$content', '$icon')");
        echo "<script>window.location.href='admin_panel.php?page=contact_settings';</script>";
    }
}
?>

<div class="flex-container">
    <div class="card" style="flex:1;">
        <h3><i class="fas fa-plus-circle"></i> Add Contact Detail</h3>
        <p style="font-size: 12px; color: var(--text-light); margin-bottom: 20px;">Pehle type select karein phir details likhein.</p>
        
        <form method="POST">
            <div class="input-box">
                <label>Main Category</label>
                <select name="info_type" id="main_type" onchange="updateLabels()" required>
                    <option value="Phone">Phone / Mobile</option>
                    <option value="Email">Email Address</option>
                    <option value="Location">Address / Location</option>
                    <option value="Link">Website / Social Link</option>
                </select>
            </div>

            <div class="input-box">
                <label>Sub-Type / Label</label>
                <select name="info_label" id="sub_label" required>
                    </select>
            </div>
            
            <div class="input-box">
                <label>Actual Detail</label>
                <input type="text" name="content" placeholder="Enter number, email or link..." required>
            </div>
            
            <button type="submit" name="save_contact" class="btn-add">
                <i class="fas fa-save"></i> Add to Contact List
            </button>
        </form>
    </div>

    <div class="card" style="flex:1.5;">
        <h3><i class="fas fa-list"></i> Live Information</h3>
        <table>
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Category</th>
                    <th>Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $info_res = mysqli_query($conn, "SELECT * FROM site_info ORDER BY id DESC");
                while($info = mysqli_fetch_assoc($info_res)) { ?>
                <tr>
                    <td><i class="<?= $info['icon'] ?>" style="color:var(--primary);"></i></td>
                    <td><small><b><?= $info['info_type'] ?></b></small></td>
                    <td style="font-size:13px;"><?= $info['content'] ?></td>
                    <td><a href="?page=contact_settings&del_info=<?= $info['id'] ?>" class="trash-btn" onclick="return confirm('Delete this info?')"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
// Admin Panel
    function updateLabels() {
        const mainType = document.getElementById('main_type').value;
        const subLabel = document.getElementById('sub_label');
        subLabel.innerHTML = '';

        const options = {
            'Phone': ['WhatsApp', 'Calling Number', 'Landline', 'Emergency'],
            'Email': ['Primary Email', 'Support Email', 'Business Email'],
            'Location': ['Main Office', 'Branch Office', 'Headquarters'],
            'Link': ['Website', 'Facebook', 'Instagram', 'LinkedIn']
        };

        options[mainType].forEach(opt => {
            let el = document.createElement('option');
            el.textContent = opt;
            el.value = opt;
            subLabel.appendChild(el);
        });
    }
    // Initial call
    updateLabels();
</script>