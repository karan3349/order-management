# Laravel Order Management System

A simple Laravel 12-based Order Management System built with PHP 8.2. This application allows users to manage customers, products, and orders, with dynamic order item entry and real-time price calculations.

## 🚀 Features

-   Order CRUD
-   Dynamic Order Items (add multiple products in one order)
-   Real-time product price fetch via AJAX
-   Order total & grand total auto-calculation
-   Relationship-based models (Customer, Product, Order, OrderItem)
-   Blade components with Tailwind CSS
-   Validation using Form Request
-   Clean MVC structure with Laravel best practices

---

## 🧰 Tech Stack

-   **Backend:** Laravel 12, PHP 8.2
-   **Frontend:** Blade, TailwindCSS, Alpine.js (via Laravel Breeze/Vite)
-   **Database:** MySQL
-   **JS/AJAX:** Vanilla JS + Fetch API

---

## 🧑‍💻 Setup Instructions

1. **Clone the repository**

```bash
git clone git@github.com:karan3349/order-management.git
cd expense-tracker
git checkout master
```

2. **Install dependencies**

```bash
composer install
npm install && npm run build
```

2. **Set up environment variables**

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

```

2. **Serve the app**

```bash
 php artisan serve
```
