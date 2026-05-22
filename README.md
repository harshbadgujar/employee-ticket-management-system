# 🎫 Employee Ticket System

A robust, full-stack ticketing and issue-resolution platform designed to streamline internal company support requests. This system allows employees to raise technical or administrative tickets, while enabling support teams or administrators to manage, track, and resolve them efficiently.

---

### 🚀 Features

#### 👥 Employee Portal
- **Ticket Creation:** Raise new tickets with titles, detailed descriptions, priority levels, and categories.
- **Track Status:** Real-time visibility into the current status of submitted tickets (e.g., Open, In Progress, Resolved).
- **Profile Management:** Custom attributes including phone, department, and profile image tracking.

#### 🛠️ Admin / Support Dashboard
- **Ticket Management:** View all incoming employee tickets in a centralized dashboard.
- **Assign & Update:** Assign tickets to specific support agents (`assigned_to`) and track who created them (`created_by`).
- **Role-Based Routing:** Default fallback roles ensure access control separation between standard employees and administrators.

---

### 📊 Database Structure

The application utilizes a relational MySQL database (`employee`) containing the core structures outlined below:

#### 1. `users` Table
Stores authentication details, contact info, and system roles.
| # | Name | Type | Null | Default | Extra / Notes |
|---|---|---|---|---|---|
| 1 | **id** (PK) | bigint UNSIGNED | No | *None* | AUTO_INCREMENT |
| 2 | **name** | varchar(191) | No | *None* | |
| 3 | **email** (Unique) | varchar(191) | No | *None* | |
| 4 | **email_verified_at** | timestamp | Yes | *NULL* | |
| 5 | **password** | varchar(191) | No | *None* | Hashed string |
| 6 | **remember_token** | varchar(100) | Yes | *NULL* | |
| 7 | **created_at** | timestamp | Yes | *NULL* | |
| 8 | **updated_at** | timestamp | Yes | *NULL* | |
| 9 | **role** | varchar(191) | No | `employee` | Defines access permissions |
| 10| **phone** | varchar(191) | Yes | *NULL* | |
| 11| **profile_image** | varchar(191) | Yes | *NULL* | Path to avatar file |
| 12| **department** | varchar(191) | Yes | *NULL* | |

#### 2. `tickets` Table
Tracks individual issues, assignments, and status metrics.
| Name | Type | Null | Key / Relationship | Description |
|---|---|---|---|---|
| **id** (PK) | bigint UNSIGNED | No | Primary Key | Auto-incrementing unique identifier |
| **title** | varchar(191) | No | | Summary of the issue |
| **description** | text | No | | Detailed context or error stack |
| **status** | varchar(191) | No | | Lifecycle state (`open`, `in_progress`, `resolved`) |
| **priority** | varchar(191) | No | | Severity level (`low`, `medium`, `high`) |
| **assigned_to** | bigint UNSIGNED | Yes | Foreign Key ➔ `users.id` | Support agent handling the ticket |
| **created_by** | bigint UNSIGNED | Yes | Foreign Key ➔ `users.id` | Employee who reported the issue |
| **created_at** | timestamp | Yes | | Date and time of submission |
| **updated_at** | timestamp | Yes | | Date and time of last update |

---

### 🛠️ Tech Stack

- **Backend Framework:** PHP / Laravel (MVC Architecture)
- **Frontend UI:** Blade Templates / HTML5, CSS3, JavaScript, Bootstrap
- **Database Engine:** MySQL (Port: 3308)
- **Authentication:** Laravel Built-in Session Auth & Guard with Role-Based Access Control (RBAC)

---

### 📋 Prerequisites

Before running this project locally, ensure you have the following installed:
- [Git](https://git-scm.com/)
- PHP (>= 8.x) & [Composer](https://getcomposer.org/)
- MySQL Server (e.g., XAMPP, WAMP, or Laragon running on port `3308`)

---

### ⚙️ Installation & Setup

Follow these steps to get your development environment running locally:

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/your-username/employee-ticket-system.git](https://github.com/your-username/employee-ticket-system.git)
   cd employee-ticket-system