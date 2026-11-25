# Coldplay Fanpage — Full-Stack E-Commerce & Event Ticketing

A full-stack web application built with **PHP 8**, **MySQL**, **Bootstrap 5**, and **JavaScript**. It combines a band showcase (history, discography, events) with a complete e-commerce store, ticket purchasing flow, user order history, and an administrative dashboard.

---

## Key Features

- **Public Pages:** Home, band history, discography & album details, events listing & search, contact page
- **Authentication:** User registration, login/logout, session management (`php/session.php`)
- **E-Commerce Store:** Product catalog, shopping cart (`add_to_cart.php`, `cart.php`), quantity updates, checkout with automatic stock updates
- **Event Ticketing:** Event details, ticket selection, purchase tracking (`my_orders.php`)
- **Admin Dashboard:** Manage products (`admin_products.php`), events (`admin_events.php`), orders (`admin_orders.php`), and users/roles (`admin_users.php`)

---

## Tech Stack

- **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript, Font Awesome
- **Backend:** PHP 8
- **Database:** MySQL / phpMyAdmin

---

## Database Schema

Database name: `coldplay_fanpage` (schema included in `database/coldplay_fanpage.sql`).

Main tables: `users`, `products`, `events`, `orders`, `order_items`, `tickets`.

---

## Local Setup (XAMPP / WAMP)

1. Install **XAMPP** (or WAMP/MAMP) and start **Apache** and **MySQL**.
2. Clone or copy this repository into your web root (e.g., `xampp/htdocs/coldplay-fanpage`).
3. Import `database/coldplay_fanpage.sql` via **phpMyAdmin** (`http://localhost/phpmyadmin`).
4. Review `php/db.php` (defaults to `localhost`, user `root`, empty password, database `coldplay_fanpage`).
5. Open `http://localhost/coldplay-fanpage/php/index.php` in your browser.

---

## Author

**Rafael Costa**  
GitHub: [@rafaelcosta-git](https://github.com/rafaelcosta-git) · LinkedIn: [Rafael Costa](https://www.linkedin.com/in/rafael-costa-950a80321)
