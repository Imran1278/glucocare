<div class="header" style="margin-bottom: 20px;">
    <h2><i class="fas fa-user-md"></i> Add And Edit Doctors Settings</h2>
</div>
<?php
/* ================= DOCTORS ================= */
if ($page == 'doctors') {
?>
<div id="doctors" class="tab-section active">
    <div class="flex-container">
        
        <div class="card form-card">
            <div style="margin-bottom: 20px;">
                <h3 style="color: #1e293b;"><i class="fas fa-user-md"></i> Doctor Registration</h3>
                <p style="font-size: 12px; color: var(--secondary);">Fill in all details to update the medical directory.</p>
            </div>
            
            <form method="POST" action="process_doctor.php" enctype="multipart/form-data">
                <div class="grid-inputs">
                    <div class="input-box"><label>Profile Photo</label><input type="file" name="doc_image" required></div>
                    <div class="input-box"><label>Full Name</label><input type="text" name="doc_name" placeholder="Enter Doctor Name" required></div>
                    
                    <div class="input-box">
                        <label>Specialty</label>
                        <select name="doc_specialty">
                            <?php
                            $get_specs = mysqli_query($conn, "SELECT spec_name FROM specialties");
                            while($s = mysqli_fetch_assoc($get_specs)) { echo "<option>".$s['spec_name']."</option>"; }
                            ?>
                        </select>
                    </div>
                    <div class="input-box"><label>Consultation Fee ($)</label><input type="number" name="doc_price" placeholder="50" required></div>
                    
                    <div class="input-box"><label>Experience (Years)</label><input type="text" name="doc_exp" placeholder="e.g. 15+"></div>
                    <div class="input-box"><label>University</label><input type="text" name="doc_uni" placeholder="e.g. King Edward Medical"></div>
                    <div class="input-box"><label>Languages</label><input type="text" name="doc_lang" placeholder="English, Urdu, Punjabi"></div>
                    <div class="input-box">
                        <label>Status</label>
                        <select name="doc_avail">
                            <option value="Available Now">Available Now</option>
                            <option value="On Leave">On Leave</option>
                        </select>
                    </div>
                </div>

                <div class="input-box full-width"><label>Clinical Address</label><input type="text" name="doc_address" placeholder="Full clinic or hospital address"></div>

                <h4 style="margin: 20px 0 10px; color: var(--primary); border-bottom: 2px solid #eee; padding-bottom: 5px; font-size: 14px;">Weekly Timing & Locations</h4>
                <div class="schedule-container">
                    <?php 
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    foreach($days as $day) {
                    ?>
                    <div class="day-box">
                        <label class="day-label">
                            <i class="fa-regular fa-calendar-check" style="color: #6366f1;"></i> <?= $day ?>
                        </label>
                        
                        <input type="text" 
                            name="schedule[<?= $day ?>][time]" 
                            class="schedule-input" 
                            placeholder="🕒 Time (e.g. 09:00 - 01:00)">
                            
                        <input type="text" 
                            name="schedule[<?= $day ?>][location]" 
                            class="schedule-input" 
                            placeholder="📍 Location / Hospital">
                    </div>
                    <?php } ?>
                </div>

                <div class="input-box full-width"><label>Professional Bio</label><textarea name="doc_bio" rows="2" placeholder="Briefly describe the doctor's expertise..."></textarea></div>
                
                <div class="grid-inputs">
                    <div class="input-box"><label>Phone</label><input type="text" name="doc_phone" placeholder="+92..."></div>
                    <div class="input-box"><label>Email</label><input type="email" name="doc_email" placeholder="doctor@example.com"></div>
                </div>

                <button type="submit" name="add_doctor" class="btn-submit"><i class="fas fa-save"></i> Save Doctor & Sync Profile</button>
            </form>
        </div>

        <div class="card table-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3><i class="fas fa-list"></i> Registered Team</h3>
                <span style="background: var(--primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;">ACTIVE</span>
            </div>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Doctor Info</th>
                            <th>Today's Duty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM doctors ORDER BY id DESC");
                        while($row = mysqli_fetch_assoc($res)) {
                            $sch = json_decode($row['schedule'], true);
                            $today = date('l'); 
                        ?>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <img src="../uploads/<?= $row['image'] ?>" class="user-img">
                                    <div class="user-details">
                                        <span class="user-name"><?= $row['name'] ?></span>
                                        <small style="color: var(--primary); font-weight: 600;"><?= $row['specialty'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 11px; line-height: 1.4;">
                                    <span style="color: var(--secondary);"><?= $today ?>:</span><br>
                                    <strong><?= (!empty($sch[$today]['time'])) ? $sch[$today]['time'] . " @ " . $sch[$today]['location'] : "<span style='color:red;'>Off Duty</span>" ?></strong>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex; gap:8px;">
                                    <a href="process_doctor.php?delete=<?= $row['id'] ?>" class="btn-icon" style="color: #ef4444; background: #fee2e2; padding: 8px; border-radius: 6px;" onclick="return confirm('Delete this doctor?')"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
}