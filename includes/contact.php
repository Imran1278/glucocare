<?php
include(__DIR__ . '/../db.php');   // Database connection file

if (isset($_POST['submit_contact'])) {
    // Data ko safe banana (SQL Injection se bachne ke liye)
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Query chalana
    $sql = "INSERT INTO contact_messages (fname, lname, email, phone, message) 
            VALUES ('$fname', '$lname', '$email', '$phone', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Thank you! Your message has been sent successfully.');
                window.location.href='../index.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<section id="contact" class="contact-clean">
<!-- Heading -->
<div class="contact-head">
  <h2>Contact Us</h2>
  <p>
    Great doctor if you need your family member to get effective immediate
    assistance, emergency treatment, or simple consultation.
  </p>
</div>

<div class="contact-cards">
    <?php
    include 'db.php';
    $fetch_info = mysqli_query($conn, "SELECT * FROM site_info");
    
    // Data ko groups mein divide karne ke liye arrays
    $phones = [];
    $emails_links = [];
    $addresses = [];

    while($row = mysqli_fetch_assoc($fetch_info)) {
        $type = $row['info_type'];
        // Check karte hain ke entry kis category ki hai
        if (strpos($type, 'Phone') !== false) {
            $phones[] = $row;
        } elseif (strpos($type, 'Email') !== false || strpos($type, 'Link') !== false || strpos($type, 'Website') !== false) {
            $emails_links[] = $row;
        } elseif (strpos($type, 'Location') !== false) {
            $addresses[] = $row;
        }
    }
    ?>

    <?php if(!empty($phones)): ?>
    <div class="c-card">
        <div class="c-icon-circle"><i class="fas fa-phone-alt"></i></div>
        <h4>Contact Numbers</h4>
        <div class="c-content-list">
            <?php foreach($phones as $p): ?>
                <p>
                    <i class="<?= $p['icon'] ?>"></i> 
                    <strong><?= str_replace(' Phone', '', $p['info_type']) ?>:</strong> 
                    <a href="tel:<?= $p['content'] ?>"><?= $p['content'] ?></a>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if(!empty($emails_links)): ?>
    <div class="c-card">
        <div class="c-icon-circle"><i class="fas fa-envelope-open-text"></i></div>
        <h4>Email & Links</h4>
        <div class="c-content-list">
            <?php foreach($emails_links as $e): ?>
                <p>
                    <i class="<?= $e['icon'] ?>"></i> 
                    <strong><?= str_replace([' Email Address', ' Link'], '', $e['info_type']) ?>:</strong> 
                    <a href="<?= (strpos($e['info_type'], 'Email') !== false) ? 'mailto:'.$e['content'] : $e['content'] ?>" target="_blank">
                        <?= $e['content'] ?>
                    </a>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if(!empty($addresses)): ?>
    <div class="c-card">
        <div class="c-icon-circle"><i class="fas fa-map-marked-alt"></i></div>
        <h4>Our Locations</h4>
        <div class="c-content-list">
            <?php foreach($addresses as $a): ?>
                <p>
                    <i class="<?= $a['icon'] ?>"></i> 
                    <strong><?= str_replace(' Location', '', $a['info_type']) ?>:</strong> 
                    <span><?= $a['content'] ?></span>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- Bottom Area -->
<div class="contact-bottom">

  <!-- Map -->
  <div class="map-box">
    <iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3405.029285038165!2d74.19520447545122!3d31.41331777426365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3918ff9441113545%3A0xe7261a8a29a007b8!2sEiffel%20Tower%20Bahria%20Town%20Lahore!5e0!3m2!1sen!2s!4v1700000000000!5m2!1sen!2s"
      loading="lazy"></iframe>
  </div>

  <!-- Form -->
  <div class="form-box">
    <span class="small-title">GET IN TOUCH</span>
    <h3>Contact Details</h3>

    <form action="includes\contact.php" method="POST">
  <div class="row">
    <input type="text" name="fname" placeholder="Enter First Name" required>
    <input type="text" name="lname" placeholder="Enter Last Name" required>
  </div>

  <div class="row">
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="text" name="phone" placeholder="Phone Number">
  </div>

  <textarea name="message" placeholder="Enter Message" required></textarea>

  <button type="submit" name="submit_contact">SUBMIT</button>
</form>
  </div>

</div>
</section>

<style>
/* Mazeed behtar styling aik hi box mein multiple lines ke liye */
.contact-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    padding: 20px;
}

.c-card {
    background: #ffffff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.05);
    border: 1px solid #f0f0f0;
    transition: 0.3s ease;
    text-align: center;
}

.c-card:hover {
    transform: translateY(-5px);
    border-color: #4f46e5;
}

.c-icon-circle {
    width: 70px;
    height: 70px;
    background: #eef2ff;
    color: #4f46e5;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 0 auto 20px;
    font-size: 28px;
}

.c-card h4 {
    color: #1e293b;
    font-size: 20px;
    margin-bottom: 20px;
    font-weight: 700;
    border-bottom: 2px solid #f8fafc;
    padding-bottom: 10px;
}

.c-content-list {
    text-align: left; /* List andar se left align achi lagti hai */
}

.c-content-list p {
    margin-bottom: 12px;
    font-size: 14px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 10px;
}

.c-content-list i {
    color: #4f46e5;
    width: 20px;
}

.c-content-list a {
    text-decoration: none;
    color: #1e293b;
    font-weight: 600;
    transition: 0.2s;
}

.c-content-list a:hover {
    color: #4f46e5;
}
</style>