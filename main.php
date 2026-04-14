<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlucoCare</title>
    <link rel="icon" href="./pics/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --bg: #f8fafc; /* Very light slate */
            --primary: #0f172a; /* Deep Navy */
            --accent: #10b981; /* Professional Emerald/Mint */
            --text-main: #0f172a;
            --text-dim: #64748b;
            --border: rgba(16, 185, 129, 0.2);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; cursor: none; }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* --- Ambient Mint Background --- */
        .mesh-gradient {
            position: fixed;
            inset: 0;
            z-index: 1;
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.07) 0, transparent 40%), 
                radial-gradient(at 100% 100%, rgba(15, 23, 42, 0.05) 0, transparent 40%);
        }

        /* --- Custom Cursor (Mint Theme) --- */
        #cursor {
            position: fixed;
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            pointer-events: none;
            z-index: 10000;
        }

        #cursor-follower {
            position: fixed;
            width: 40px; height: 40px;
            border: 1px solid var(--accent);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            opacity: 0.4;
            transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .wrapper {
            position: relative;
            z-index: 10;
            text-align: center;
            width: 100%;
            max-width: 1200px;
        }

        .header-meta {
            font-size: 11px;
            letter-spacing: 0.5em;
            text-transform: uppercase;
            color: var(--accent);
            font-weight: 700;
            margin-bottom: 30px;
            animation: fadeIn 2s ease;
        }

        h1 {
            font-size: clamp(3rem, 12vw, 9rem);
            font-weight: 800;
            line-height: 0.9;
            letter-spacing: -0.04em;
            margin-bottom: 50px;
            color: var(--primary);
            transform: translateY(50px);
            opacity: 0;
            animation: revealUp 1.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        h1 span {
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* --- Elegant Button --- */
        .btn-container {
            opacity: 0;
            animation: fadeIn 1s ease forwards 1s;
        }

        .enter-btn {
            position: relative;
            padding: 24px 60px;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.2em;
            border-radius: 4px; /* Sharp professional edges */
            display: inline-block;
            transition: all 0.4s ease;
            box-shadow: 0 15px 35px -10px rgba(15, 23, 42, 0.3);
        }

        .enter-btn:hover {
            transform: translateY(-5px);
            background: var(--accent);
            box-shadow: 0 20px 40px -10px rgba(16, 185, 129, 0.4);
            letter-spacing: 0.3em;
        }

        /* --- Footer Info --- */
        .footer-info {
            margin-top: 80px;
            display: flex;
            justify-content: center;
            gap: 50px;
            color: var(--text-dim);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.15em;
        }

        .footer-info span { display: flex; align-items: center; gap: 8px; }
        .footer-info i { color: var(--accent); }

        @keyframes revealUp {
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>

    <div id="cursor"></div>
    <div id="cursor-follower"></div>
    <div class="mesh-gradient"></div>

    <div class="wrapper">
        <div class="header-meta">GlucoCare</div>
        
        <h1>BETTER<br><span>HEALTH</span>CARE</h1>

        <div class="btn-container">
            <a href="index.php" class="enter-btn" id="launch">
                INITIATE ACCESS <i class="fas fa-arrow-right" style="margin-left: 15px;"></i>
            </a>
            
            <div class="footer-info">
                <span><i class="fas fa-microchip"></i> AI DRIVEN</span>
                <span><i class="fas fa-shield-halved"></i> ISO CERTIFIED</span>
                <span><i class="fas fa-network-wired"></i> GLOBAL SYNC</span>
            </div>
        </div>
    </div>

    <script>
        const cursor = document.getElementById('cursor');
        const follower = document.getElementById('cursor-follower');

        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
            follower.style.left = (e.clientX - 20) + 'px';
            follower.style.top = (e.clientY - 20) + 'px';
        });

        document.getElementById('launch').addEventListener('click', function(e) {
            e.preventDefault();
            const destination = this.href;
            document.querySelector('.wrapper').style.transition = '0.8s ease';
            document.querySelector('.wrapper').style.opacity = '0';
            setTimeout(() => { window.location.href = destination; }, 700);
        });
    </script>
</body>
</html>