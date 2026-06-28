# Hand2Hand 🤝

A Tunisian web platform connecting donors, associations, and job seekers — built with PHP and MySQL, hosted on InfinityFree.

🌐 **Live demo:** [hand2hand.rf.gd](http://hand2hand.rf.gd)

---

## What it does

Hand2Hand lets users donate items, associations browse and reserve donations, and anyone post or apply to job offers. Three separate dashboards handle each role with access control enforced server-side.

**Core features:**
- Donor registration and item donation with photo upload
- Association dashboard to browse, filter, and reserve donations
- Job offer posting and management
- Admin panel to review and approve donations
- Role-based authentication (user / association / admin)
- Modern UI with page transition animations and scroll effects

---

## Tech stack

| Layer | Technology |
|---|---|
| Frontend | HTML, CSS, JavaScript |
| Backend | PHP |
| Database | MySQL |
| Auth | PHP Sessions |
| Hosting | InfinityFree |
| File storage | Local (`/uploads`) |

---

## Project structure

```
hand2hand/
├── index.html                  # Landing page
├── login.html                  # Login (user / association / admin)
├── SignUp.html                 # Registration
├── dashboard.php               # User dashboard
├── association_dashboard.php   # Association dashboard
├── admin_panel.php             # Admin panel
├── donate.php                  # Donation form
├── browse_donations.php        # Browse available donations
├── offretravail.php            # Job offers page
├── header.php                  # Shared header component
├── design-system.css           # Shared design system
├── h2h-transition.js           # Page transitions & animations
├── db_config.php               # Database connection (not committed)
├── process_login.php           # Login handler
├── process_signup.php          # Registration handler
├── process_donation.php        # Donation submission handler
├── process_job_offer.php       # Job offer handler
├── edit_donation.php           # Edit donation form
├── process_edit.php            # Edit donation handler
├── delete_donation.php         # Delete donation
├── reserve_item.php            # Reserve a donation item
├── update_status.php           # Admin: approve or refuse donations
├── create_admin.php            # One-time admin account creation
├── logout.php                  # Session destroy + redirect
└── uploads/                    # User-uploaded donation images
```

---

## Database setup

Create a MySQL database and import `hand2hand.sql`, or run the following:

```sql
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    city VARCHAR(100),
    address TEXT,
    role ENUM('user','association','admin') DEFAULT 'user',
    assoc_name VARCHAR(255),
    reg_number VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    item_name VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    quantity VARCHAR(100),
    item_condition VARCHAR(100),
    item_image VARCHAR(255),
    contact_phone VARCHAR(20),
    status ENUM('pending','approved','reserved','completed','refused') DEFAULT 'pending',
    assoc_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS job_offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_title VARCHAR(255) NOT NULL,
    company VARCHAR(255),
    location VARCHAR(255),
    description TEXT,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

---

## Configuration

Create a `db_config.php` file at the root (not committed for security):

```php
<?php
$host = 'your_mysql_host';
$db   = 'your_database_name';
$user = 'your_username';
$pass = 'your_password';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
```

---

## Creating an admin account

After setting up the database, visit:

```
http://yourdomain/create_admin.php
```

Set your preferred credentials inside the file first. Delete it after use.

---

## Team

Built as part of a web development project at **ISAMM, Université de la Manouba** (2024–2025).

| Name | Role |
|---|---|
| Jihed | Lead Developer |
| Mahoud Gharbi | Developer |
| Tasnim Baccouri | Developer |
| Yomna Mekni | Developer |
| Yassmine Ben Mefteh | Developer |

Supervised by **Mme. Ghofrane Kraiem**.

---

## License

This project was made for academic purposes.

---

## Running Locally with XAMPP

**Requirements:** XAMPP installed on your machine (includes Apache + MySQL).

**Steps:**

1. **Clone the repository** into your XAMPP web root:
   ```
   C:\xampp\htdocs\hand2hand\
   ```
   Or download the ZIP and extract it there.

2. **Start XAMPP** — open XAMPP Control Panel and start **Apache** and **MySQL**.

3. **Create the database** — open your browser and go to:
   ```
   http://localhost/phpmyadmin
   ```
   - Click **New** on the left
   - Name it `hand2hand` and click **Create**
   - Click the **Import** tab → choose `hand2hand.sql` → click **Go**

4. **Configure the connection** — create `db_config.php` at the project root:
   ```php
   <?php
   $host = 'localhost';
   $db   = 'hand2hand';
   $user = 'root';
   $pass = ''; // empty by default in XAMPP

   $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   ?>
   ```

5. **Create the uploads folder** — make sure this folder exists and is writable:
   ```
   C:\xampp\htdocs\hand2hand\uploads\
   ```

6. **Open the site** in your browser:
   ```
   http://localhost/hand2hand/
   ```

7. **Create your admin account** — visit:
   ```
   http://localhost/hand2hand/create_admin.php
   ```
   Then delete or restrict that file.
