# GlucoCare
GlucoCare - Professional Healthcare & Monitoring System:

GlucoCare is a modern, full-stack web application designed for healthcare management and glucose monitoring. It features a streamlined administrative portal and a responsive user interface built with PHP and MySQL.

# 🚀 Key Features:

Secure Admin Gateway: A specialized login system that supports one-time administrative setup and secure session management.
Dynamic Content Management: Manage site information, contact details, and locations via a database-driven backend.
Professional UI/UX: Built with Plus Jakarta Sans typography and a clean, modern CSS layout.
Responsive Design: Fully optimized for both desktop and mobile devices.
Database Integration: Robust MySQL structure for storing site metadata and administrative credentials.

# 🛠️ Tech Stack:

Frontend: HTML5, CSS3 (Modern Flexbox/Grid), FontAwesome 6.4.
Backend: PHP (Procedural/OOP).
Database: MySQL (MariaDB).
Fonts: Google Fonts Integration.

# 📂 Folder Structure:

/glucocare
│
├── /admin             # Administrative portal files
│   ├── admin_login.php # Secure entry point
│   └── admin_panel.php # Dashboard
├── /pics              # Images and assets
├── /database          # SQL export files
├── db.php             # Database connection logic
└── index.php          # Main landing page

# ⚙️ Installation Guide:

1: Clone the Repository:-
git clone https://github.com/Imran1278/glucocare

2: Setup Database:-
Open phpMyAdmin.
Create a new database named glucocare_db.
Import the site_info.sql file located in the /database folder.

3: Configure Connection:-
Open db.php.
Update your database credentials (host, username, password).

4: Launch:-
Move the folder to your htdocs (XAMPP) or www (WAMP) directory.
Access the site via http://localhost/glucocare.

# 🛡️ Administrative Access:

The first time you access the Admin Gateway, you can set your credentials. Once the first administrator is registered in the database, the system locks to prevent unauthorized registrations.

# 📄 License:

Distributed under the MIT License. See LICENSE for more information.

# How to use this:

Create a new file in your project root folder named README.md.
Paste the content above into that file.
Save, commit, and push it to GitHub:
git add README.md
git commit -m "Added professional README documentation"
git push origin main
