# Performance Notes

This document outlines performance optimizations and targets for the Direction Wise Tourism website.

## Performance Targets

- **Lighthouse Performance Score**: 90+ (mobile)
- **First Contentful Paint (FCP)**: < 1.2s
- **Largest Contentful Paint (LCP)**: < 2.5s
- **Time to Interactive (TTI)**: < 3.5s
- **Total Blocking Time (TBT)**: < 150ms
- **Cumulative Layout Shift (CLS)**: < 0.1
- **Total Page Weight**: < 1.2MB (ideally < 800KB)

## Implemented Optimizations

### 1. Image Optimization
- **Responsive Images**: Using `<picture>` and `srcset` for different screen sizes
- **WebP Format**: Modern format with better compression
- **Lazy Loading**: Native `loading="lazy"` attribute
- **Proper Sizing**: Images sized appropriately (400px, 800px, 1200px)
- **Aspect Ratios**: Fixed aspect ratios prevent layout shift

### 2. CSS Optimization
- **CSS Variables**: Efficient theming and maintenance
- **Minimal CSS**: Only necessary styles included
- **No Unused CSS**: Removed unused styles
- **Critical CSS**: Above-the-fold CSS can be inlined (future enhancement)

### 3. JavaScript Optimization
- **Deferred Loading**: Scripts use `defer` attribute
- **No Blocking Scripts**: All scripts load asynchronously
- **Vanilla JS**: No heavy frameworks
- **Code Splitting**: Modular JavaScript files
- **Minimal Dependencies**: Only essential code

### 4. Server Optimization
- **Gzip Compression**: Enabled in Nginx/Apache
- **Browser Caching**: Long-term caching for static assets
- **Cache Headers**: Proper cache-control headers
- **CDN Ready**: Structure supports CDN integration

### 5. Font Optimization
- **Preconnect**: Preconnect to Google Fonts
- **Font Display**: Using `display=swap` for faster rendering
- **System Fonts Fallback**: Fallback to system fonts

### 6. Code Optimization
- **Minimal PHP**: Efficient PHP code
- **JSON Caching**: File-based caching for tours.json
- **Database Optimization**: Indexed queries (if using MySQL)

## Performance Testing

### Tools

1. **Google Lighthouse**
   ```bash
   # Run in Chrome DevTools or CLI
   lighthouse https://directionwisetourism.com --view
   ```

2. **PageSpeed Insights**
   - Visit: https://pagespeed.web.dev/
   - Test your URL
   - Review mobile and desktop scores

3. **WebPageTest**
   - Visit: https://www.webpagetest.org/
   - Test from multiple locations
   - Review waterfall charts

### Metrics to Monitor

- **Core Web Vitals**
  - LCP (Largest Contentful Paint)
  - FID (First Input Delay)
  - CLS (Cumulative Layout Shift)

- **Additional Metrics**
  - FCP (First Contentful Paint)
  - TTI (Time to Interactive)
  - TBT (Total Blocking Time)
  - Speed Index

## Optimization Recommendations

### Immediate Actions

1. **Enable Compression**
   - Ensure Gzip/Brotli is enabled on server
   - Check compression in Nginx/Apache config

2. **Optimize Images**
   - Run image conversion script
   - Use WebP format
   - Compress images appropriately

3. **Minify Assets** (if needed)
   - Minify CSS and JavaScript
   - Use build tools if necessary

4. **CDN Integration**
   - Consider using CDN for static assets
   - Use CDN for images

### Future Enhancements

1. **Critical CSS Inlining**
   - Extract above-the-fold CSS
   - Inline critical CSS
   - Defer non-critical CSS

2. **Service Worker**
   - Implement caching strategy
   - Offline support
   - Faster repeat visits

3. **HTTP/2 Server Push**
   - Push critical resources
   - Reduce round trips

4. **Resource Hints**
   - Add `preload` for critical resources
   - Use `prefetch` for likely next pages

5. **Database Optimization**
   - Add query caching
   - Optimize database indexes
   - Use connection pooling

## Monitoring

### Regular Checks

- Weekly Lighthouse audits
- Monitor Core Web Vitals in Google Search Console
- Track page load times
- Monitor server response times

### Alerts

- Set up alerts for performance degradation
- Monitor error rates
- Track API response times

## Performance Budget

- **HTML**: < 50KB
- **CSS**: < 30KB
- **JavaScript**: < 50KB
- **Images**: < 500KB per page
- **Total**: < 1.2MB per page

## Best Practices

1. **Minimize HTTP Requests**
   - Combine CSS/JS files where possible
   - Use image sprites if needed

2. **Optimize Critical Rendering Path**
   - Minimize render-blocking resources
   - Defer non-critical CSS/JS

3. **Reduce Server Response Time**
   - Optimize PHP code
   - Use caching where appropriate
   - Optimize database queries

4. **Leverage Browser Caching**
   - Set appropriate cache headers
   - Version static assets

5. **Optimize Images**
   - Use appropriate formats (WebP, AVIF)
   - Compress images
   - Use responsive images

## Contact

For performance questions or issues:
- Email: info@directionwisetourism.com
- Phone: +971 52 849 2942

