<?php
include_once 'db.php';

// Table se sara data fetch karna
$info_query = mysqli_query($conn, "SELECT * FROM site_info");
$site_data = [];

while($row = mysqli_fetch_assoc($info_query)) {
    // Hum info_type ko key bana rahe hain taake asani se call kar sakein
    $site_data[$row['info_type']] = $row['content'];
}

// Fetch Footer Text & Socials
$f_res = mysqli_query($conn, "SELECT * FROM footer_settings WHERE id=1");
$f_data = mysqli_fetch_assoc($f_res);

// Fetch Departments from specialties table
$spec_query = mysqli_query($conn, "SELECT spec_name FROM specialties LIMIT 9");
?>
<div class="chatbot-container" id="waChatbot">
    <div class="chat-header">
        <img src="./pics/logo.png" alt="Support">
        <div class="chat-header-info">
            <h5>GlucoCare Support</h5>
            <span><i class="fas fa-circle" style="color: #4ade80; font-size: 8px;"></i> Online</span>
        </div>
        <button onclick="toggleChat()" style="margin-left: auto; background: none; border: none; color: white; cursor: pointer; font-size: 18px;">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="chat-body">
        <div class="chat-bubble">
            Hi there! 👋<br><br>
            Welcome to <b>GlucoCare</b>. How can we help you today with your medical appointment?
        </div>
    </div>
    
    <div class="chat-footer">
        <a href="https://wa.me/923001234567?text=Hi, I need help with GlucoCare" target="_blank" class="btn-start-chat">
            <i class="fab fa-whatsapp"></i> Start Live Chat
        </a>
    </div>
</div>

<a href="javascript:void(0)" class="wa-float" onclick="toggleChat()">
    <div class="wa-badge"></div>
    <i class="fab fa-whatsapp"></i>
</a>

<script>
function toggleChat() {
    const chatbot = document.getElementById('waChatbot');
    if (chatbot.style.display === 'flex') {
        chatbot.style.display = 'none';
        chatbot.classList.remove('active');
    } else {
        chatbot.style.display = 'flex';
        setTimeout(() => chatbot.classList.add('active'), 10);
    }
}
</script>
<!-- CONTACT US -->
<footer class="main-footer">
    <div class="footer-cta">
        <h2>Modern Healthcare <br> at your fingertips.</h2>
        <div class="cta-info">
            
            <div class="cta-item">
                <i class="fas fa-phone-alt"></i>
                <div>
                    <span style="font-size: 11px; opacity: 0.8;">Call Us Now</span>
                    <strong style="display: block; font-size: 14px;">
                        <?php echo $site_data['WhatsApp Phone']; ?>
                    </strong>
                    <strong style="display: block; font-size: 14px; border-top: 1px solid rgba(255,255,255,0.1); margin-top: 2px; padding-top: 2px;">
                        <?php echo $site_data['Calling Number Phone']; ?>
                    </strong>
                </div>
            </div>

            <div class="cta-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <span style="font-size: 11px; opacity: 0.8;">Email Support</span>
                    <strong style="display: block; font-size: 14px;">
                        <?php echo $site_data['Primary Email Email']; ?>
                    </strong>
                </div>
            </div>

        </div>
    </div>

    <div class="footer-content">
    <div class="footer-col">
        <a href="index.php" class="brand-logo">
            <?php 
                // Pehlay 4 letters ko alag style dena (e.g., Gluco)
                $name = $f_data['brand_name'];
                echo substr($name, 0, 4) . '<span>' . substr($name, 4) . '</span>';
            ?>
        </a>
        <p style="font-size: 14px; line-height: 1.6; color: var(--footer-text);">
            <?php echo $f_data['brand_description']; ?>
        </p>
        <div style="display: flex; gap: 15px; margin-top: 20px;">
            <a href="<?php echo $f_data['fb_link']; ?>" style="color:white; font-size: 20px;"><i class="fab fa-facebook"></i></a>
            <a href="<?php echo $f_data['tw_link']; ?>" style="color:white; font-size: 20px;"><i class="fab fa-x-twitter"></i></a>
            <a href="<?php echo $f_data['inst_link']; ?>" style="color:white; font-size: 20px;"><i class="fab fa-instagram"></i></a>
        </div>
    </div>

    <div class="footer-col">
        <h4>Departments</h4>
        <ul>
            <?php while($spec = mysqli_fetch_assoc($spec_query)): ?>
                <li><a href="Specialities/speciality_details.php?type=<?php echo urlencode($spec['spec_name']); ?>">
                    <?php echo $spec['spec_name']; ?>
                </a></li>
            <?php endwhile; ?>
        </ul>
    </div>

    <div class="footer-col">
        <h4>Quick Links</h4>
        <ul>
            <li><a href="index.php"><i class="fas fa-chevron-right" style="font-size: 10px;"></i> Home</a></li>
            <li><a href="includes/all-doctors.php"><i class="fas fa-chevron-right" style="font-size: 10px;"></i> Browse Doctors</a></li>
            <li><a href="includes/schedule.php"><i class="fas fa-chevron-right" style="font-size: 10px;"></i> My Appointments</a></li>
            <li><a href="index.php#contact"><i class="fas fa-chevron-right" style="font-size: 10px;"></i> Support Center</a></li>
        </ul>
    </div>

    <div class="footer-col">
        <h4>Stay Connected</h4>
        <p style="font-size: 13px; color: var(--footer-text);">Subscribe for health tips & news.</p>
        <div class="newsletter-box">
            <form action="./user/quick_login.php" method="POST" style="display: flex; width: 100%;">
                <input type="email" name="patient_email" placeholder="Enter Email" required>
                <button type="submit" name="quick_login_btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

    <div class="footer-bottom" style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; margin-top: 40px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    
        <p style="margin: 0; font-size: 14px; color: var(--footer-text);">© 2026 GlucoCare Health. All rights reserved.</p>
        <div style="display: flex; gap: 20px; align-items: center;">
            <a href="#" style="color: var(--footer-text); text-decoration: none; font-size: 14px; transition: 0.3s;">Privacy Policy</a>
            <a href="#" style="color: var(--footer-text); text-decoration: none; font-size: 14px; transition: 0.3s;">Terms of Service</a>
            <a href="./admin/admin_login.php" target="_blank" title="Admin Login" 
            style="color: rgba(255,255,255,0.5); text-decoration: none; font-size: 16px; transition: 0.3s; margin-left: 10px; border-left: 1px solid rgba(255,255,255,0.2); padding-left: 15px;">
                <i class="fa fa-lock" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='rgba(255,255,255,0.5)'"></i>
            </a>
        </div>
    </div>
