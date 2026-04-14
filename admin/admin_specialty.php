<div class="header" style="margin-bottom: 20px;">
    <h2><i class="fas fa-stethoscope"></i> Specialty Settings</h2>
</div><?php
/* ================= SPECIALTIES ================= */
if ($page == 'specs') {
?>
<div id="specs" class="tab-section">
    <div class="flex-container">
        <div class="card">
            <h3>Add New Specialty</h3>
            <form method="POST" action="process_specialty.php">
                <div class="input-box">
                    <label>Specialty Name</label>
                    <input type="text" name="spec_name" placeholder="e.g. Cardiology" required>
                </div>
                <div class="input-box">
                    <label>FontAwesome Icon Class</label>
                    <input type="text" name="spec_icon" placeholder="fas fa-heartbeat" required>
                </div>
                <div class="input-box">
                    <label>Color Theme</label>
                    <select name="spec_color">
                        <option value="red">Red</option>
                        <option value="blue">Blue</option>
                        <option value="purple">Purple</option>
                        <option value="green">Green</option>
                        <option value="orange">Orange</option>
                    </select>
                </div>
                <button type="submit" name="add_spec" class="btn-add">Save Specialty</button>
            </form>
        </div>

        <div class="card">
            <h3>Specialties List</h3>
            <table>
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Specialty Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $s_res = mysqli_query($conn, "SELECT * FROM specialties ORDER BY id DESC");
                    while($s_row = mysqli_fetch_assoc($s_res)) {
                    ?>
                    <tr>
                        <td><i class="<?php echo $s_row['spec_icon']; ?>" style="color:var(--primary); font-size:20px;"></i></td>
                        <td style="font-weight:700;"><?php echo $s_row['spec_name']; ?></td>
                        <td>
                            <a href="process_specialty.php?delete=<?php echo $s_row['id']; ?>" class="trash-btn">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
}