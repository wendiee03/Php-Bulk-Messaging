# Bulk SMS Application

This is the PHP Project. This README file provides an overview of the project, instructions for setup, and guidelines for contributing.

## Project Overview

This PHP project allows users to send bulk SMS messages to multiple recipients categorized by user-defined groups. It includes features for user management, category management, contact management, and SMS sending capabilities.

### Technologies Used

- PHP
- MySQL
- HTML/CSS
- JavaScript

### Features

- **User Authentication**
 Register, login, and logout functionalities with session management.
- **Category Management**
Create, edit, and delete contact categories.
- **Contact Management**
Add, view, and delete contacts under specific categories.
- **SMS Sending**
Send SMS messages to contacts categorized by user-defined groups.

## Getting Started

To get started with the Bulk SMS Application, follow these instructions:

### Prerequisites

- PHP (version 7.x recommended)
- MySQL database server
- Web server

### Installation

1. **Clone the Repository:**

   git clone https://github.com/wendiee03/php-bulk-messaging.git

2. **Database Setup:**

   - Create a MySQL database named `bulksmsapp`.
   - Import the SQL file `bulksmsapp.sql` provided in the `database` directory into your database.


3. **Configuration:**

   - Update the credentials in `db.php` file with your.

     It should be something of the sort
        $servername = "your host";
        $username = "your username";
        $password = "your password";
        $dbname = "bulksmsapp";

4. **Start the Application:**

   - Ensure your web server (e.g., Apache) and MySQL server are running. Via the XAMPP app
   - Navigate to `http://localhost/php-bulksms/auth.php` in your web browser.

5. **Usage:**

   - Register a new user or use existing credentials to log in.
   - Add categories and contacts to organize recipients.
   - Use the dashboard to send bulk SMS messages to selected categories or individual contacts.


## Sample Pages

The following pages are part of the Bulk SMS Application:

1. **Login Page**
Allows users to log in to the application.
2. **Registration Page**
Enables new users to register for the application.
3. **Dashboard**
Main interface displaying categories, contacts, and SMS sending functionalities.
4. **Category Management Page**
Add, edit, and delete contact categories.
5. **Contact Management Page**
Add, view, and delete contacts under specific categories.
6. **Send SMS Modal**
Popup modal for sending SMS messages with category selection and message input.

## Contribution Guidelines

- Fork the repository and create a new branch for your feature or bug fix.
- Commit changes with descriptive messages adhering to the project's coding style.
- Submit a pull request detailing the changes made and any relevant information.

## IMPORTANT
- The service uses a very cheap API, so the number of SMS are limited to how much you have in the account.
The account details are:
**Paybill**
- 4060231
**Account**
- Shadrack

**REMEMBER TO ENABLE PROMOTIONAL MESSAGES OR ELSE YOU WONT RECEIVE THE MESSAGE** 

## THANK YOU

