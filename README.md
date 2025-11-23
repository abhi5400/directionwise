# Direction Wise Tourism - Website

A complete, production-ready website for Direction Wise Tourism LLC (Dubai, UAE) built with HTML, CSS, JavaScript, and PHP.

## 🚀 Quick Start

### Prerequisites
- PHP 8.0+ (8.1+ recommended)
- Node.js 16+ (for image conversion script)
- Composer (optional, for PHPUnit tests)

### Local Development

1. **Clone or extract the project:**
   ```bash
   cd directionwise
   ```

2. **Set up environment:**
   ```bash
   cp .env.example .env
   # Edit .env with your settings (optional for JSON mode)
   ```

3. **Start PHP built-in server:**
   ```bash
   php -S localhost:8000 -t .
   ```

4. **Open in browser:**
   ```
   http://localhost:8000
   ```

### Using Docker

```bash
docker-compose up -d
```

Access at `http://localhost:8080`

## 📁 Project Structure

```
directionwise/
├── index.php                 # Front controller
├── .htaccess                # Apache rewrite rules
├── .env.example             # Environment variables template
├── composer.json            # PHP dependencies (optional)
├── package.json             # Node.js dependencies (image conversion)
│
├── php/
│   ├── config.php           # Configuration & environment
│   ├── router.php           # Routing logic
│   ├── controllers/         # Controllers
│   │   ├── HomeController.php
│   │   ├── TourController.php
│   │   ├── ApiController.php
│   │   ├── AdminController.php
│   │   └── ErrorController.php
│   ├── models/              # Data models
│   │   ├── TourModel.php
│   │   └── BookingModel.php
│   ├── views/               # PHP templates
│   │   ├── layouts/
│   │   │   └── base.php
│   │   ├── home.php
│   │   ├── tours.php
│   │   ├── tour-detail.php
│   │   ├── about.php
│   │   ├── contact.php
│   │   ├── admin.php
│   │   ├── 404.php
│   │   └── 500.php
│   ├── data/                # JSON data storage
│   │   ├── tours.json
│   │   └── bookings.json
│   └── logs/                # Application logs
│
├── assets/
│   ├── css/
│   │   └── main.css         # Main stylesheet
│   ├── js/
│   │   ├── main.js          # Main JavaScript
│   │   ├── forms.js         # Form handling
│   │   ├── lazy-load.js     # Lazy loading
│   │   └── utils.js         # Utilities
│   ├── images/              # Image assets
│   └── icons/               # SVG icons
│
├── scripts/
│   └── convert-images.js    # Image conversion script
│
├── tests/
│   ├── php/                 # PHPUnit tests
│   └── js/                  # JavaScript tests
│
├── docker/
│   ├── Dockerfile
│   └── nginx.conf           # Nginx configuration
│
├── docker-compose.yml       # Docker Compose setup
├── .github/
│   └── workflows/
│       └── ci.yml           # CI/CD pipeline
│
├── sitemap.xml              # Generated sitemap
├── robots.txt               # Robots file
│
└── docs/
    ├── DEPLOYMENT.md        # Deployment guide
    ├── ACCESSIBILITY.md     # Accessibility report
    ├── PERFORMANCE.md       # Performance notes
    └── CONTENT-SEO.md       # SEO content plan
```

## ⚙️ Configuration

### Environment Variables (.env)

```env
# Application
APP_ENV=development
APP_DEBUG=true

# Database (optional - set USE_DB=true to enable MySQL)
USE_DB=false
DB_HOST=localhost
DB_NAME=directionwise
DB_USER=root
DB_PASS=

# Admin (for admin panel)
ADMIN_USERNAME=admin
ADMIN_PASSWORD=changeme

# Email (optional - for booking notifications)
SMTP_ENABLED=false
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=
SMTP_PASS=
SMTP_FROM=info@directionwisetourism.com
```

### Switching Between JSON and MySQL

1. **JSON Mode (default):**
   - Set `USE_DB=false` in `.env` or omit it
   - Data stored in `php/data/tours.json` and `php/data/bookings.json`

2. **MySQL Mode:**
   - Set `USE_DB=true` in `.env`
   - Configure `DB_*` variables
   - Run migration: `php scripts/migrate.php` (or import `database/schema.sql`)

## 🛠️ Development Tasks

### Image Conversion

Convert images to WebP/AVIF:

```bash
npm install
node scripts/convert-images.js
```

Place source images in `assets/images/source/` and they'll be converted to optimized versions.

### Running Tests

**PHP Tests:**
```bash
composer install
vendor/bin/phpunit tests/php
```

**JavaScript Tests:**
```bash
npm test
```

### Building Assets

No build step required for vanilla CSS/JS. If using Tailwind variant:

```bash
npm run build:tailwind
```

## 📦 Deployment

### Shared Hosting

1. Upload all files to your web root
2. Set `DocumentRoot` to project root
3. Ensure `.htaccess` is enabled (Apache)
4. Set file permissions: `chmod 755` for directories, `chmod 644` for files
5. Create `.env` file with production settings
6. Ensure `php/data/` and `php/logs/` are writable

### Docker Production

```bash
docker-compose -f docker-compose.prod.yml up -d
```

### Nginx Configuration

See `docker/nginx.conf` for production-ready Nginx config with:
- Security headers
- Gzip compression
- Cache headers
- HTTPS redirect

### SSL/HTTPS

Use Let's Encrypt:

```bash
certbot --nginx -d directionwisetourism.com
```

## 🔒 Security

- All output escaped with `htmlspecialchars()`
- Prepared statements for database queries
- CSRF protection on forms
- Rate limiting on API endpoints
- Input validation and sanitization
- `.env` file excluded from version control

## 📊 Performance

- Lighthouse target: 90+ on mobile
- Lazy loading for images
- Critical CSS inlined
- Deferred JavaScript
- Responsive images with `srcset`
- Gzip/Brotli compression

## ♿ Accessibility

- WCAG 2.1 AA compliant
- Keyboard navigation
- Screen reader support
- Focus indicators
- Color contrast ratios
- Semantic HTML

## 📝 License

MIT License - see LICENSE file

## 🆘 Support

For issues or questions:
- Email: info@directionwisetourism.com
- Phone: +971 52 849 2942

## 📚 Additional Documentation

- [Deployment Guide](docs/DEPLOYMENT.md)
- [Accessibility Report](docs/ACCESSIBILITY.md)
- [Performance Notes](docs/PERFORMANCE.md)
- [SEO Content Plan](docs/CONTENT-SEO.md)

