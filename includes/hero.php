<?php
$h_res = mysqli_query($conn, "SELECT * FROM hero_settings LIMIT 1");
$h = mysqli_fetch_assoc($h_res);

// Agar main title khali hai to section render nahi hoga
if (!$h || empty($h['main_title'])) {
    return; 
}
?>

<section style="padding: 100px 0; background: #fff; position: relative; overflow: hidden; font-family: 'Inter', sans-serif;">
    <div style="max-width: 1250px; margin: auto; display: flex; align-items: center; padding: 0 20px; gap: 50px;">
        
        <div style="flex: 1.2;">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; display: inline-flex; align-items: center; gap: 10px; padding: 10px 20px; border-radius: 50px; font-weight: 700; color: #1e293b; font-size: 14px; margin-bottom: 30px;">
                <span style="color: #f59e0b;">★★★★★</span> <?= $h['badge_text'] ?>
            </div>
            
            <h1 style="font-size: 62px; font-weight: 900; color: #0f172a; line-height: 1.1; margin-bottom: 25px;">
                <?= $h['main_title'] ?> <br><span style="color: #4f46e5;"><?= $h['highlight_title'] ?></span>
            </h1>
            
            <p style="color: #64748b; font-size: 19px; line-height: 1.7; margin-bottom: 40px; max-width: 550px;">
                <?= $h['description'] ?>
            </p>

            <div style="display: flex; gap: 20px; margin-bottom: 60px;">
                <a href="<?= $h['btn1_link'] ?>" style="background: #1e293b; color: #fff; padding: 20px 35px; border-radius: 15px; font-weight: 700; text-decoration: none; box-shadow: 0 10px 20px rgba(0,0,0,0.1); transition: 0.3s;">
                   <?= $h['btn1_text'] ?>
                </a>
                <a href="<?= $h['btn2_link'] ?>" style="background: #fff; color: #1e293b; padding: 20px 30px; border-radius: 15px; font-weight: 700; text-decoration: none; border: 2px solid #f1f5f9; transition: 0.3s;">
                    <?= $h['btn2_text'] ?>
                </a>
            </div>

            <div style="display: flex; gap: 45px; border-top: 1px solid #f1f5f9; padding-top: 35px;">
                <div class="stat-item">
                    <h3 style="margin:0; font-size:32px; font-weight:900; color:#1e293b;"><?= $h['stat1_val'] ?></h3>
                    <p style="margin:0; font-size:12px; color:#94a3b8; font-weight:700; text-transform:uppercase; letter-spacing:1px;"><?= $h['stat1_label'] ?></p>
                </div>
                <div class="stat-item">
                    <h3 style="margin:0; font-size:32px; font-weight:900; color:#1e293b;"><?= $h['stat2_val'] ?></h3>
                    <p style="margin:0; font-size:12px; color:#94a3b8; font-weight:700; text-transform:uppercase; letter-spacing:1px;"><?= $h['stat2_label'] ?></p>
                </div>
                <div class="stat-item">
                    <h3 style="margin:0; font-size:32px; font-weight:900; color:#1e293b;"><?= $h['stat3_val'] ?></h3>
                    <p style="margin:0; font-size:12px; color:#94a3b8; font-weight:700; text-transform:uppercase; letter-spacing:1px;"><?= $h['stat3_label'] ?></p>
                </div>
            </div>
        </div>

        <div style="flex: 1; position: relative; display: flex; justify-content: flex-end;">
            <img src="./uploads/<?= $h['hero_image'] ?>" style="width: 100%; max-width: 480px; z-index: 1; filter: drop-shadow(0 30px 60px rgba(0,0,0,0.12));">

            <div style="position: absolute; bottom: 8%; left: -10%; background: #0f172a; color: #fff; padding: 22px 32px; border-radius: 22px; z-index: 2; box-shadow: 0 25px 50px rgba(0,0,0,0.3);">
                <p style="font-size: 12px; color: #94a3b8; margin: 0; font-weight: 600; text-transform: uppercase;"><?= $h['float1_sub'] ?></p>
                <h4 style="font-size: 22px; font-weight: 800; margin: 5px 0 0;"><?= $h['float1_main'] ?></h4>
            </div>

            <div style="position: absolute; top: 10%; right: -15%; background: #fff; padding: 20px 28px; border-radius: 22px; z-index: 2; box-shadow: 0 20px 40px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 15px; border: 1px solid #f1f5f9;">
                <div style="background: #eef2ff; color: #4f46e5; padding: 12px; border-radius: 14px;"><i class="fas fa-check-circle"></i></div>
                <div>
                    <p style="font-size: 11px; color: #94a3b8; font-weight: 800; margin: 0; text-transform: uppercase;"><?= $h['float2_sub'] ?></p>
                    <h4 style="font-size: 18px; font-weight: 800; margin: 0; color: #1e293b;"><?= $h['float2_main'] ?></h4>
                </div>
            </div>
        </div>

    </div>
</section>