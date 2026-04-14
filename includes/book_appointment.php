<?php
session_start();
include '../db.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$doc_id = mysqli_real_escape_string($conn, $_GET['id']);
$get_doc = mysqli_query($conn, "SELECT * FROM doctors WHERE id = '$doc_id'");
$d_db = mysqli_fetch_assoc($get_doc);

if(!$d_db) { header("Location: ../index.php"); exit(); }

$json_data = file_get_contents("../doctors.json");
$doctors = json_decode($json_data, true);
$d_json = null;
foreach ($doctors as $doc) {
    if ($doc['id'] == $doc_id) { $d_json = $doc; break; }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment | <?php echo $d_db['name']; ?></title>
    <link rel="icon" href="../pics/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root { --primary: #4f46e5; --bg: #f8fafc; --white: #ffffff; --text: #0f172a; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); margin: 0; }
        .booking-container { max-width: 1000px; margin: 40px auto; background: var(--white); border-radius: 30px; display: flex; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.05); min-height: 620px; }
        
        .booking-side { width: 35%; background: #0f172a; color: white; padding: 40px; display: flex; flex-direction: column; align-items: center; text-align: center; }
        .doc-preview img { width: 130px; height: 130px; border-radius: 30px; object-fit: cover; border: 4px solid var(--primary); margin-bottom: 20px; }
        
        .booking-main { flex: 1; padding: 50px; }
        .form-step { display: none; }
        .form-step.active { display: block; animation: slideUp 0.4s ease; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .input-field { margin-bottom: 25px; }
        .input-field label { display: block; font-weight: 700; margin-bottom: 10px; font-size: 14px; color: #64748b; }
        .input-field input, .input-field select, .input-field textarea { 
            width: 100%; padding: 15px; border: 2px solid #f1f5f9; border-radius: 15px; font-family: inherit; font-size: 15px; background: #f8fafc; transition: 0.3s;
        }
        .input-field input:focus { border-color: var(--primary); outline: none; background: #fff; }

        .btn-row { display: flex; gap: 15px; margin-top: 35px; }
        .btn { padding: 18px 30px; border-radius: 15px; border: none; font-weight: 700; cursor: pointer; flex: 1; transition: 0.3s; font-size: 15px; }
        .btn-next { background: var(--primary); color: white; }
        .btn-back { background: #f1f5f9; color: #64748b; }
        
        /* Blur Effect */
        .btn-disabled { opacity: 0.3; filter: blur(2px); cursor: not-allowed; pointer-events: none; }
        
        .fee-tag { background: rgba(79, 70, 229, 0.1); color: var(--primary); padding: 12px 25px; border-radius: 12px; font-weight: 800; margin-top: 20px; }
        .loc-badge { display: block; margin-top: 10px; color: #10b981; font-weight: 700; font-size: 13px; }
    </style>
</head>
<body>

<div class="booking-container">
    <div class="booking-side">
        <div class="doc-preview">
            <img src="../uploads/<?php echo $d_db['image']; ?>">
            <h3><?php echo $d_db['name']; ?></h3>
            <p style="opacity: 0.7; font-size: 14px;"><?php echo $d_db['specialty']; ?></p>
            <div class="fee-tag">Consultation Fee: $<?php echo $d_db['price']; ?></div>
        </div>
    </div>

    <div class="booking-main">
        <form action="process_booking.php" method="POST">
            <input type="hidden" name="doctor_id" value="<?php echo $d_db['id']; ?>">
            <input type="hidden" name="app_location" id="hidden_loc">

            <div class="form-step active" id="step1">
                <h2 style="margin-bottom: 30px;">Patient Details</h2>
                <div class="input-field">
                    <label>Full Name</label>
                    <input type="text" value="<?php echo $_SESSION['patient_name']; ?>" readonly>
                </div>
                <div class="input-field">
                    <label>Phone Number</label>
                    <input type="tel" name="patient_phone" placeholder="e.g. 03001234567" required>
                </div>
                <div class="btn-row">
                    <button type="button" class="btn btn-next" onclick="move(2)">Continue to Schedule <i class="fas fa-chevron-right" style="margin-left:10px"></i></button>
                </div>
            </div>

            <div class="form-step" id="step2">
                <h2 style="margin-bottom: 30px;">Select Appointment</h2>
                <div class="input-field">
                    <label>Preferred Date</label>
                    <input type="date" name="app_date" id="app_date" min="<?php echo date('Y-m-d'); ?>" required onchange="fetchSlots()">
                </div>
                <div class="input-field">
                    <label>Available Time Slots & Locations</label>
                    <select name="app_time" id="app_time" required onchange="updateLoc()">
                        <option value="">-- Choose Date First --</option>
                    </select>
                    <span id="loc_display" class="loc-badge"></span>
                </div>
                <div class="btn-row">
                    <button type="button" class="btn btn-back" onclick="move(1)">Back</button>
                    <button type="button" id="next_btn" class="btn btn-next btn-disabled" onclick="move(3)">Review Details</button>
                </div>
            </div>

            <div class="form-step" id="step3">
                <h2 style="margin-bottom: 30px;">Final Review</h2>
                <div class="input-field">
                    <label>Describe your Problem (Optional)</label>
                    <textarea name="app_notes" rows="5" placeholder="Write any specific symptoms or medical history..."></textarea>
                </div>
                <div class="btn-row">
                    <button type="button" class="btn btn-back" onclick="move(2)">Back</button>
                    <button type="submit" name="book_now" id="confirm_btn" class="btn btn-next btn-disabled" style="background: #10b981;">Confirm & Book Appointment</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const schedule = <?php echo json_encode($d_json['schedule']); ?>;

    function move(s) {
        document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
        document.getElementById('step' + s).classList.add('active');
    }

    function fetchSlots() {
        const dateInput = document.getElementById('app_date').value;
        const day = new Date(dateInput).toLocaleDateString('en-US', { weekday: 'long' });
        const timeSelect = document.getElementById('app_time');
        const nextBtn = document.getElementById('next_btn');
        const confirmBtn = document.getElementById('confirm_btn');
        const locDisplay = document.getElementById('loc_display');

        timeSelect.innerHTML = '<option value="">-- Select a Slot --</option>';
        locDisplay.innerText = "";
        
        const dayData = schedule[day];

        // Check if doctor is available and not "Clinic Closed"
        if (dayData && dayData.time !== "No Time Today" && dayData.location !== "Clinic Closed") {
            nextBtn.classList.remove('btn-disabled');
            confirmBtn.classList.remove('btn-disabled');

            // Split times and locations by comma (since your JSON uses "time1, time2" format)
            const times = dayData.time.split(',').map(s => s.trim());
            const locations = dayData.location.split(',').map(s => s.trim());

            times.forEach((t, index) => {
                let loc = locations[index] || locations[0]; // Fallback to first location if not enough provided
                let opt = document.createElement('option');
                opt.value = t;
                opt.text = t + " @ " + loc;
                opt.dataset.loc = loc;
                timeSelect.appendChild(opt);
            });
        } else {
            // Clinic is Closed on this day
            nextBtn.classList.add('btn-disabled');
            confirmBtn.classList.add('btn-disabled');
            let opt = document.createElement('option');
            opt.text = "Sorry, Clinic is Closed on " + day;
            opt.value = "";
            timeSelect.appendChild(opt);
        }
    }

    function updateLoc() {
        const select = document.getElementById('app_time');
        const selectedOption = select.options[select.selectedIndex];
        const loc = selectedOption.dataset.loc;
        
        if (loc) {
            document.getElementById('hidden_loc').value = loc;
            document.getElementById('loc_display').innerText = "📍 Location: " + loc;
        } else {
            document.getElementById('hidden_loc').value = "";
            document.getElementById('loc_display').innerText = "";
        }
    }
</script>
</body>
</html>