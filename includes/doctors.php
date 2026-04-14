<style>
    /* DOCTORS SECTION STYLING */
.doctors-section {
    padding: 80px 0;
    background: #f8fafc;
    overflow: hidden;
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
    letter-spacing: 1px;
}

.sec-header h2 {
    font-size: 36px;
    margin: 15px 0;
    color: #1e293b;
    font-weight: 800;
}

/* SLIDER WRAPPER */
.slider-wrapper {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
}

.docs-viewport {
    display: flex;
    gap: 25px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 20px 5px;
    scrollbar-width: none; /* Firefox */
}

.docs-viewport::-webkit-scrollbar {
    display: none; /* Chrome/Safari */
}

/* SLIDER NAVIGATION */
.slide-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 45px;
    height: 45px;
    background: #fff;
    border: none;
    border-radius: 50%;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    cursor: pointer;
    z-index: 10;
    transition: 0.3s;
    color: #4f46e5;
}

.slide-nav:hover {
    background: #4f46e5;
    color: #fff;
}

.slide-nav.prev { left: -10px; }
.slide-nav.next { right: -10px; }
.btn-book {
        display: inline-block;
        padding: 10px 24px;
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: #ffffff;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        border-radius: 10px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2), 
                    0 2px 4px -1px rgba(79, 70, 229, 0.1);
        text-align: center;
        cursor: pointer;
    }

    .btn-book:hover {
        background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        color: #ffffff;
    }

    .btn-book:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px -1px rgba(79, 70, 229, 0.2);
    }
</style>
<section id="doctors" class="doctors-section">
    <div class="container">
        <div class="sec-header">
            <span class="badge-premium">Featured Experts</span>
            <h2>Our Highlighted Doctors</h2>
            <p class="sec-subtext">Top-rated specialists available for instant consultation</p>
        </div>
        
        <div class="slider-wrapper">
            <button class="slide-nav prev" onclick="moveDocs(-1)"><i class="fas fa-chevron-left"></i></button>
            <div class="docs-viewport" id="docsSlider">
                
                <?php
                include 'db.php';
                $fetch_docs = mysqli_query($conn, "SELECT * FROM doctors ORDER BY id DESC");
                if(mysqli_num_rows($fetch_docs) > 0) {
                    while($doc = mysqli_fetch_assoc($fetch_docs)) {
                ?>
                <div class="doc-card-compact">
                    <div class="img-box">
                        <img src="./uploads/<?php echo $doc['image']; ?>" alt="Doctor">
                        <span class="rate-badge"><i class="fas fa-star"></i> <?php echo $doc['rating']; ?></span>
                    </div>
                    <div class="info-box">
                        <span class="status-dot"><?php echo $doc['availability']; ?></span>
                        <h4><a href="./profile/doctorprofile.php?id=<?php echo $doc['id']; ?>"><?php echo $doc['name']; ?></a></h4>
                        <p><?php echo $doc['specialty']; ?></p>
                        <div class="price-row">
                            <h5>$<?php echo $doc['price']; ?></h5>
                            <a href="./includes/book_appointment.php?id=<?php echo $doc['id']; ?>" class="btn-book">Book</a>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                } else {
                    echo "<p>No doctors registered yet.</p>";
                }
                ?>

            </div>
            <button class="slide-nav next" onclick="moveDocs(1)"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>
<script>
    function moveDocs(direction) {
    const slider = document.getElementById('docsSlider');
    const scrollAmount = 300; // Ek card ki width
    slider.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
}
</script>
