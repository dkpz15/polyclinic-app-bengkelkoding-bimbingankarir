# polyclinic-app-bengkelkoding-bimbingankarir

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Database Structure](#database-structure)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)

---

## Introduction

The Polyclinic App is a web-based application designed to manage and streamline the operations of a polyclinic. It features role-based access for **Admin**, **Doctor**, and **Patient** to handle tasks efficiently.

---

## Features

### Admin

- Sign In and Sign Out.
- Manage Doctors: View, add, edit, and delete Doctors.
- Manage Patients: View, edit, and delete Patients.
- Manage Polies: View, add, edit, and delete Polies.
- Manage Medicines: View, add, edit, and delete Medicines.

### Doctor

- Sign in and Sign Out.
- Access a dedicated Doctor dashboard.

### Patient

- Register, Sign In, and Sign Out.
- Access a dedicated Patient dashboard.

---

## Database Structure

### Admin Table

| Field    | Type         | Constraints                 |
| -------- | ------------ | --------------------------- |
| id       | INT          | PRIMARY KEY, AUTO_INCREMENT |
| name     | VARCHAR(150) | NOT NULL                    |
| password | VARCHAR(255) | NOT NULL                    |

### Doctor Table

| Field               | Type         | Constraints                     |
| ------------------- | ------------ | ------------------------------- |
| id                  | INT          | PRIMARY KEY, AUTO_INCREMENT     |
| name                | VARCHAR(150) | NOT NULL                        |
| password            | VARCHAR(255) | NOT NULL                        |
| address             | VARCHAR(255) | NULLABLE                        |
| mobile_phone_number | INT UNSIGNED | NOT NULL                        |
| poly_id             | INT          | FOREIGN KEY REFERENCES poly(id) |

### Patient Table

| Field                 | Type         | Constraints                 |
| --------------------- | ------------ | --------------------------- |
| id                    | INT          | PRIMARY KEY, AUTO_INCREMENT |
| name                  | VARCHAR(150) | NOT NULL                    |
| password              | VARCHAR(255) | NOT NULL                    |
| address               | VARCHAR(255) | NULLABLE                    |
| identity_card_number  | INT UNSIGNED | NOT NULL                    |
| mobile_phone_number   | INT UNSIGNED | NOT NULL                    |
| medical_record_number | CHAR(10)     | NULLABLE                    |

### Poly Table

| Field       | Type        | Constraints                 |
| ----------- | ----------- | --------------------------- |
| id          | INT         | PRIMARY KEY, AUTO_INCREMENT |
| poly_name   | VARCHAR(25) | NOT NULL                    |
| description | TEXT        | NULLABLE                    |

### Medicine Table

| Field         | Type         | Constraints                 |
| ------------- | ------------ | --------------------------- |
| id            | INT          | PRIMARY KEY, AUTO_INCREMENT |
| medicine_name | VARCHAR(50)  | NOT NULL                    |
| packaging     | VARCHAR(35)  | NULLABLE                    |
| price         | INT UNSIGNED | DEFAULT 0                   |

---

## Installation

1. Clone the repository:
   git clone https://github.com/dkpz15/polyclinic-app-bengkelkoding-bimbingankarir.git

2. Navigate to the project directory:
   cd polyclinic-app-bengkelkoding-bimbingankarir

3. Set up the database:
   Import the polyclinic_app_bengkelkoding_bimbingankarir.sql file into your database system.

4. Run the application on a PHP server:
   localhost/polyclinic-app-bengkelkoding-bimbingankarir

---

## Usage

### Admin Sign In

- Navigate to /views/auth/loginAdminDoctor.php, choose Admin role, and then Sign In to access the Admin dashboard.
- Use the Admin dashboard to manage Doctors, Patients, Polies, and Medicines.

### Doctor Sign In

- Navigate to /views/auth/loginAdminDoctor.php, choose Doctor role, and then Sign In to access the Doctor dashboard.

### Patient Sign In/Register

- Navigate to /views/auth/registerPatient.php to Register as a new Patient.
- Navigate to /views/auth/loginPatient.php and Sign In to access the Patient dashboard.

---

## License

This project is licensed under the MIT License. See the LICENSE file for details.
