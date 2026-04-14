<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary-green: #10b981;
        --dark-navy: #0f172a;
        --text-gray: #64748b;
        --light-bg: #f8fafc;
    }

    #blog {
        padding: 100px 5%;
        background-color: var(--light-bg);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .section-title { text-align: center; margin-bottom: 60px; }
    .section-title h2 { font-size: 36px; color: var(--dark-navy); font-weight: 800; margin-bottom: 15px; }
    .section-title p { color: var(--text-gray); max-width: 600px; margin: 0 auto; }

    /* Blog Grid */
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .blog-card {
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
        position: relative;
    }

    .blog-card:hover { transform: translateY(-12px); box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.1); }

    .blog-img-wrapper { position: relative; height: 240px; overflow: hidden; }
    .blog-img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .blog-card:hover .blog-img-wrapper img { transform: scale(1.1); }

    .blog-tag {
        position: absolute; top: 20px; left: 20px;
        background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);
        color: var(--primary-green); padding: 6px 16px; border-radius: 12px;
        font-size: 12px; font-weight: 700; text-transform: uppercase;
    }

    .blog-content { padding: 30px; }
    .blog-date { font-size: 13px; color: var(--primary-green); font-weight: 600; margin-bottom: 10px; display: block; }
    
    .blog-title-link {
        font-size: 22px; color: var(--dark-navy); text-decoration: none;
        font-weight: 700; line-height: 1.4; display: block; margin-bottom: 15px; transition: 0.3s;
    }
    .blog-title-link:hover { color: var(--primary-green); }

    .blog-excerpt { color: var(--text-gray); font-size: 15px; line-height: 1.7; margin-bottom: 25px; }
    .blog-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 20px; border-top: 1px solid #f1f5f9; }

    /* MODAL STYLING */
    .blog-modal {
        display: none; position: fixed; z-index: 9999; left: 0; top: 0;
        width: 100%; height: 100%; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(8px);
    }

    .modal-content {
        background: white; margin: 5% auto; padding: 40px; border-radius: 24px;
        width: 90%; max-width: 550px; position: relative; animation: slideDown 0.4s ease;
    }

    @keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

    .close-modal { position: absolute; right: 25px; top: 20px; font-size: 24px; cursor: pointer; color: var(--text-gray); }

    .modal-content h3 { margin-bottom: 25px; color: var(--dark-navy); font-weight: 800; }

    .modal-content input, .modal-content textarea, .modal-content select {
        width: 100%; padding: 14px; margin-bottom: 15px; border: 1.5px solid #e2e8f0; border-radius: 12px; outline: none; transition: 0.3s;
    }

    .modal-content input:focus, .modal-content textarea:focus { border-color: var(--primary-green); }

    .add-blog-container { text-align: center; margin-bottom: 50px; }
    .btn-create {
        background: var(--dark-navy); color: white; padding: 14px 30px; border-radius: 14px;
        font-weight: 600; transition: 0.3s; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 10px;
    }
    .btn-create:hover { background: var(--primary-green); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); }
</style>

<section id="blog">
    <div class="section-title">
        <h2>Latest Health Insights</h2>
        <p>Expert advice and personal stories from our community.</p>
    </div>

    <div class="add-blog-container">
        <?php if(isset($_SESSION['patient_name'])): ?>
            <button class="btn-create" onclick="openBlogModal()">
                <i class="fas fa-pen-fancy"></i> Share Your Story
            </button>
        <?php endif; ?>
    </div>

    <div class="blog-grid">
        <?php
        include 'db.php';
        $query = "SELECT * FROM blogs ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="blog-card">
                    <div class="blog-img-wrapper">
                        <span class="blog-tag"><?php echo $row['tags']; ?></span>
                        <img src="uploads/<?php echo $row['image']; ?>" alt="Blog Thumbnail">
                    </div>
                    <div class="blog-content">
                        <span class="blog-date"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></span>
                        <a href="includes/blog_details.php?id=<?php echo $row['id']; ?>" class="blog-title-link">
                            <?php echo $row['title']; ?>
                        </a>
                        <p class="blog-excerpt"><?php echo substr($row['content'], 0, 100); ?>...</p>
                        <div class="blog-footer">
                            <div class="author-box"><strong><i class="far fa-user"></i> <?php echo $row['patient_name']; ?></strong></div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else { echo "<p style='text-align:center; grid-column: 1/-1;'>No blogs found.</p>"; }
        ?>
    </div>
</section>

<div id="blogModal" class="blog-modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeBlogModal()">&times;</span>
        <h3>Write New Blog</h3>
        
        <form action="includes/add_blog.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Blog Title" required>
            
            <select name="tags" required>
                <option value="General">General Health</option>
                <option value="Diabetes">Diabetes Tips</option>
                <option value="Fitness">Fitness & Exercise</option>
                <option value="Diet">Diet & Nutrition</option>
            </select>

            <textarea name="content" rows="6" placeholder="Share your experience or advice..." required></textarea>
            
            <label style="display:block; margin-bottom:10px; font-weight:600; color:var(--dark-navy);">Upload Cover Image:</label>
            <input type="file" name="blog_image" accept="image/*" required>

            <button type="submit" class="btn-create" style="width:100%; justify-content:center;">
                Publish Now
            </button>
        </form>
    </div>
</div>

<script>
    function openBlogModal() { document.getElementById('blogModal').style.display = 'block'; }
    function closeBlogModal() { document.getElementById('blogModal').style.display = 'none'; }
    
    // Close modal if clicked outside
    window.onclick = function(event) {
        let modal = document.getElementById('blogModal');
        if (event.target == modal) { modal.style.display = "none"; }
    }
</script>