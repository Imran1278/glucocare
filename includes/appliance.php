<?php 
// Database se data fetch karna
$query = mysqli_query($conn, "SELECT * FROM appliance_settings LIMIT 1");
$a = mysqli_fetch_assoc($query); 
if(!$a) return; // Agar data na ho to section hide ho jaye

// Buttons JSON ko array mein convert karna
$btns = json_decode($a['buttons_json'] ?? '[]', true);
?>

<section style="padding:100px 0; background:#fff; font-family:'Inter', sans-serif; overflow:hidden;">
    <div style="max-width:1250px; margin:auto; padding:0 25px;">
        
        <div style="text-align:center; margin-bottom:80px;">
            <span style="background:#e0f2fe; color:#0ea5e9; padding:8px 20px; border-radius:50px; font-size:13px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">
                • <?=$a['blue_tag']?>
            </span>
            <h2 style="font-size:52px; color:#0f172a; font-weight:900; margin:20px 0 60px; letter-spacing:-1px;">
                <?=$a['main_title']?>
            </h2>
            
            <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:0; background:#f8fafc; padding:50px 20px; border-radius:30px; border:1px solid #f1f5f9;">
                <?php for($i=1;$i<=3;$i++): ?>
                <div style="padding:0 40px; border-right:<?=($i<3)?'2px solid #e2e8f0':'none'?>;">
                    <h4 style="font-size:22px; color:#1e293b; font-weight:800; margin-bottom:15px;"><?=$a["r{$i}_t"]?></h4>
                    <p style="font-size:15px; color:#64748b; line-height:1.8;"><?=$a["r{$i}_d"]?></p>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <div style="background:#0a192f; border-radius:40px; padding:60px; display:flex; gap:50px; align-items:center; margin-top:50px; overflow:visible;">
    
            <div style="flex:1; position:relative; min-height:420px; display:flex; flex-direction:column; justify-content:center;">
                <div style="width:85%; height:240px; border-radius:25px; overflow:hidden; box-shadow:0 20px 40px rgba(0,0,0,0.4); border:4px solid rgba(255,255,255,0.05); z-index:2; position:relative;">
                    <img src="./uploads/<?=$a['img1']?>" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div style="width:85%; height:240px; border-radius:25px; overflow:hidden; box-shadow:0 20px 40px rgba(0,0,0,0.4); border:4px solid rgba(255,255,255,0.05); margin-top:-80px; margin-left:auto; z-index:1; position:relative;">
                    <img src="./uploads/<?=$a['img2']?>" style="width:100%; height:100%; object-fit:cover;">
                </div>
            </div>

            <div style="flex:1.2; color:#fff;">
                <span style="background:#2563eb; color:#fff; padding:6px 16px; border-radius:6px; font-size:12px; font-weight:700; display:inline-block; margin-bottom:20px;">
                    • <?=$a['why_tag']?>
                </span>
                <h2 style="font-size:36px; font-weight:800; line-height:1.3; margin-bottom:20px; color:#fff;"><?=$a['why_title']?></h2>
                <p style="color:#94a3b8; font-size:16px; line-height:1.7; margin-bottom:30px;"><?=$a['why_desc']?></p>
                
                <div style="display:grid; gap:15px; margin-bottom:35px;">
                    <div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1); padding:20px; border-radius:15px;">
                        <h5 style="font-size:18px; color:#fff; margin:0 0 5px;">01. <?=$a['vision_t']?></h5>
                        <p style="color:#94a3b8; font-size:14px; margin:0;"><?=$a['vision_d']?></p>
                    </div>
                    <div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1); padding:20px; border-radius:15px;">
                        <h5 style="font-size:18px; color:#fff; margin:0 0 5px;">02. <?=$a['mission_t']?></h5>
                        <p style="color:#94a3b8; font-size:14px; margin:0;"><?=$a['mission_d']?></p>
                    </div>
                </div>

                <div style="display:flex; gap:15px; flex-wrap:wrap;">
                    <?php if(!empty($btns)): foreach($btns as $idx => $btn): ?>
                        <a href="<?=$btn['url']?>" 
                           style="display:inline-flex; align-items:center; padding:15px 35px; border-radius:12px; font-weight:800; text-decoration:none; font-size:15px; transition:0.3s;
                           <?= ($idx == 0) ? 'background:#fff; color:#0a192f;' : 'background:transparent; color:#fff; border:2px solid rgba(255,255,255,0.2);' ?>">
                            <?=$btn['txt']?>
                        </a>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>