# HikariReader

HikariReader is a modern and responsive web application designed for manga lovers. It offers an optimized user experience for browsing, reading, and managing your favorite series with features such as categorized listings, advanced search, reading history, and personal libraries.

## Features

* **Browsing and Reading:** Explore a vast collection of manga with an intuitive reading interface.
* **Advanced Search:** Easily find your favorite series using detailed filters and search criteria.
* **Categorized Listings:** Organize and discover manga by genre, popularity, and other attributes.
* **Reading History:** Track your progress and resume reading where you left off.
* **Personal Libraries:** Create and manage your own manga collections.
* **Responsive Design:** Enjoy a seamless reading experience on any device, be it desktop, tablet, or smartphone.

## Technologies Used

HikariReader is built with the following technologies:

* **Laravel:** A robust PHP framework for backend development, providing a solid structure and powerful tools for web applications.
* **PHP:** The primary programming language used on the server side.
* **Composer:** A dependency manager for PHP, used to manage Laravel libraries and packages.
* **Vite:** A modern frontend build tool that provides a fast and optimized development environment.
* **Tailwind CSS:** A utility CSS framework that allows for the rapid creation of custom and responsive designs.
* **JavaScript:** Used for interactivity and dynamic functionality on the frontend.
* **NPM:** A package manager for JavaScript, used to manage frontend dependencies.

## Installation

To set up HikariReader in your local environment, follow the steps below:

1. **Clone the repository:**

```bash
git clone https://github.com/Nunderns/HikariReader.git
cd HikariReader
```

2. **Install Composer dependencies:**

```bash
composer install
```

3. **Install NPM dependencies:**

```bash
npm install
```

4. **Set up the environment file:**

Create a copy of the `.env.example` file and rename it to `.env`:

```bash
cp .env.example .env
```

5. **Generate the application key:**

```bash
php artisan key:generate
```

6. **Set up the database data:**

Edit the `.env` file and set up your database credentials. Once configured, run the migrations:

```bash
php artisan migrate
```

7. **Run the development server:**

```bash
php artisan serve
npm run dev
```

The application will be available at `http://127.0.0.1:8000` (or another port, depending on your configuration).

## Usage

After installation, you can access HikariReader in your web browser. Browse the categories, use the search to find specific manga, and add them to your personal library. Your reading history will be updated automatically as you progress through the series.

## Contribution

Contributions are welcome! If you would like to contribute to the HikariReader project, please follow these guidelines:

1. Fork the repository.

2. Create a new branch for your feature (`git checkout -b feature/your-feature`).
3. Make your changes and commit them (`git commit -m 'feat: Add new feature'`).
4. Push to the original branch (`git push origin feature/your-feature`).
5. Open a Pull Request.

Make sure your code follows the project's style standards and that all tests pass.

## License

This project is licensed under the MIT License. See the `LICENSE` file for more details.

---
