# Deployment Guide

This guide covers deploying the Direction Wise Tourism website to production.

## Prerequisites

- PHP 8.0+ (8.1+ recommended)
- Web server (Apache or Nginx)
- MySQL 8.0+ (optional, if using database mode)
- SSL certificate (recommended for production)

## Deployment Options

### Option 1: Shared Hosting

1. **Upload Files**
   - Upload all project files to your web root directory
   - Ensure file structure is maintained

2. **Set Permissions**
   ```bash
   chmod 755 php/data
   chmod 755 php/logs
   chmod 644 php/data/*.json
   ```

3. **Configure Environment**
   - Create `.env` file in project root
   - Copy from `.env.example` and update values
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`

4. **Configure Web Server**
   - For Apache: Ensure `.htaccess` is enabled
   - For Nginx: Use provided `docker/nginx.conf` as reference
   - Set `DocumentRoot` to project root

5. **Test**
   - Visit your domain
   - Test booking form
   - Verify all pages load correctly

### Option 2: Docker Deployment

1. **Build and Start**
   ```bash
   docker-compose up -d
   ```

2. **Configure Environment**
   - Edit `.env` file with production values
   - Set `USE_DB=true` if using MySQL
   - Update database credentials

3. **Initialize Database** (if using MySQL)
   ```bash
   docker exec -i directionwise-db mysql -udirectionwise -pdirectionwise123 directionwise < database/schema.sql
   ```

4. **Access**
   - Website: `http://your-domain:8080`
   - phpMyAdmin: `http://your-domain:8081`

### Option 3: VPS/Cloud Server

1. **Install Dependencies**
   ```bash
   sudo apt update
   sudo apt install nginx php8.1-fpm php8.1-mysql php8.1-mbstring mysql-server
   ```

2. **Clone/Upload Project**
   ```bash
   git clone <repository> /var/www/directionwise
   cd /var/www/directionwise
   ```

3. **Set Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/directionwise
   sudo chmod -R 755 /var/www/directionwise
   sudo chmod -R 775 php/data php/logs
   ```

4. **Configure Nginx**
   - Copy `docker/nginx.conf` to `/etc/nginx/sites-available/directionwise`
   - Update server_name and paths
   - Enable site: `sudo ln -s /etc/nginx/sites-available/directionwise /etc/nginx/sites-enabled/`
   - Test: `sudo nginx -t`
   - Reload: `sudo systemctl reload nginx`

5. **Configure PHP-FPM**
   - Edit `/etc/php/8.1/fpm/php.ini`
   - Set appropriate limits and settings

6. **Setup SSL (Let's Encrypt)**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d directionwisetourism.com
   ```

7. **Configure Environment**
   - Create `.env` file with production settings
   - Set secure passwords and keys

## Post-Deployment Checklist

- [ ] Update `.env` with production values
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Update `BASE_URL` and `APP_URL` in `.env`
- [ ] Configure SSL/HTTPS
- [ ] Test all forms (booking, contact)
- [ ] Verify API endpoints work
- [ ] Check error pages (404, 500)
- [ ] Test on mobile devices
- [ ] Verify SEO meta tags
- [ ] Submit sitemap to Google Search Console
- [ ] Setup monitoring/logging
- [ ] Configure backups
- [ ] Update admin credentials
- [ ] Test rate limiting
- [ ] Verify image optimization

## Security Hardening

1. **File Permissions**
   - Restrict access to sensitive files
   - Ensure `.env` is not publicly accessible

2. **Database Security**
   - Use strong passwords
   - Limit database user permissions
   - Enable SSL for database connections

3. **Server Security**
   - Keep software updated
   - Configure firewall
   - Enable fail2ban
   - Regular security audits

4. **Application Security**
   - Review and update admin credentials
   - Enable rate limiting
   - Monitor logs for suspicious activity
   - Regular backups

## Monitoring

- Monitor server resources (CPU, memory, disk)
- Check application logs in `php/logs/`
- Monitor error rates
- Track booking submissions
- Monitor API usage

## Backup Strategy

1. **Database Backups** (if using MySQL)
   ```bash
   mysqldump -u directionwise -p directionwise > backup_$(date +%Y%m%d).sql
   ```

2. **File Backups**
   - Backup `php/data/` directory
   - Backup uploaded images
   - Backup `.env` file (securely)

3. **Automated Backups**
   - Setup cron job for daily backups
   - Store backups off-site
   - Test restore procedures

## Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   - Check PHP error logs
   - Verify file permissions
   - Check `.env` configuration

2. **404 Not Found**
   - Verify `.htaccess` is enabled (Apache)
   - Check Nginx rewrite rules
   - Verify file paths

3. **Database Connection Errors**
   - Verify database credentials in `.env`
   - Check database server is running
   - Verify network connectivity

4. **Permission Errors**
   - Check file ownership
   - Verify directory permissions
   - Check PHP-FPM user permissions

## Support

For deployment assistance:
- Email: info@directionwisetourism.com
- Phone: +971 52 849 2942

