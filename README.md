# 🇸🇦 Discover Saudi Arabia
### Project Setup & Collaboration Guide

---

## 📁 1. Project Folder Structure

```
discover-saudi/
│
├── public/
│   ├── index.php                  ← Person 1
│   ├── gallery.php                ← Person 2
│   ├── details.php                ← Person 3
│   │
│   ├── css/
│   │   ├── shared.css             ← Person 1 (used by ALL pages)
│   │   ├── home.css               ← Person 1
│   │   ├── gallery.css            ← Person 2
│   │   └── details.css            ← Person 3
│   │
│   ├── js/
│   │   ├── home.js                ← Person 1
│   │   ├── filter.js              ← Person 2
│   │   └── confirm.js             ← Person 3
│   │
│   └── images/
│       ├── riyadh/
│       ├── makkah/
│       ├── alula/
│       ├── alkhobar/
│       ├── abha/
│       └── tabuk/
│
├── admin/
│   ├── login.php                  ← Person 1
│   ├── dashboard.php              ← Person 3
│   ├── add_content.php            ← Person 2
│   ├── update_content.php         ← Person 3
│   ├── delete.php                 ← Person 3
│   └── css/
│       └── admin.css              ← Person 1
│
├── includes/
│   └── db_config.php              ← Person 1 creates, everyone uses
│
├── database/
│   └── saudi_db.sql               ← Person 1 creates, everyone imports
│
└── README.md
```

### 👥 Ownership Summary

| Person | Files Owned |
|--------|-------------|
| **Person 1** | `index.php`, `login.php`, `shared.css`, `home.css`, `home.js`, `admin.css`, `db_config.php`, `saudi_db.sql` |
| **Person 2** | `gallery.php`, `add_content.php`, `gallery.css`, `filter.js` |
| **Person 3** | `details.php`, `dashboard.php`, `update_content.php`, `delete.php`, `details.css`, `confirm.js` |

> ⚠️ **Never edit someone else's file without telling them in the group chat first.**  
> ⚠️ Only **Person 1** edits `shared.css` and `db_config.php`.

---

## 🚀 2. How to Clone & Open the Project

### Step 1 — Install Required Tools

Make sure these are installed on your Mac before starting:

- [Github decktop](https://desktop.github.com/download/) — for version control
- [VS Code](https://code.visualstudio.com) — code editor
- [MAMP](https://www.mamp.info) — local server to run PHP and MySQL

---

### Step 2 — Clone the Repository

# 1. Clone the project from GitHub to your device

# 3. Open the project folder in the VS editor

### Step 4 — Daily Git Workflow

Every time you sit down to work, follow this order:

**1. Pull latest changes first from github desktop app (do this EVERY day before starting):**

**2. Do your work in VS Code**

**3. Push and commit your changes when done**



---

## 🗄️ 3. How to Set Up the Database

### Step 1 — Start MAMP

1. Open the **MAMP** application
2. add a COPY of the project forlder inside /MAMP/htdocs/
3. Click **Start Servers**
4. Wait until both Apache and MySQL lights turn **green**

---

### Step 2 — Open phpMyAdmin

Open your browser and go to:

```
http://localhost:8888/phpMyAdmin
```

Login with these credentials if asked:

| Setting | Value |
|---------|-------|
| Username | `root` |
| Password | `root` |
| Host | `localhost` |
| MySQL Port | `8889` |

---

### Step 3 — Create the Database

1. Click **New** in the left sidebar
2. Type `saudi_db` in the database name field
3. Select **`utf8mb4_unicode_ci`** from the collation dropdown
4. Click **Create**

> 📌 The collation `utf8mb4_unicode_ci` is required for Arabic text to display correctly.

---

### Step 4 — Import the SQL File

1. Click on `saudi_db` in the left sidebar to select it
2. Click the **Import** tab at the top
3. Click **Choose File**
4. Navigate to your project folder and select:

```
/Applications/MAMP/htdocs/discover-saudi/database/saudi_db.sql
```

5. Click **Go** at the bottom of the page
6. Wait for the success message ✅

---

### Step 5 — Verify Tables Were Created

In the left sidebar under `saudi_db` you should now see **4 tables**:

| Table | Purpose |
|-------|---------|
| `admin` | Stores admin login credentials |
| `regions` | Stores Saudi regions (e.g. منطقة الرياض) |
| `places` | Stores places within each region |
| `gallery_images` | Stores gallery photos for each place |

> ✅ If you see all 4 tables, your database is ready!  
> Open the project at: `http://localhost:8888/discover-saudi/public/index.php`

---

## 🔄 4. If the Database Changes

If Person 1 updates the database and pushes a new `saudi_db.sql` to GitHub, all teammates must update their local database:

1. Pull the latest changes: `git pull`
2. Open **phpMyAdmin**
3. Click on `saudi_db` in the left sidebar
4. Click the **Operations** tab
5. Scroll down and click **Drop the database** (deletes the old one)
6. Create a new database named `saudi_db` with `utf8mb4_unicode_ci`
7. Import the new `saudi_db.sql` from the `database/` folder

> 📢 **Person 1** must announce in the group chat whenever the database file is updated so everyone knows to re-import it.

---

## 📋 5. Quick Reference

### Useful URLs (while MAMP is running)

| Page | URL |
|------|-----|
| Home Page | `http://localhost:8888/discover-saudi/public/index.php` |
| Admin Login | `http://localhost:8888/discover-saudi/admin/login.php` |
| phpMyAdmin | `http://localhost:8888/phpMyAdmin` |

---

### 🔑 Admin Login Credentials

| Field | Value |
|-------|-------|
| Username | `admin` |
| Password | `admin1234` |

---

### ⚙️ db_config.php Settings for MAMP

```php
DB_HOST = localhost:8889
DB_USER = root
DB_PASS = root
DB_NAME = saudi_db
```

---


---

*© Discover Saudi Arabia — King Saud University*
