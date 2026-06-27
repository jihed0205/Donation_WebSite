# Hand2Hand 🤝

A Tunisian web platform connecting donors, associations, and job seekers — built with PHP, MySQL, and vanilla JavaScript.

---

## What it does

Hand2Hand lets users donate items, associations browse and reserve donations, and anyone post or apply to job offers. Three separate dashboards handle each role (user, association, admin) with access control enforced server-side.

**Core features:**
- Donor registration and item donation with photo upload
- Association dashboard to browse, filter, and reserve donations
- Job offer posting and management
- Admin panel to manage users and monitor activity
- Role-based authentication (user / association / admin)

---

## Tech stack

| Layer | Technology |
|---|---|
| Frontend | HTML, CSS, JavaScript |
| Backend | PHP |
| Database | MySQL |
| Auth | PHP Sessions |
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
├── browse_donations.php        # Association: browse available donations
├── offretravail.php            # Job offers page
├── header.php                  # Shared header component
├── db_config.php               # Database connection
├── process_login.php           # Login handler
├── process_signup.php          # Registration handler
├── process_donation.php        # Donation submission handler
├── process_job_offer.php       # Job offer submission handler
├── process_edit.php            # Edit donation handler
├── edit_donation.php           # Edit donation form
├── delete_donation.php         # Delete donation
├── reserve_item.php            # Reserve a donation item
├── update_status.php           # Admin: update donation status
├── create_admin.php            # One-time admin account creation
├── logout.php                  # Session destroy + redirect
├── style.css                   # Global styles
└── uploads/                    # User-uploaded donation images
```

---

## Database setup

Create a MySQL database named `hand2hand` and run the following:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    city VARCHAR(100),
    address TEXT,
    role ENUM('user', 'association', 'admin') DEFAULT 'user',
    assoc_name VARCHAR(255),
    reg_number VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255),
    description TEXT,
    category VARCHAR(100),
    image_path VARCHAR(255),
    status ENUM('available', 'reserved', 'delivered') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE job_offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    category VARCHAR(100),
    contact_email VARCHAR(255),
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

---

## Configuration

Open `db_config.php` and update if needed:

```php
$host = 'localhost';
$db   = 'hand2hand';
$user = 'root';   // your MySQL username
$pass = '';       // your MySQL password
```

---

## Creating an admin account

After setting up the database, visit:

```
http://localhost/hand2hand/create_admin.php
```

This creates the default admin account. Open the file first to set your preferred email and password. Delete or restrict this file after use.

---

## Local development

1. Clone the repository into your web server's root directory
2. Set up the database as described above
3. Start your web server and MySQL service
4. Open `http://localhost/hand2hand/` in your browser
