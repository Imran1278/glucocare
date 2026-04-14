<!-- SIDEBAR -->
<div class="sidebar">
        <div class="brand">
            <i class="fas fa-hand-holding-medical"></i> GlucoCare Admin
        </div>
        <ul class="nav-menu">
        <li><a class="nav-item <?=($page=='doctors')?'active':''?>" href="?page=doctors"><i class="fas fa-user-md"></i> Doctors</a></li>
        <li><a class="nav-item <?=($page=='appointments')?'active':''?>" href="?page=appointments"><i class="fas fa-calendar-check"></i> Appointments</a></li>
        <li><a class="nav-item <?=($page=='specs')?'active':''?>" href="?page=specs"><i class="fas fa-stethoscope"></i> Specialties</a></li>
        <li><a class="nav-item <?=($page=='blogs')?'active':''?>" href="?page=blogs"><i class="fas fa-blog"></i> Blogs</a></li>
        <li><a class="nav-item <?=($page=='contact_settings')?'active':''?>" href="?page=contact_settings"><i class="fas fa-address-book"></i> Contact Info</a></li>
        <li><a class="nav-item <?=($page=='header_settings')?'active':''?>" href="?page=header_settings"><i class="fas fa-header"></i> Header Settings</a></li>
        <li><a class="nav-item <?=($page=='hero_settings')?'active':''?>" href="?page=hero_settings"><i class="fas fa-magic"></i> Hero Settings</a></li>
        <li><a class="nav-item <?=($page=='appliance_settings')?'active':''?>" href="?page=appliance_settings"><i class="fas fa-plug"></i> Appliance Settings</a></li>
        <li><a class="nav-item <?=($page=='footer_settings')?'active':''?>" href="?page=footer_settings"><i class="fas fa-code"></i> Footer Settings</a></li>
    </ul>

        <a href="logout.php" class="btn-logout">Logout</a>
        <a href="../index.php" style="text-align:center; font-size:12px; color:var(--text-light); margin-top:15px; text-decoration:none; font-weight:600;">View Main Page</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Overview Dashboard</h1>
            <p style="color:var(--text-light);">Welcome back, <strong><?php echo $_SESSION['admin_name']; ?></strong></p>
        </div>

        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-user-md"></i></div>
                <div>
                    <?= $total_doctors ?>
                    <p style="color:var(--text-light); font-size: 12px; font-weight: 600;">Total Doctors</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-calendar-alt"></i></div>
                <div><h3 style="font-size: 24px;"></h3><?= $total_pending ?><p style="color:var(--text-light); font-size: 12px; font-weight: 600;">Pending Bookings</p></div> 
            </div>

            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-stethoscope"></i></div>
                <div>
                    <?= $total_specs ?>
                    <p style="color:var(--text-light); font-size: 12px; font-weight: 600;">Specialties</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple" style="background:#f3e8ff; color:#a855f7;"><i class="fas fa-link"></i></div>
                <div>
                    <?= $total_nav ?>
                    <p style="color:var(--text-light); font-size: 12px; font-weight: 600;">Menu Links</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon red" style="background:#fee2e2; color:#ef4444;"><i class="fas fa-blog"></i></div>
                <div>
                    <?= $total_blogs ?>
                    <p style="color:var(--text-light); font-size: 12px; font-weight: 600;">Blog Posts</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon yellow" style="background:#fef9c3; color:#ca8a04;"><i class="fas fa-address-book"></i></div>
                <div>
                    <?= $total_contact ?>
                    <p style="color:var(--text-light); font-size: 12px; font-weight: 600;">Contact Details</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon black" style="background:#fef9c3; color:#ca8a04;"><i class="fas fa-magic"></i></div>
                <div>
                    <?= $total_hero ?>
                    <p style="color:var(--text-light); font-size: 12px; font-weight: 600;">Hero Details</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon blue" style="background:#fef9c3; color:#ca8a04;"><i class="fas fa-plug"></i></div>
                <div>
                    <?= $total_appliance ?>
                    <p style="color:var(--text-light); font-size: 12px; font-weight: 600;">Appliance Details</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon black" style="background:#fef9c3; color:#ca8a04;"><i class="fas fa-code"></i></div>
                <div>
                    <?= $total_footer ?>
                    <p style="color:var(--text-light); font-size: 12px; font-weight: 600;">Footer Details</p>
                </div>
            </div>

        </div>