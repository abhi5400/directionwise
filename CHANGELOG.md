# Changelog

All notable changes to the Direction Wise Tourism website will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-01-14

### Added
- Initial release of Direction Wise Tourism website
- Complete responsive website with HTML, CSS, JavaScript, and PHP
- Home page with hero section, featured tours, services, founder section, testimonials, and booking form
- Tours listing page with filterable tour cards
- Tour detail pages with full descriptions, itineraries, and related tours
- About page with company information, mission, vision, and founder details
- Contact page with contact form and map integration
- Booking API endpoint (`/api/book`) with validation and rate limiting
- Admin panel for managing tours (optional feature)
- 404 and 500 error pages
- SEO optimization with meta tags, JSON-LD structured data, sitemap, and robots.txt
- Accessibility features (WCAG 2.1 AA compliant)
- Performance optimizations (lazy loading, responsive images, compression)
- Docker setup with PHP-FPM, Nginx, and MySQL
- Image conversion script for WebP/AVIF formats
- Database schema for MySQL support
- Comprehensive documentation (README, deployment guides, accessibility report)
- Security features (CSRF protection, input sanitization, rate limiting)

### Technical Stack
- Frontend: HTML5, CSS3 (with CSS variables), Vanilla JavaScript (ES2020+)
- Backend: PHP 8.1+ (no frameworks)
- Data Storage: JSON files (default) with optional MySQL support
- Server: Nginx with PHP-FPM
- Containerization: Docker and Docker Compose

### Features
- Mobile-first responsive design
- Semantic HTML5
- Modern CSS with CSS variables and utility classes
- Vanilla JavaScript modules
- PHP routing system
- JSON-based content management
- Optional MySQL database support
- Image optimization pipeline
- Form validation (client and server-side)
- Rate limiting on API endpoints
- Logging system
- Admin authentication

### Documentation
- README.md with setup and deployment instructions
- DEPLOYMENT.md with detailed deployment guides
- ACCESSIBILITY.md with accessibility features and testing
- PERFORMANCE.md with performance notes and optimizations
- CONTENT-SEO.md with SEO content plan

[1.0.0]: https://github.com/directionwise/tourism-website/releases/tag/v1.0.0

