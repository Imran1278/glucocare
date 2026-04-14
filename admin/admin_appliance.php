<?php
if (isset($_POST['save_appliance'])) {
    $btns = [];
    if(isset($_POST['btn_txt'])){
        foreach($_POST['btn_txt'] as $i => $txt) {
            if(!empty($txt)) $btns[] = ['txt' => $txt, 'url' => $_POST['btn_url'][$i]];
        }
    }
    $btns_json = mysqli_real_escape_string($conn, json_encode($btns));
    
    $fields = ['blue_tag','main_title','r1_t','r1_d','r2_t','r2_d','r3_t','r3_d','why_tag','why_title','why_desc','vision_t','vision_d','mission_t','mission_d'];
    $sets = [];
    foreach($fields as $f) { $val = mysqli_real_escape_string($conn, $_POST[$f]); $sets[] = "$f='$val'"; }
    
    foreach(['img1', 'img2'] as $img) {
        if(!empty($_FILES[$img]['name'])) {
            $fn = time()."_".$img.".jpg"; move_uploaded_file($_FILES[$img]['tmp_name'], "../uploads/".$fn);
            $sets[] = "$img='$fn'";
        }
    }
    $sets[] = "buttons_json='$btns_json'";
    mysqli_query($conn, (mysqli_num_rows(mysqli_query($conn, "SELECT id FROM appliance_settings")) > 0) ? "UPDATE appliance_settings SET ".implode(',', $sets)." WHERE id=1" : "INSERT INTO appliance_settings SET ".implode(',', $sets));
    echo "<script>alert('Appliance Section Updated!');</script>";
}
$res = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM appliance_settings LIMIT 1")) ?: [];
$saved_btns = json_decode($res['buttons_json'] ?? '[]', true);
?>