</footer>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --footer-bg: #0f172a;
        --footer-accent: #38bdf8;
        --footer-text: #94a3b8;
        --glass-white: rgba(255, 255, 255, 0.05);
        --wa-green: #25d366;
    }

    .main-footer {
        background: var(--footer-bg);
        color: #ffffff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        position: relative;
    }

    /* ===== CTA Banner ===== */
    .footer-cta {
        background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
        padding: 45px 8%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .footer-cta h2 { font-size: 28px; font-weight: 800; margin: 0; color: white; line-height: 1.2; }

    .cta-item {
        display: flex; align-items: center; gap: 15px;
        background: rgba(255,255,255,0.1);
        padding: 12px 20px; border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.1);
        transition: 0.3s;
    }
    .cta-item:hover { transform: translateY(-5px); background: rgba(255,255,255,0.2); }
    .cta-item i { font-size: 22px; color: var(--footer-accent); }
    .cta-item strong { display: block; font-size: 15px; color: white; }

    /* ===== Main Content ===== */
    .footer-content {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
        gap: 40px;
        padding: 70px 8% 40px;
    }

    .brand-logo { font-size: 26px; font-weight: 800; color: white; text-decoration: none; display: block; margin-bottom: 15px; }
    .brand-logo span { color: var(--footer-accent); }
    
    .footer-col h4 { font-size: 17px; font-weight: 700; margin-bottom: 25px; color: white; position: relative; }
    .footer-col h4::after { content: ''; width: 25px; height: 3px; background: var(--footer-accent); position: absolute; left: 0; bottom: -8px; border-radius: 10px; }

    .footer-col ul { list-style: none; padding: 0; }
    .footer-col ul li { margin-bottom: 12px; }
    .footer-col ul li a { color: var(--footer-text); text-decoration: none; font-size: 14px; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; }
    .footer-col ul li a:hover { color: var(--footer-accent); transform: translateX(5px); }

    /* ===== Newsletter ===== */
    .newsletter-box {
        background: var(--glass-white);
        padding: 5px; border-radius: 12px;
        display: flex; border: 1px solid rgba(255,255,255,0.1);
        margin-top: 15px;
    }
    .newsletter-box input { background: transparent; border: none; padding: 10px; color: white; outline: none; flex: 1; font-size: 13px; }
    .newsletter-box button { background: var(--footer-accent); border: none; padding: 8px 15px; border-radius: 8px; font-weight: 700; cursor: pointer; }

    /* ===== Floating WhatsApp ===== */
    .wa-float {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: var(--wa-green);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
        z-index: 1000;
        transition: 0.3s ease;
        text-decoration: none;
    }
    .wa-float:hover { transform: scale(1.1) rotate(10deg); color: white; }
    .wa-float i { animation: wa-jump 2s infinite; }

    @keyframes wa-jump {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    /* ===== Bottom Bar ===== */
    .footer-bottom {
        background: #080d1a; padding: 20px 8%;
        display: flex; justify-content: space-between; align-items: center;
        border-top: 1px solid rgba(255,255,255,0.05); font-size: 13px; color: var(--footer-text);
    }

    @media (max-width: 992px) {
        .footer-content { grid-template-columns: 1fr 1fr; }
        .footer-cta { flex-direction: column; text-align: center; }
    }
    @media (max-width: 600px) {
        .footer-content { grid-template-columns: 1fr; text-align: center; }
        .footer-col h4::after { left: 50%; transform: translateX(-50%); }
    }
    /* ===== WhatsApp Chatbot Popup ===== */
.chatbot-container {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 320px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.15);
    display: none; /* Initially Hidden */
    flex-direction: column;
    overflow: hidden;
    z-index: 1001;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transform-origin: bottom right;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.chatbot-container.active {
    display: flex;
    animation: popupScale 0.4s ease forwards;
}

@keyframes popupScale {
    from { opacity: 0; transform: scale(0.5); }
    to { opacity: 1; transform: scale(1); }
}

.chat-header {
    background: linear-gradient(135deg, #25d366, #128c7e);
    color: white;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.chat-header img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.3);
}

.chat-header-info h5 { margin: 0; font-size: 16px; }
.chat-header-info span { font-size: 12px; opacity: 0.9; }

.chat-body {
    background: #f0f2f5;
    padding: 20px;
    position: relative;
}

.chat-bubble {
    background: white;
    padding: 12px 15px;
    border-radius: 0 15px 15px 15px;
    font-size: 13px;
    color: #4a4a4a;
    line-height: 1.5;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.chat-footer {
    padding: 15px;
    background: white;
    text-align: center;
}

.btn-start-chat {
    background: #25d366;
    color: white !important;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 14px;
    transition: 0.3s;
}

.btn-start-chat:hover { background: #128c7e; transform: translateY(-2px); }

/* Toggle Button Badge */
.wa-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff3b30;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}
</style>