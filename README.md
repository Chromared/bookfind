# BookFind

**BookFind** is a web application for users of a Documentation and Information Center (CDI). It allows searching for and borrowing books through an intuitive interface with secure user management.

---

## Table of contents

1. [Project overview](#project-overview)
2. [Features](#features)
3. [Project structure](#project-structure)
4. [Installation](#installation)
5. [Database configuration](#database-configuration)
6. [Usage](#usage)
7. [Dependencies](#dependencies)
8. [License](#license)

---

## Project overview

The **BookFind** project is designed to simplify the management of book loans within a CDI. The application allows users to:
- Search for available books
- Borrow books
- View their current loans
- Access protected features if they are graded

This application offers an efficient solution for the CDI staff and their users.

## Features

- **Home page**: Presentation of the application and a book search form.
- **Book search**: Interface allowing users to find books by their title.
- **Loan management**: View borrowed books and loan history.
- **Login and user profile**: Authentication with hashed passwords, access to restricted features, as well as a space to manage your own profile or edit another user's profile if you are graded. The editable parts vary depending on the permission level.

## Project structure

- `index.php`: Main page of the application, introducing the book search service.
- `login.php`: Login page to authenticate users.
- `books.php`: Book search page with a form to enter search criteria.
- `profile.php`: Interface allowing users to view and edit their personal information.
- `loans.php`: Page where the user can see the books they have borrowed.
- `privacy.php`: Page displaying the privacy policy and terms of use.
- `rules.php`: Page displaying the rules.

### Directories

- `actions/`: Contains the PHP and JavaScript scripts for actions, such as the database connection, registering a book and the general operation of the site.
- `includes/`: Components included in the various pages, such as `header.php`, `navbar.php` and `footer.php`, for consistent display. This folder centralizes pieces of code that do not need to be repeated and where changes impact every page.
- `assets/`: Resources such as CSS files, images and icons.
- `temp/`: Contains temporary files.

## Installation

1. **Clone the repository or download the ZIP**:
    ```bash
    git clone https://github.com/chromared/bookfind.git
    ```
2. **Local server setup**:
    - Use XAMPP, WAMP, or another server with PHP and MySQL.
3. **Move the project**:
    - Place the extracted folder in the root directory of your web server (usually `htdocs` on web servers and XAMPP, or `www` for WAMP and uWAMP).

## Configure BookFind

1. In your browser, go to the `configuration.php` file.
2. Follow the actions **in order** to configure the database and the classes of your institution...
3. When you are done, click the button that appears to delete the `configuration.php` file. This action is required for security reasons. The file must not remain accessible after configuration.

## Usage

### Steps for using the application

1. **Access the home page**: Go to `index.php` for an overview and quick access to the book search.
2. **Create an account and sign in**:
    - Go to `signup.php` or `login.php` to create an account or sign in.
3. **Search for books**:
    - Use `books.php` to browse the available books.
4. **View and manage the profile**:
    - View and edit your personal information on `profile.php`.
5. **Track loans**:
    - Go to `loans.php` to view your borrowed books and their status.
6. **Management**:
    - For graded users, a "Management" link appears in the navigation bar. Depending on your permissions, this link gives you access to certain site or CDI configuration options.

## Environment

- **Web server**: Apache.
- **PHP**: version 8.3 or higher.
- **MySQL**: version 8.4 or higher.

## Dependencies

- **None**: BookFind currently has no dependencies required for its operation.

## List of contributors

### Active contributors

- [Alban Muller / @MythUp_](https://github.com/MythUp)  -->  Full Stack
- [@Jià N0w](https://github.com/JiaN0w)  -->  GitHub repository management
- [@DawnFolk](https://github.com/DawnFolk)  -->  Pentest
- [@Sylvain Durif, le Grand Monarque, le Christ cosmique et le Messie lui-même](https://www.linkedin.com/in/sylvain-pierre-durif-26a92119/?locale=fr) --> Bénédiction Cosmique

### Passive contributors

- [Mitali Jadhavro  / Coding Artist](https://codingartistweb.com/)  -->  Frontend (JS = [action/fonction/title.js](https://github.com/Chromared/bookfind/blob/main/actions/functions/title.js))

## License

This project is distributed under the terms of the [AGPL-3.0](LICENSE) license. 2026 Chromared.
