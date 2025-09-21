# PHP MVC Framework

A lightweight MVC framework built with PHP that includes database integration, environment configuration, and routing capabilities.

## Features

- MVC (Model-View-Controller) architecture
- PDO database integration
- Environment configuration management
- Dynamic routing system
- Bootstrap UI integration
- Monolog-based logging
- PSR-4 autoloading
- Supports Memcached

## Project Structure
```
project-root/
├── app/
│   ├── Controller/        # Controller classes
│   ├── Framework/        # Core framework classes
│   ├── Model/           # Model classes
│   ├── View/            # View templates
│   ├── config/          # Configuration files
│   ├── bootstrap.php    # Application bootstrap
│   └── functions.php    # Helper functions
├── log/                 # Log files
├── public/              # Public assets
│   ├── css/            # CSS files
│   ├── js/             # JavaScript files
│   └── images/         # Image assets
├── vendor/             # Composer dependencies
├── .env                # Environment variables
├── .env.sample         # Environment template
├── composer.json       # Composer configuration
└── index.php          # Application entry point
```

## Environment Configuration
Required environment variables:

APP_NAME: Application name
LOG_FILE: Log file name
DB_CONNECTION: Database type
DB_HOST: Database host
DB_PORT: Database port
DB_DATABASE: Database name
DB_USERNAME: Database username
DB_PASSWORD: Database password

## Key Components
Router: Handles URL routing and dispatching
Model: Base class for database operations
Logger: Monolog-based logging implementation
Environment Manager: Handles .env file configuration


## Dependencies
PHP 8.0+
MySQL/MariaDB
Monolog for logging
Composer for dependency management


## Setup

1. Clone the repository
2. Install dependencies:
```bash
composer install
```
3. Copy .env.sample to .env and configure your environment variables:
```bash
cp .env.sample .env
```
4. Start the PHP server
```bash
php -S localhost:8000 index.php
```

The framework uses modern PHP practices like:
- Namespace usage
- PDO for database operations
- Environment configuration
- PSR-4 autoloading
- Composer dependency management

Feel free to modify the content or add additional sections as needed.

The framework uses modern PHP practices like:
- Namespace usage
- PDO for database operations
- Environment configuration
- PSR-4 autoloading
- Composer dependency management

Feel free to modify the content or add additional sections as needed.