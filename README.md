# polyclinic-app-bengkelkoding-bimbingankarir

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Database Structure](#database-structure)
- [Installation](#installation)
<<<<<<< HEAD
- [Usage](#usage)
=======
>>>>>>> 4ef2f88957ab2781b8950626db7e143acc6c623f
- [License](#license)

---

## Introduction

The Polyclinic App is a web-based application designed to manage and streamline the operations of a polyclinic. It features role-based access for **Admin**, **Doctor**, and **Patient** to handle tasks efficiently.

---

## Features

### Admin

<<<<<<< HEAD
- Sign in and Sign Out.
- Manage Doctors: View, add, edit, and delete Doctors.
- Manage Patients: View, edit, and delete Patients.
- Manage Polies: View, add, edit, and delete Polies.
- Manage Medicines: View, add, edit, and delete Medicines.

### Doctor

- Sign in and Sign Out.
- Access a dedicated Doctor dashboard.
=======
- Sign In and Sign Out.
- Manage Doctors : View, Add, Edit, and Delete Doctors.
- Manage Patients : View, Edit, and Delete Patients.
- Manage Polies : View, Add, Edit, and Delete Polies.
- Manage Medicines : View, Add, Edit, and Delete Medicines.

### Doctor

- Sign In and Sign Out.
- Access Doctor Dashboard.
- Update Doctor Data.
- Check Schedule Input.
- Check Patients.
- Calculate Check Fee.
- Provide Medicine Notes.
- Display Patients History.
>>>>>>> 4ef2f88957ab2781b8950626db7e143acc6c623f

### Patient

- Register, Sign In, and Sign Out.
<<<<<<< HEAD
- Access a dedicated Patient dashboard.
=======
- Access Patient Dashboard.
- Register To Poly.
- Check Details.
>>>>>>> 4ef2f88957ab2781b8950626db7e143acc6c623f

---

## Database Structure

### Admin Table

| Field    | Type         | Constraints                 |
| -------- | ------------ | --------------------------- |
| id       | INT          | PRIMARY KEY, AUTO_INCREMENT |
| name     | VARCHAR(150) | NOT NULL                    |
| password | VARCHAR(255) | NOT NULL                    |

### Doctor Table

<<<<<<< HEAD
| Field               | Type         | Constraints                     |
| ------------------- | ------------ | ------------------------------- |
| id                  | INT          | PRIMARY KEY, AUTO_INCREMENT     |
| name                | VARCHAR(150) | NOT NULL                        |
| password            | VARCHAR(255) | NOT NULL                        |
| address             | VARCHAR(255) | NULLABLE                        |
| mobile_phone_number | INT UNSIGNED | NOT NULL                        |
| poly_id             | INT          | FOREIGN KEY REFERENCES poly(id) |
=======
| Field               | Type         | Constraints                              |
| ------------------- | ------------ | ---------------------------------------- |
| id                  | INT          | PRIMARY KEY, AUTO_INCREMENT              |
| name                | VARCHAR(150) | NOT NULL                                 |
| password            | VARCHAR(255) | NOT NULL                                 |
| address             | TEXT         | NOT NULL                                 |
| mobile_phone_number | INT UNSIGNED | NOT NULL                                 |
| poly_id             | INT          | FOREIGN KEY REFERENCES poly(id) NOT NULL |
>>>>>>> 4ef2f88957ab2781b8950626db7e143acc6c623f

### Patient Table

| Field                 | Type         | Constraints                 |
| --------------------- | ------------ | --------------------------- |
| id                    | INT          | PRIMARY KEY, AUTO_INCREMENT |
| name                  | VARCHAR(150) | NOT NULL                    |
| password              | VARCHAR(255) | NOT NULL                    |
<<<<<<< HEAD
| address               | VARCHAR(255) | NULLABLE                    |
| identity_card_number  | INT UNSIGNED | NOT NULL                    |
| mobile_phone_number   | INT UNSIGNED | NOT NULL                    |
| medical_record_number | CHAR(10)     | NULLABLE                    |
=======
| address               | TEXT         | NOT NULL                    |
| identity_card_number  | INT UNSIGNED | NOT NULL                    |
| mobile_phone_number   | INT UNSIGNED | NOT NULL                    |
| medical_record_number | CHAR(10)     | NOT NULL                    |
>>>>>>> 4ef2f88957ab2781b8950626db7e143acc6c623f

### Poly Table

| Field       | Type        | Constraints                 |
| ----------- | ----------- | --------------------------- |
| id          | INT         | PRIMARY KEY, AUTO_INCREMENT |
| poly_name   | VARCHAR(25) | NOT NULL                    |
<<<<<<< HEAD
| description | TEXT        | NULLABLE                    |
=======
| description | TEXT        | NOT NULL                    |
>>>>>>> 4ef2f88957ab2781b8950626db7e143acc6c623f

### Medicine Table

| Field         | Type         | Constraints                 |
| ------------- | ------------ | --------------------------- |
| id            | INT          | PRIMARY KEY, AUTO_INCREMENT |
| medicine_name | VARCHAR(50)  | NOT NULL                    |
<<<<<<< HEAD
| packaging     | VARCHAR(35)  | NULLABLE                    |
| price         | INT UNSIGNED | DEFAULT 0                   |

=======
| packaging     | VARCHAR(35)  | NOT NULL                    |
| price         | INT UNSIGNED | DEFAULT 0                   |

### Checkup Table

| Field         | Type         | Constraints                                   |
| ------------- | ------------ | --------------------------------------------- |
| id            | INT          | PRIMARY KEY, AUTO_INCREMENT                   |
| poly_list_id  | INT          | FOREIGN KEY REFERENCES poly_list(id) NOT NULL |
| check_date    | DATE         | NOT NULL                                      |
| medicine_name | VARCHAR(255) | NOT NULL                                      |
| note          | TEXT         | NOT NULL                                      |
| check_fee     | INT          | DEFAULT 0                                     |

### Check_Schedule Table

| Field      | Type        | Constraints                                |
| ---------- | ----------- | ------------------------------------------ |
| id         | INT         | PRIMARY KEY, AUTO_INCREMENT                |
| doctor_id  | INT         | FOREIGN KEY REFERENCES doctor(id) NOT NULL |
| day        | VARCHAR(10) | NOT NULL                                   |
| start_time | TIME        | NOT NULL                                   |
| end_time   | TIME        | NOT NULL                                   |

### Poly_List Table

| Field        | Type | Constraints                                        |
| ------------ | ---- | -------------------------------------------------- |
| id           | INT  | PRIMARY KEY, AUTO_INCREMENT                        |
| patient_id   | INT  | FOREIGN KEY REFERENCES patient(id) NOT NULL        |
| schedule_id  | INT  | FOREIGN KEY REFERENCES check_schedule(id) NOT NULL |
| complaint    | TEXT | NOT NULL                                           |
| queue_number | INT  | NOT NULL                                           |

### Check_Detail Table

| Field       | Type | Constraints                                  |
| ----------- | ---- | -------------------------------------------- |
| id          | INT  | PRIMARY KEY, AUTO_INCREMENT                  |
| check_id    | INT  | FOREIGN KEY REFERENCES checkup(id) NOT NULL  |
| medicine_id | INT  | FOREIGN KEY REFERENCES medicine(id) NOT NULL |

>>>>>>> 4ef2f88957ab2781b8950626db7e143acc6c623f
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

<<<<<<< HEAD
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

=======
>>>>>>> 4ef2f88957ab2781b8950626db7e143acc6c623f
## License

This project is licensed under the MIT License. See the LICENSE file for details.
