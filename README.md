
# XMVC Framework

A modern full-stack MVC framework combining PHP backend with React frontend, featuring robust caching, database management, and modern development tooling.

## Features

### Backend
- Modern MVC (Model-View-Controller) architecture
- Advanced routing system with API and Web router support
- Database management with migration support
- Event system with listeners
- Robust caching system with Memcached support
- PSR-4 compliant autoloading
- Comprehensive logging with Monolog
- RESTful API support
- Facade pattern for common services

### Frontend
- React-based UI components
- Vite for rapid development and optimized builds
- Component-based architecture
- SCSS styling support
- Custom theme system
- Font asset management

## Project Structure
```
project-root/
├── app/                    # Application core
│   ├── Controller/         # Controllers (Web & API)
│   ├── Model/             # Data models
│   ├── View/              # View templates
│   ├── Listener/          # Event listeners
│   ├── Theme/             # Theme definitions
│   ├── config/            # Configuration files
│   ├── sql/              # Database migrations
│   ├── bootstrap.php     # Application bootstrap
│   └── functions.php     # Helper functions
├── Framework/             # Core framework
│   ├── Api/              # API handling
│   ├── Cache/            # Caching system
│   ├── DB/               # Database management
│   ├── Event/            # Event system
│   ├── Router/           # Routing system
│   └── Facade/           # Service facades
├── resources/             # Frontend resources
│   ├── assets/           # Static assets
│   ├── theme/            # Theme assets
│   └── view/             # React components
├── public/               # Public assets
├── vendor/               # Composer dependencies
├── log/                  # Application logs
├── composer.json         # PHP dependencies
├── package.json          # Node.js dependencies
├── vite.config.js        # Vite configuration
└── index.php            # Application entry point
```

## Requirements

- PHP 8.4+
- Node.js 16+
- Memcached
- MySQL/MariaDB
- Composer

## Setup

1. Clone the repository:
```bash
git clone https://github.com/xclm2/php-mvc.git
cd php-mvc
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Configure your environment:
```bash
cp app/config/env.php.example app/config/env.php
# Edit env.php with your configuration
```

5. Start the development server:
```bash
# Terminal 1: PHP server
php -S localhost:8000

# Terminal 2: Vite dev server
npm run dev
```

## Development

- Backend code follows PSR-4 autoloading standards
- Frontend code uses React components in `resources/view`
- Use `npm run build` for production builds
- Database migrations are in `app/sql/scripts`

## Testing

```bash
# Run PHP tests
./vendor/bin/phpunit

# Run frontend tests (if configured)
npm test
```

## Key Components

- **Router**: Advanced routing with API and Web support
- **Model**: Base class for database operations with migration support
- **Cache**: Flexible caching system with Memcached integration
- **Event System**: Publish/subscribe pattern for application events
- **Theme System**: Customizable theming support
- **Asset Management**: Vite-powered asset compilation and serving

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

[MIT License](LICENSE)