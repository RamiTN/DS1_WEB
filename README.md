# ChallengeHub

ChallengeHub is a **collaborative web platform** for creative challenges. Users can create accounts, publish challenges, participate in challenges, vote, and comment on submissions. Admins can manage users through a dedicated dashboard.  

The project is developed in **PHP (OOP)** with **MySQL** and uses a **simplified MVC structure**. No frameworks are used.

---

## Features

### User
- Registration & Login
- Logout
- User Dashboard
- Participate in challenges
- Submit entries (with description and image/link)
- Vote on submissions (once per submission)
- Comment on submissions

### Admin
- Admin dashboard
- View all users
- Delete users

### Challenges
- Create, Edit, Delete challenges (by owner)
- Title, Description, Category, Deadline, Image (optional)
- Public listing of challenges
- View submissions per challenge

---

## Project Structure


/app
/controllers
UserController.php
AdminController.php
ChallengeController.php
SubmissionController.php
CommentController.php
VoteController.php
/models
User.php
Challenge.php
Submission.php
Comment.php
Vote.php
/views
/user
login.php
register.php
userDashboard.php
/admin
adminDashboard.php
/challenge
index.php
create.php
edit.php
/submission
create.php
edit.php
/comment
list.php
create.php
/config
config.php
/public
/css
/js
/images
index.php
/sql
challengeHub.sql <-- database dump


---

## Setup Instructions

1. **Install a local server**  
   Use [WAMP](https://www.wampserver.com/), [XAMPP](https://www.apachefriends.org/), or [EasyPHP](https://www.easyphp.org/).  

2. **Clone the repository**
```bash
git clone <your-repo-url>
cd ds1_web

Create the database

Open phpMyAdmin or MySQL console

Create a database (e.g., challengehub)

Import the SQL file: /sql/challengeHub.sql

Configure database connection
Edit /config/config.php if needed:

define('DB_HOST', 'localhost');
define('DB_NAME', 'challengehub');
define('DB_USER', 'root');
define('DB_PASS', '');

Run the project

Start your local server (Apache + MySQL)

Navigate to http://localhost/ds1_web/index.php

Default Admin Account

You can log in as admin using the credentials:

Email: admin@example.com

Password: admin

Make sure the admin account exists in the database (users table) with role = 'admin'.

Notes

Passwords are hashed using PHP password_hash().

Sessions are used for authentication.

Basic security measures are implemented:

Prepared statements (PDO) to prevent SQL injection

HTML escaping (htmlspecialchars) to prevent XSS

No frameworks or CMS are used.

Author

Mohammed Rami Abbassi/Takwa Mdallel/Chahd Benslimen

Student in 2nd year E-Business

Developed as part of the Programmation Web 2 course

Do you want me to add that?
