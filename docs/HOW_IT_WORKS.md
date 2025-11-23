# How It Works

This document explains the architecture and data flow of the Direction Wise Tourism website.

## Architecture Overview

The website follows a **Model-View-Controller (MVC)** pattern with a simple routing system.

```
Request → index.php → router.php → Controller → Model → View → Response
```

## Request Flow

### 1. Entry Point (`index.php`)

All requests are routed through `index.php` (front controller pattern):
- Starts output buffering
- Loads configuration
- Initializes router
- Dispatches request

### 2. Routing (`php/router.php`)

The router:
- Parses the request URL
- Matches against defined routes
- Extracts route parameters (e.g., `{id}` in `/tour/{id}`)
- Calls the appropriate controller method

**Example Route:**
```php
$router->add('GET', '/tour/{id}', 'TourController@show');
```

### 3. Controllers (`php/controllers/`)

Controllers handle business logic:
- Receive request parameters
- Call models to fetch/manipulate data
- Prepare data for views
- Render views with data

**Example Controller:**
```php
class TourController {
    public function show($id) {
        $tour = $this->tourModel->getById($id);
        $this->render('tour-detail', ['tour' => $tour]);
    }
}
```

### 4. Models (`php/models/`)

Models handle data operations:
- Read/write to JSON files or MySQL database
- Abstract data storage (supports both JSON and MySQL)
- Provide clean API for controllers

**Example Model:**
```php
class TourModel {
    public function getById($id) {
        if (USE_DB) {
            return $this->getByIdFromDb($id);
        }
        return $this->getByIdFromJson($id);
    }
}
```

### 5. Views (`php/views/`)

Views are PHP templates that:
- Receive data from controllers
- Render HTML with embedded PHP
- Use base layout for consistency
- Include structured data (JSON-LD)

**Example View:**
```php
<h1><?php echo htmlspecialchars($tour['title']); ?></h1>
<p><?php echo htmlspecialchars($tour['excerpt']); ?></p>
```

## Data Storage

### JSON Mode (Default)

- **Tours**: `php/data/tours.json`
- **Bookings**: `php/data/bookings.json`
- Simple file-based storage
- No database required
- Easy to backup and version control

### MySQL Mode (Optional)

- Set `USE_DB=true` in `.env`
- Database schema in `database/schema.sql`
- Models automatically switch to database
- Better for high-traffic scenarios

## API Endpoints

### Booking API (`/api/book`)

**Method**: POST  
**Content-Type**: application/json

**Request:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "tour_id": 1,
  "date": "2025-02-01",
  "guests": 2,
  "message": "Special request"
}
```

**Response (Success):**
```json
{
  "success": true,
  "booking_id": "BK20250114001",
  "message": "Booking submitted successfully"
}
```

**Response (Error):**
```json
{
  "success": false,
  "errors": {
    "email": "Valid email is required"
  }
}
```

**Features:**
- Rate limiting (5 requests per minute per IP)
- Server-side validation
- Client-side validation (JavaScript)
- Stores to `bookings.json` or database

## Frontend Architecture

### CSS Architecture

- **CSS Variables**: Centralized design system
- **Mobile-First**: Responsive breakpoints
- **Utility Classes**: Reusable utility classes
- **Component-Based**: Styles organized by component

### JavaScript Architecture

- **Vanilla JS**: No frameworks, minimal dependencies
- **Modules**: Separate files for different concerns
  - `main.js`: Navigation, general interactivity
  - `forms.js`: Form handling and validation
  - `lazy-load.js`: Image lazy loading
  - `utils.js`: Utility functions
- **Deferred Loading**: All scripts use `defer` attribute

### Image Optimization

1. **Source Images**: Place in `assets/images/source/`
2. **Conversion**: Run `npm run convert-images`
3. **Output**: Optimized images in `assets/images/tours/`
4. **Formats**: WebP (modern) + JPEG (fallback)
5. **Sizes**: 400px, 800px, 1200px variants

## Security Features

### Input Sanitization

- All output escaped with `htmlspecialchars()`
- Prepared statements for database queries
- Input validation on both client and server

### Rate Limiting

- Simple file-based rate limiting
- 5 requests per minute per IP on `/api/book`
- Can be upgraded to Redis for production

### CSRF Protection

- Forms can include CSRF tokens (framework ready)
- Session-based authentication for admin

### File Access

- `.htaccess` blocks sensitive files
- Data and logs directories protected
- Environment variables in `.env` (not in repo)

## Performance Optimizations

### Frontend

- Lazy loading images
- Deferred JavaScript
- Responsive images with `srcset`
- Gzip compression
- Browser caching

### Backend

- File-based caching for tours.json
- Efficient PHP code
- Minimal database queries (if using MySQL)
- Output buffering

## Deployment

### Local Development

```bash
php -S localhost:8000 -t .
```

### Docker

```bash
docker-compose up -d
```

### Production

1. Upload files to server
2. Configure `.env` file
3. Set file permissions
4. Configure web server (Nginx/Apache)
5. Enable SSL/HTTPS

See `docs/DEPLOYMENT.md` for detailed instructions.

## File Structure

```
directionwise/
├── index.php              # Front controller
├── .htaccess              # Apache rewrite rules
├── .env.example           # Environment template
│
├── php/
│   ├── config.php         # Configuration
│   ├── router.php         # Routing
│   ├── controllers/       # Controllers
│   ├── models/            # Data models
│   ├── views/             # Templates
│   ├── utils/             # Utilities
│   └── data/              # JSON data
│
├── assets/
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript
│   └── images/            # Images
│
├── scripts/               # Build scripts
├── tests/                 # Tests
├── docker/                # Docker config
└── docs/                  # Documentation
```

## Extending the Website

### Adding a New Page

1. Add route in `php/router.php`:
   ```php
   $router->add('GET', '/new-page', 'Controller@method');
   ```

2. Create controller method:
   ```php
   public function method() {
       $this->render('new-page', ['data' => $data]);
   }
   ```

3. Create view file: `php/views/new-page.php`

### Adding a New Tour

**JSON Mode:**
- Edit `php/data/tours.json`
- Add new tour object with required fields

**MySQL Mode:**
- Use admin panel at `/admin/tours`
- Or insert directly into database

### Customizing Styles

- Edit CSS variables in `assets/css/main.css`
- All colors, spacing, typography centralized
- Add component styles as needed

## Troubleshooting

### 404 Errors

- Check `.htaccess` is enabled (Apache)
- Verify Nginx rewrite rules
- Check route definitions in `router.php`

### Database Connection Errors

- Verify `.env` configuration
- Check database credentials
- Ensure database exists and user has permissions

### Image Loading Issues

- Verify image paths in `tours.json`
- Check file permissions on `assets/images/`
- Run image conversion script

## Support

For questions or issues:
- Email: info@directionwisetourism.com
- Phone: +971 52 849 2942

