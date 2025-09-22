# The Vision Laravel

The Vision Laravel is a modern web application for showcasing GCC business leaders through interviews and podcasts. Built with Laravel, it provides a robust content management system, public-facing pages, and a secure admin panel.

## Features

- 🎤 **Interview Management:** Create, edit, and publish interviews by country/category.
- 🎧 **Podcast Hosting:** Upload, stream, and manage podcast episodes.
- 📅 **Event Management:** Organize and display events with date, time, and location.
- 🗂️ **Category System:** Assign content to GCC countries or custom categories.
- 🔒 **Admin Panel:** Secure dashboard for managing all content types.
- 🌍 **Modern Public Pages:** Responsive, SEO-friendly pages for visitors.
- 📬 **Contact Management:** View and respond to contact form submissions.
- 🖼️ **Media Uploads:** Image and audio file support for content.
- 🔎 **Search & Filter:** Advanced filtering for public and admin views.

## Getting Started

1. **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/theVisionLaravel.git
    cd theVisionLaravel
    ```
2. **Install dependencies:**
    ```bash
    composer install
    npm install && npm run build
    ```
3. **Copy the environment file and set your configuration:**
    ```bash
    cp .env.example .env
    ```
4. **Generate an application key:**
    ```bash
    php artisan key:generate
    ```
5. **Set up your database and run migrations:**
    ```bash
    php artisan migrate
    ```
6. **(Optional) Seed sample data:**
    ```bash
    php artisan db:seed
    ```
7. **Start the development server:**
    ```bash
    php artisan serve
    ```

## Usage

- **Admin Panel:** `/admin/dashboard` (requires login)
- **Public Pages:** `/events`, `/interviews`, `/podcasts`
- **Contact Form:** `/contact`

## Screenshots

> _Add screenshots of your homepage, admin panel, and podcast player here for best results!_

## Tech Stack

- Laravel 10+
- MySQL/MariaDB
- Tailwind CSS or Bootstrap 5
- Blade Templates

## Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](https://opensource.org/licenses/MIT)

---

_This project is inspired by the vision to highlight business leaders and innovators across the GCC region._