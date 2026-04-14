<?php
include 'db.php';
session_start();

// Data fetch karein
$settings_res = mysqli_query($conn, "SELECT * FROM site_settings");
$settings = [];
$nav_links = [];

while($row = mysqli_fetch_assoc($settings_res)) {
    if($row['setting_type'] == 'link') {
        $nav_links[$row['setting_key']] = $row['setting_value'];
    } else {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
}

$logo_text = $settings['site_title'] ?? 'GluCo';
$logo_img = $settings['site_logo'] ?? 'logo.png';
?>
<style>
/* ================= ROOT VARIABLES ================= */
:root {
    --primary: #4f46e5;
    --text: #111827;
    --bg: rgba(255, 255, 255, 0.75);
    --glass: rgba(255,255,255,0.6);
}

/* ================= DARK MODE ================= */
body.dark-mode {
    --text: #f9fafb;
    --bg: rgba(17, 24, 39, 0.9);
    --glass: rgba(31, 41, 55, 0.6);
    background: #111827;
    transition: 0.3s ease;
}

/* ================= HEADER ================= */
.main-header {
    width: 100%;
    position: sticky;
    top: 0;
    z-index: 1000;
    backdrop-filter: blur(14px);
    background: var(--bg);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    border-bottom: 1px solid rgba(255,255,255,0.2);
    transition: 0.3s ease;
}

.nav-container {
    max-width: 1300px;
    margin: auto;
    padding: 14px 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* ================= LOGO ================= */
.logo {
    font-size: 26px;
    font-weight: 700;
    color: var(--text);
    text-decoration: none;
}

.logo span {
    color: var(--primary);
}

/* ================= NAV LINKS ================= */
.nav-links {
    list-style: none;
    display: flex;
    gap: 28px;
    transition: 0.3s ease;
}

.nav-links li a {
    text-decoration: none;
    color: var(--text);
    font-size: 15px;
    font-weight: 500;
    position: relative;
}

.nav-links li a::after {
    content: "";
    position: absolute;
    width: 0%;
    height: 2px;
    bottom: -4px;
    left: 0;
    background: var(--primary);
    transition: 0.3s;
}

.nav-links li a:hover::after {
    width: 100%;
}

/* ================= SEARCH ================= */
.search-container {
    flex: 1;
    max-width: 400px;
    margin: 0 30px;
}

.search-form {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

.search-input {
    width: 100%;
    padding: 10px 14px 10px 42px;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.08);
    background: var(--glass);
    backdrop-filter: blur(6px);
    outline: none;
    color: var(--text);
    transition: 0.3s;
}

.search-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
}

/* ================= AUTH ================= */
.auth-group {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-welcome {
    font-size: 14px;
    color: var(--text);
}

.btn-outline {
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: 1.5px solid var(--primary);
    color: var(--primary);
    transition: 0.3s;
}

.btn-outline:hover {
    background: var(--primary);
    color: #fff;
}

.btn-logout {
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    background: #ef4444;
    color: #fff;
    transition: 0.3s;
}

.btn-logout:hover {
    background: #dc2626;
}

/* ================= ICON TOGGLES ================= */
.menu-toggle,
.dark-toggle {
    font-size: 20px;
    cursor: pointer;
    margin-left: 15px;
    color: var(--text);
}

/* ================= MOBILE ================= */
@media (max-width: 992px) {

    .menu-toggle {
        display: block;
    }

    .nav-links {
        position: absolute;
        top: 70px;
        left: 0;
        width: 100%;
        flex-direction: column;
        background: var(--bg);
        backdrop-filter: blur(20px);
        padding: 20px 0;
        display: none;
        text-align: center;
        gap: 20px;
    }

    .nav-links.active {
        display: flex;
    }

    .search-container,
    .auth-group {
        display: none;
    }
}
.logo-img { height: 40px; vertical-align: middle; margin-right: 5px; }
</style>

<header class="main-header">
    <nav class="nav-container">
        <a href="index.php" class="logo">
            <?php 
                // Pehle 4 characters ko normal aur baki ko Span mein dikhane ke liye
                $first_part = substr($logo_text, 0, 3);
                $second_part = substr($logo_text, 3);
                echo $first_part . "<span>" . $second_part . "</span>";
            ?>
        </a>

        <ul class="nav-links" id="navLinks">
            <?php foreach($nav_links as $key => $link): 
                $label = str_replace('nav_', '', $key); // 'nav_Home' se 'Home' banane ke liye
            ?>
                <li><a href="<?php echo $link; ?>"><?php echo $label; ?></a></li>
            <?php endforeach; ?>
        </ul>

        <div class="search-container">
            <form action="includes/search.php" method="GET" class="search-form">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="query" class="search-input" placeholder="Search..." required>
            </form>
        </div>

        <div class="auth-group">
            <?php if(isset($_SESSION['patient_name'])): ?>
                <span class="user-welcome">Hi, <strong><?php echo $_SESSION['patient_name']; ?></strong></span>
                <a href="./user/my_appointments.php" class="btn-outline">My Bookings</a>
                <a href="./user/logout.php" class="btn-logout">Logout</a>
            <?php else: ?>
                <a href="./user/login.php" class="btn-outline">Login</a>
                <a href="./user/register.php" class="btn-outline">Register</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