<div style="background:#f4f7fe; padding:40px; border-radius:30px; font-family:'Segoe UI',sans-serif;">
    <form method="POST" enctype="multipart/form-data" id="appForm">
        <div style="display:flex; justify-content:space-between; margin-bottom:30px;">
            <h2 style="color:#0f172a;">Appliance <span style="color:#4f46e5;">Pro Editor</span></h2>
            <button name="save_appliance" style="background:#4f46e5; color:#fff; border:none; padding:12px 35px; border-radius:12px; font-weight:700; cursor:pointer;">Publish Changes</button>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:20px;">
            <div style="grid-column: span 3; background:#fff; padding:25px; border-radius:20px; border:1px solid #e2e8f0;">
                <input type="text" name="blue_tag" placeholder="Blue Tag" value="<?=$res['blue_tag']??''?>" style="width:100%; padding:12px; margin-bottom:15px; border-radius:8px; border:1px solid #ddd;">
                <input type="text" name="main_title" placeholder="Main Appliance Title" value="<?=$res['main_title']??''?>" style="width:100%; padding:12px; border-radius:8px; border:1px solid #ddd; font-weight:700;">
            </div>

            <?php for($i=1;$i<=3;$i++): ?>
            <div style="background:#fff; padding:20px; border-radius:20px; border:1px solid #e2e8f0;">
                <label style="font-size:11px; font-weight:900; color:#4f46e5;">REASON <?=$i?></label>
                <input type="text" name="r<?=$i?>_t" placeholder="Title" value="<?=$res["r{$i}_t"]??''?>" style="width:100%; margin:10px 0; padding:10px; border-radius:8px; border:1px solid #eee;">
                <textarea name="r<?=$i?>_d" placeholder="Description" style="width:100%; height:70px; padding:10px; border-radius:8px; border:1px solid #eee; resize:none;"><?=$res["r{$i}_d"]??''?></textarea>
            </div>
            <?php endfor; ?>

            <div style="grid-column: span 3; background:#0f172a; padding:40px; border-radius:25px; color:#fff; display:grid; grid-template-columns: 1fr 1fr; gap:30px;">
                <div style="grid-column: span 2;">
                    <input type="text" name="why_tag" placeholder="Why Tag" value="<?=$res['why_tag']??''?>" style="background:rgba(255,255,255,0.1); border:none; color:#fff; padding:10px; width:40%; border-radius:5px; margin-bottom:15px;">
                    <input type="text" name="why_title" placeholder="Why Title" value="<?=$res['why_title']??''?>" style="background:none; border-bottom:1px solid #334155; color:#fff; font-size:24px; width:100%; padding:10px 0; margin-bottom:15px;">
                    <textarea name="why_desc" placeholder="Section Description" style="background:none; border:1px solid #334155; color:#94a3b8; width:100%; height:80px; padding:10px; border-radius:10px;"><?=$res['why_desc']??''?></textarea>
                </div>
                
                <div style="background:rgba(255,255,255,0.05); padding:20px; border-radius:15px;">
                    <input type="text" name="vision_t" placeholder="Vision Title" value="<?=$res['vision_t']??''?>" style="width:100%; margin-bottom:10px;">
                    <textarea name="vision_d" placeholder="Vision Desc" style="width:100%; height:50px;"><?=$res['vision_d']??''?></textarea>
                </div>
                <div style="background:rgba(255,255,255,0.05); padding:20px; border-radius:15px;">
                    <input type="text" name="mission_t" placeholder="Mission Title" value="<?=$res['mission_t']??''?>" style="width:100%; margin-bottom:10px;">
                    <textarea name="mission_d" placeholder="Mission Desc" style="width:100%; height:50px;"><?=$res['mission_d']??''?></textarea>
                </div>

                <div style="grid-column:span 2; border-top:1px solid rgba(255,255,255,0.1); padding-top:20px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                        <h4 style="color:#3b82f6; margin:0; font-size:14px; text-transform:uppercase;">Action Buttons (Auto-Link)</h4>
                        <button type="button" onclick="addNewButton()" style="background:#22c55e; color:#fff; border:none; padding:5px 15px; border-radius:8px; cursor:pointer; font-size:12px; font-weight:700;">+ Add Button</button>
                    </div>
    
                    <div id="btnContainer">
                        <?php if(!empty($saved_btns)): foreach($saved_btns as $b): ?>
                        <div class="btn-row" style="display:flex; gap:10px; margin-bottom:10px;">
                            <input type="text" name="btn_txt[]" onkeyup="generateLink(this)" value="<?=$b['txt']?>" placeholder="Button Text" style="flex:1; padding:12px; border-radius:10px; border:none; background:rgba(255,255,255,0.05); color:#fff;">
                            <input type="text" name="btn_url[]" class="btn-url" value="<?=$b['url']?>" placeholder="URL" style="flex:1; padding:12px; border-radius:10px; border:none; background:rgba(255,255,255,0.05); color:#fff;">
                            <button type="button" onclick="this.parentElement.remove()" style="background:#ef4444; border:none; color:#fff; border-radius:8px; padding:0 10px; cursor:pointer;">&times;</button>
                        </div>
                        <?php endforeach; else: ?>
                        <div class="btn-row" style="display:flex; gap:10px; margin-bottom:10px;">
                            <input type="text" name="btn_txt[]" onkeyup="generateLink(this)" placeholder="Button Text" style="flex:1; padding:12px; border-radius:10px; border:none; background:rgba(255,255,255,0.05); color:#fff;">
                            <input type="text" name="btn_url[]" class="btn-url" placeholder="URL" style="flex:1; padding:12px; border-radius:10px; border:none; background:rgba(255,255,255,0.05); color:#fff;">
                        </div>
                        <?php endif; ?>
                    </div>

                    <div style="margin-top:20px; display:flex; gap:20px;">
                        <span>Img 1: <input type="file" name="img1"></span>
                        <span>Img 2: <input type="file" name="img2"></span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function generateLink(input) {
    const row = input.closest('.btn-row');
    const urlInput = row.querySelector('.btn-url');
    
    // Text ko slug mein convert karna (e.g., "Solutions" -> "solutions")
    let slug = input.value.toLowerCase().trim()
        .replace(/[^\w ]+/g, '') // Special characters remove karein
        .replace(/ +/g, '_');    // Spaces ko underscore mein badlein
    
    if(slug) {
        // Aapki requirement ke mutabiq path format
        urlInput.value = "includes\\" + slug + ".php";
    } else {
        urlInput.value = "";
    }
}

function addNewButton() {
    const container = document.getElementById('btnContainer');
    const div = document.createElement('div');
    div.className = 'btn-row';
    div.style.cssText = 'display:flex; gap:10px; margin-bottom:10px;';
    div.innerHTML = `
        <input type="text" name="btn_txt[]" onkeyup="generateLink(this)" placeholder="Button Text" style="flex:1; padding:12px; border-radius:10px; border:none; background:rgba(255,255,255,0.05); color:#fff;">
        <input type="text" name="btn_url[]" class="btn-url" placeholder="URL" style="flex:1; padding:12px; border-radius:10px; border:none; background:rgba(255,255,255,0.05); color:#fff;">
        <button type="button" onclick="this.parentElement.remove()" style="background:#ef4444; border:none; color:#fff; border-radius:8px; padding:0 10px; cursor:pointer;">&times;</button>
    `;
    container.appendChild(div);
}
</script>