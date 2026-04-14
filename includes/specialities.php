<style>
    /* SPECIALITIES SECTION STYLING */
.specialities-section {
    padding: 80px 0;
    background-color: #f8fafc;
}

.sec-header {
    text-align: center;
    margin-bottom: 50px;
}

.badge-premium {
    background: #eef2ff;
    color: #4f46e5;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
}

.sec-header h2 {
    font-size: 36px;
    font-weight: 800;
    color: #1e293b;
    margin: 15px 0;
}

.sec-subtext {
    color: #64748b;
    font-size: 16px;
}

/* SLIDER WRAPPER */
.spec-slider-wrapper {
    overflow: hidden;
    padding: 20px 0;
}

.spec-flex-container {
    display: flex;
    gap: 25px;
    transition: transform 0.5s ease;
    padding: 10px;
}

/* MODERN SPECIALITY CARD */
.modern-spec-card {
    min-width: 200px;
    background: #ffffff;
    padding: 30px 20px;
    border-radius: 24px;
    text-align: center;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.modern-spec-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    border-color: #4f46e5;
}

/* ICON WRAPPER & COLORS */
.icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin: 0 auto 20px;
}

/* Dynamic Colors from Database */
.color-red { background: #fee2e2; color: #ef4444; }
.color-blue { background: #dbeafe; color: #3b82f6; }
.color-purple { background: #f3e8ff; color: #a855f7; }
.color-orange { background: #ffedd5; color: #f97316; }
.color-green { background: #dcfce7; color: #10b981; }
.color-cyan { background: #cffafe; color: #0891b2; }

.spec-link {
    text-decoration: none;
}

.spec-info h4 {
    color: #1e293b;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 5px;
}

.spec-info span {
    color: #64748b;
    font-size: 14px;
    font-weight: 500;
}

/* SLIDER CONTROLS */
.slider-controls {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 40px;
}

.ctrl-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 1px solid #e2e8f0;
    background: white;
    color: #1e293b;
    cursor: pointer;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ctrl-btn:hover {
    background: #4f46e5;
    color: white;
    border-color: #4f46e5;
}
</style>
<section id="specialities" class="specialities-section">
    <div class="container-fluid">
        <div class="sec-header">
            <span class="badge-premium">Explore Specialities</span>
            <h2>Highlighting the Care & Support</h2>
            <p class="sec-subtext">Find experienced doctors across various medical fields</p>
        </div>

        <div class="spec-slider-wrapper">
            <div class="spec-flex-container">
                <?php
                $all_specs = mysqli_query($conn, "SELECT * FROM specialties");
                while($s = mysqli_fetch_assoc($all_specs)) {
                    // Counting doctors for this specific specialty
                    $spec_name = $s['spec_name'];
                    $count_q = mysqli_query($conn, "SELECT COUNT(*) as d_count FROM doctors WHERE specialty = '$spec_name'");
                    $count_d = mysqli_fetch_assoc($count_q);
                ?>
                <div class="modern-spec-card">
                    <div class="icon-wrapper color-<?php echo $s['spec_color']; ?>">
                        <i class="<?php echo $s['spec_icon']; ?>"></i>
                    </div>
                    <a href="./Specialities/speciality_details.php?type=<?php echo urlencode($s['spec_name']); ?>" class="spec-link">
                        <div class="spec-info">
                            <h4><?php echo $s['spec_name']; ?></h4>
                            <span><?php echo $count_d['d_count']; ?> Doctors</span>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="slider-controls">
            <button class="ctrl-btn prev" onclick="moveSlider(-1)">
                <i class="fas fa-arrow-left"></i>
            </button>
            <button class="ctrl-btn next" onclick="moveSlider(1)">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
        </div>
</section>