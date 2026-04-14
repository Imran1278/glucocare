<div class="header" style="margin-bottom: 20px;">
    <h2><i class="fas fa-blog"></i> Add And Edit Blogs Settings</h2>
</div>
<?php
/* ================= BLOGS ================= */
if ($page == 'blogs') {
?>
<div id="blogs" class="tab-section">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
            <h3>Manage Patient Blogs</h3>
            <span class="badge-premium" style="background:var(--primary-soft); color:var(--primary); padding:5px 15px; border-radius:10px; font-weight:700;">
                <?php 
                $b_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM blogs");
                echo mysqli_fetch_assoc($b_count)['total'];
                ?> Blogs Total
            </span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Blog Info</th>
                    <th>Patient Name</th>
                    <th>Specialty (Tag)</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $blog_res = mysqli_query($conn, "SELECT * FROM blogs ORDER BY id DESC");
                while($blog = mysqli_fetch_assoc($blog_res)) {
                ?>
                <tr>
                    <td style="display:flex; align-items:center; gap:12px;">
                        <img src="../uploads/<?php echo $blog['image']; ?>" class="doc-thumb" style="border-radius:8px; width:60px; height:40px;">
                        <div>
                            <div style="font-weight:700; color:var(--text-dark);"><?php echo substr($blog['title'], 0, 30); ?>...</div>
                            <div style="font-size:11px; color:var(--text-light);"><?php echo substr($blog['content'], 0, 40); ?>...</div>
                        </div>
                    </td>
                    <td style="font-weight:600;"><i class="fas fa-user-circle"></i> <?php echo $blog['patient_name']; ?></td>
                    <td><span class="dept-badge" style="background:#fef3c7; color:#92400e;"><?php echo $blog['tags']; ?></span></td>
                    <td style="font-size:13px;"><?php echo date('M d, Y', strtotime($blog['created_at'])); ?></td>
                    <td>
                        <a href="process_blog.php?delete=<?php echo $blog['id']; ?>" class="trash-btn" onclick="return confirm('Delete this blog permanently?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php
}