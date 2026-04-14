<?php
// Update & Insert Logic
if (isset($_POST['update_hero'])) {
    $badge = mysqli_real_escape_string($conn, $_POST['badge_text']);
    $m_title = mysqli_real_escape_string($conn, $_POST['main_title']);
    $h_title = mysqli_real_escape_string($conn, $_POST['highlight_title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $f1m = mysqli_real_escape_string($conn, $_POST['f1m']); 
    $f1s = mysqli_real_escape_string($conn, $_POST['f1s']);
    $f2m = mysqli_real_escape_string($conn, $_POST['f2m']); 
    $f2s = mysqli_real_escape_string($conn, $_POST['f2s']);
    $b1t = mysqli_real_escape_string($conn, $_POST['b1t']); 
    $b1l = mysqli_real_escape_string($conn, $_POST['b1l']);
    $b2t = mysqli_real_escape_string($conn, $_POST['b2t']); 
    $b2l = mysqli_real_escape_string($conn, $_POST['b2l']);
    
    // Stats Data
    $s1v = mysqli_real_escape_string($conn, $_POST['s1v']); $s1l = mysqli_real_escape_string($conn, $_POST['s1l']);
    $s2v = mysqli_real_escape_string($conn, $_POST['s2v']); $s2l = mysqli_real_escape_string($conn, $_POST['s2l']);
    $s3v = mysqli_real_escape_string($conn, $_POST['s3v']); $s3l = mysqli_real_escape_string($conn, $_POST['s3l']);

    $check = mysqli_query($conn, "SELECT id FROM hero_settings LIMIT 1");
    
    $img_sql = "";
    if (!empty($_FILES['hero_img']['name'])) {
        $img = time() . "_" . $_FILES['hero_img']['name'];
        move_uploaded_file($_FILES['hero_img']['tmp_name'], "../uploads/" . $img);
        $img_sql = ", hero_image='$img'";
    }

    if (mysqli_num_rows($check) > 0) {
        $sql = "UPDATE hero_settings SET badge_text='$badge', main_title='$m_title', highlight_title='$h_title', description='$desc', float1_main='$f1m', float1_sub='$f1s', float2_main='$f2m', float2_sub='$f2s', btn1_text='$b1t', btn1_link='$b1l', btn2_text='$b2t', btn2_link='$b2l', stat1_val='$s1v', stat1_label='$s1l', stat2_val='$s2v', stat2_label='$s2l', stat3_val='$s3v', stat3_label='$s3l' $img_sql WHERE id=1";
    } else {
        $sql = "INSERT INTO hero_settings (badge_text, main_title, highlight_title, description, float1_main, float1_sub, float2_main, float2_sub, btn1_text, btn1_link, btn2_text, btn2_link, stat1_val, stat1_label, stat2_val, stat2_label, stat3_val, stat3_label, hero_image) VALUES ('$badge', '$m_title', '$h_title', '$desc', '$f1m', '$f1s', '$f2m', '$f2s', '$b1t', '$b1l', '$b2t', '$b2l', '$s1v', '$s1l', '$s2v', '$s2l', '$s3v', '$s3l', '$img')";
    }
    
    mysqli_query($conn, $sql);
    echo "<script>alert('Hero Section Updated!'); window.location.href='admin_panel.php?page=hero_settings';</script>";
}

$res = mysqli_query($conn, "SELECT * FROM hero_settings LIMIT 1");
$h = mysqli_fetch_assoc($res) ?: []; 
?>

<style>
    .admin-card { background: #fff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 30px; border: 1px solid #f0f0f0; font-family: 'Segoe UI', sans-serif; }
    .input-group { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .full-row { grid-column: span 2; }
    .form-label { font-weight: 700; color: #334155; margin-bottom: 8px; display: block; font-size: 14px; }
    .form-control { width: 100%; padding: 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; transition: 0.3s; box-sizing: border-box; }
    .btn-save { background: #4f46e5; color: white; border: none; padding: 15px; border-radius: 10px; font-weight: 700; cursor: pointer; width: 100%; margin-top: 20px; font-size: 16px; }
    .stats-box { background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px dashed #cbd5e1; grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; }
</style>

<div style="display: flex; gap: 30px; align-items: flex-start; padding: 20px;">
    <div class="admin-card" style="flex: 1.6;">
        <h2 style="margin-bottom: 25px; color: #1e293b;"><i class="fas fa-edit"></i> Hero Section Management</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <div><label class="form-label">Badge Text</label><input type="text" name="badge_text" id="in_badge" class="form-control" value="<?= $h['badge_text'] ?? '' ?>" oninput="sync()"></div>
                <div><label class="form-label">Highlight Title (Blue)</label><input type="text" name="highlight_title" id="in_h" class="form-control" value="<?= $h['highlight_title'] ?? '' ?>" oninput="sync()"></div>
                <div class="full-row"><label class="form-label">Main Title</label><input type="text" name="main_title" id="in_m" class="form-control" value="<?= $h['main_title'] ?? '' ?>" oninput="sync()"></div>
                <div class="full-row"><label class="form-label">Description</label><textarea name="description" id="in_d" class="form-control" rows="2" oninput="sync()"><?= $h['description'] ?? '' ?></textarea></div>
                
                <div class="stats-box">
                    <div style="grid-column: span 3; font-weight: 800; font-size: 13px; color: #4f46e5; text-transform: uppercase;">Bottom Statistics</div>
                    <div><label class="form-label">Stat 1 (Val/Label)</label><input type="text" name="s1v" placeholder="1.5k+" class="form-control" value="<?= $h['stat1_val'] ?? '' ?>"><input type="text" name="s1l" placeholder="Doctors" class="form-control" value="<?= $h['stat1_label'] ?? '' ?>" style="margin-top:5px;"></div>
                    <div><label class="form-label">Stat 2 (Val/Label)</label><input type="text" name="s2v" placeholder="100%" class="form-control" value="<?= $h['stat2_val'] ?? '' ?>"><input type="text" name="s2l" placeholder="Secure" class="form-control" value="<?= $h['stat2_label'] ?? '' ?>" style="margin-top:5px;"></div>
                    <div><label class="form-label">Stat 3 (Val/Label)</label><input type="text" name="s3v" placeholder="24/7" class="form-control" value="<?= $h['stat3_val'] ?? '' ?>"><input type="text" name="s3l" placeholder="Support" class="form-control" value="<?= $h['stat3_label'] ?? '' ?>" style="margin-top:5px;"></div>
                </div>

                <div><label class="form-label">Float 1 (Main/Sub)</label><input type="text" name="f1m" id="in_f1m" class="form-control" value="<?= $h['float1_main'] ?? '' ?>" oninput="sync()"><input type="text" name="f1s" id="in_f1s" class="form-control" value="<?= $h['float1_sub'] ?? '' ?>" oninput="sync()" style="margin-top:5px;"></div>
                <div><label class="form-label">Float 2 (Main/Sub)</label><input type="text" name="f2m" class="form-control" value="<?= $h['float2_main'] ?? '' ?>"><input type="text" name="f2s" class="form-control" value="<?= $h['float2_sub'] ?? '' ?>" style="margin-top:5px;"></div>

                <div><label class="form-label">Button 1 (Text/Link)</label><input type="text" name="b1t" class="form-control" value="<?= $h['btn1_text'] ?? '' ?>"><input type="text" name="b1l" class="form-control" value="<?= $h['btn1_link'] ?? '' ?>" style="margin-top:5px;"></div>
                <div><label class="form-label">Button 2 (Text/Link)</label><input type="text" name="b2t" class="form-control" value="<?= $h['btn2_text'] ?? '' ?>"><input type="text" name="b2l" class="form-control" value="<?= $h['btn2_link'] ?? '' ?>" style="margin-top:5px;"></div>
                
                <div class="full-row"><label class="form-label">Doctor Image</label><input type="file" name="hero_img" class="form-control"></div>
            </div>
            <button type="submit" name="update_hero" class="btn-save">Publish to Website</button>
        </form>
    </div>

    <div style="flex: 1; background: #1e293b; color: white; border-radius: 15px; padding: 25px; position: sticky; top: 20px;">
        <h4 style="color: #94a3b8; font-size: 12px; text-transform: uppercase; margin-bottom: 20px;">Live Preview</h4>
        <span id="lv_badge" style="font-size: 11px; background: #4f46e5; padding: 4px 12px; border-radius: 20px;"><?= $h['badge_text'] ?? 'Badge' ?></span>
        <h2 id="lv_title" style="margin: 15px 0; line-height: 1.2; font-size: 24px;"><?= $h['main_title'] ?? 'Title' ?> <span style="color: #818cf8;" id="lv_h"><?= $h['highlight_title'] ?? 'Highlight' ?></span></h2>
        <div style="height: 2px; background: rgba(255,255,255,0.1); margin: 20px 0;"></div>
        <p style="font-size: 13px; color: #94a3b8;">Float Main: <b id="lv_f1m_val" style="color:white;"><?= $h['float1_main'] ?? '' ?></b></p>
    </div>
</div>

<script>
function sync() {
    document.getElementById('lv_badge').innerText = document.getElementById('in_badge').value;
    document.getElementById('lv_title').innerHTML = document.getElementById('in_m').value + ' <span style="color: #818cf8;">' + document.getElementById('in_h').value + '</span>';
    document.getElementById('lv_f1m_val').innerText = document.getElementById('in_f1m').value;
}
</script>