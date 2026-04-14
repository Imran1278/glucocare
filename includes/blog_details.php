<?php
session_start();
include '../db.php';

// 1. Get Blog ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$blog_id = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Fetch Blog Details
$query = "SELECT * FROM blogs WHERE id = '$blog_id'";
$result = mysqli_query($conn, $query);
$blog = mysqli_fetch_assoc($result);

if (!$blog) {
    echo "Blog not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?> | Health Insights</title>
    <link rel="icon" href="../pics/logo.png">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary: #10b981;
            --navy: #0f172a;
            --slate: #64748b;
            --bg: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--navy);
            line-height: 1.6;
            margin: 0;
        }

        .container { max-width: 900px; margin: 0 auto; padding: 40px 20px; }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--slate);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 30px;
            transition: 0.3s;
        }
        .btn-back:hover { color: var(--primary); }

        .article-header { margin-bottom: 40px; }
        .tag {
            background: rgba(16, 185, 129, 0.1);
            color: var(--primary);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }
        h1 { font-size: 42px; margin: 20px 0; line-height: 1.2; font-weight: 800; }
        
        .meta-info { display: flex; gap: 20px; color: var(--slate); font-size: 15px; }
        .meta-info i { color: var(--primary); }

        .featured-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
            border-radius: 30px;
            margin-bottom: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .content {
            font-size: 18px;
            color: #334155;
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            white-space: pre-line;
        }

        .comments-section { margin-top: 60px; }
        .comment-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 15px;
            border-left: 4px solid var(--primary);
        }
        
        .reply-form { background: #fff; padding: 30px; border-radius: 24px; margin-top: 40px; }
        textarea {
            width: 100%; padding: 15px; border: 1.5px solid #e2e8f0; border-radius: 12px;
            font-family: inherit; resize: vertical; margin-bottom: 15px;
        }

        .btn-submit {
            background: var(--navy); color: white; padding: 12px 30px; border: none;
            border-radius: 12px; font-weight: 600; cursor: pointer; transition: 0.3s;
        }
        .btn-submit:hover { background: var(--primary); }
    </style>
</head>
<body>

<div class="container">
    <a href="../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Home</a>

    <article>
        <div class="article-header">
            <span class="tag"><?php echo htmlspecialchars($blog['tags']); ?></span>
            <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
            <div class="meta-info">
                <span><i class="far fa-user"></i> By <strong><?php echo htmlspecialchars($blog['patient_name']); ?></strong></span>
                <span><i class="far fa-calendar-alt"></i> <?php echo date('M d, Y', strtotime($blog['created_at'])); ?></span>
            </div>
        </div>

        <img src="../uploads/<?php echo $blog['image']; ?>" alt="Blog Image" class="featured-image">

        <div class="content">
            <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
        </div>
    </article>

    <div class="comments-section">
        <h3>Leave a Reply</h3>
        
        <?php if(isset($_SESSION['patient_name'])): ?>
            <div class="reply-form">
                <form action="post_comment.php" method="POST">
                    <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
                    <textarea name="comment" rows="4" placeholder="Share your thoughts on this story..." required></textarea>
                    <button type="submit" class="btn-submit">Post Comment</button>
                </form>
            </div>
        <?php else: ?>
            <p style="background:#e2e8f0; padding:15px; border-radius:10px;">
                Please <a href="../user/login.php" style="color:var(--primary); font-weight:bold;">Login</a> to leave a comment.
            </p>
        <?php endif; ?>

        <div style="margin-top:40px;">
            <h4>Recent Comments</h4>
            <?php
            $comment_query = "SELECT * FROM comments WHERE blog_id = '$blog_id' ORDER BY id DESC";
            $comment_result = mysqli_query($conn, $comment_query);
            if($comment_result && mysqli_num_rows($comment_result) > 0) {
                while($c = mysqli_fetch_assoc($comment_result)) {
                    echo "<div class='comment-card'>
                            <strong>".htmlspecialchars($c['patient_name'])."</strong> <small style='color:gray;'>• ".date('d M', strtotime($c['created_at']))."</small>
                            <p style='margin-top:10px; margin-bottom:0;'>".htmlspecialchars($c['comment_text'])."</p>
                          </div>";
                }
            } else {
                echo "<p style='color:var(--slate);'>No comments yet. Be the first to reply!</p>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>