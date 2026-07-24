A PHP and MySQL web application developed as part of the **Bincom ICT PHP Developer Assessment**. The system allows users to view election results by Local Government Area (LGA) and enter new polling unit results.

---

## 📖 Project Overview

This application demonstrates the use of PHP, MySQL, HTML, Bootstrap, and JavaScript to build a simple election result management system.

The project satisfies the three major requirements of the Bincom PHP Test:

1. Display election results for a polling unit.
2. Display the summed total results of all polling units under a selected Local Government Area (LGA).
3. Enter and save election results for a polling unit.

---

## 🚀 Features

- Dashboard homepage
- View election results by Local Government Area
- Automatic calculation of total votes from polling unit results
- Add new polling unit election results
- Dynamic LGA, Ward, and Polling Unit selection
- Bootstrap 5 responsive interface
- Secure database operations using prepared statements
- MySQL transaction support when saving results

---

## 🛠️ Technologies Used

- PHP 8+
- MySQL
- HTML5
- CSS3
- Bootstrap 5
- JavaScript (Fetch API)
- XAMPP / MAMP

---

## 📂 Project Structure

```
bincom/
│
├── index.php
├── lga-results.php
├── add-result.php
├── get_locations.php
├── style.css
├── database.php
│
└── README.md
```

---

## 🗄️ Database

Database Name

```
bincomphptest
```

The database contains the following tables:

- states
- lga
- ward
- polling_unit
- party
- announced_pu_results
- announced_lga_results
- announced_ward_results
- announced_state_results
- agentname

---

## ⚙️ Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/bincom-election-management.git
```

### 2. Move the project into your web server

For XAMPP:

```
htdocs/bincom
```

### 3. Import the database

- Open phpMyAdmin
- Create a database named:

```
bincomphptest
```

- Import the provided SQL file.
