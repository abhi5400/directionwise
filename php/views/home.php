<?php
/**
 * Home Page View
 */

// Set skipDefaultSchema to true since we'll add custom schema
$skipDefaultSchema = true;
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Luxury Tours & VIP Travel Experiences in Dubai & Abu Dhabi</h1>
                <p class="hero-subtitle">Discover the magic of the UAE with expert guides and premium service. Your unforgettable journey starts here.</p>
                <div class="hero-cta">
                    <a href="/tours" class="btn btn-primary btn-large">Explore Tours</a>
                    <a href="/contact#booking" class="btn btn-secondary btn-large">Book Now</a>
                </div>
            </div>
            <div class="hero-image">
                <picture>
                    <source srcset="/assets/images/hero.webp" type="image/webp">
                    <img src="/assets/images/hero.jpg" alt="Dubai skyline and luxury travel" loading="eager" width="1200" height="800">
                </picture>
            </div>
        </div>
    </div>
</section>

<!-- Featured Tours Section -->
<?php if (!empty($featuredTours)): ?>
<section class="section featured-tours">
    <div class="container">
        <div class="section-header">
            <h2>Featured Tours</h2>
            <p>Discover our most popular experiences in Dubai and Abu Dhabi</p>
        </div>
        <div class="tours-grid">
            <?php foreach ($featuredTours as $tour): ?>
            <article class="tour-card">
                <a href="/tour/<?php echo htmlspecialchars($tour['slug'] ?? $tour['id']); ?>" class="tour-card-link">
                    <div class="tour-card-image">
                        <picture>
                            <?php if (!empty($tour['image_webp'])): ?>
                            <source srcset="/assets/images/tours/<?php echo htmlspecialchars($tour['image_webp']); ?>" type="image/webp">
                            <?php endif; ?>
                            <img src="/assets/images/tours/<?php echo htmlspecialchars($tour['image'] ?? 'placeholder.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($tour['title']); ?>" 
                                 loading="lazy" 
                                 width="400" 
                                 height="225">
                        </picture>
                    </div>
                    <div class="tour-card-content">
                        <div class="tour-card-meta">
                            <span class="tour-duration"><?php echo htmlspecialchars($tour['duration'] ?? 'N/A'); ?></span>
                            <?php if (!empty($tour['tags'])): ?>
                            <span class="tour-tags">
                                <?php echo htmlspecialchars(implode(', ', array_slice($tour['tags'], 0, 2))); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <h3 class="tour-card-title"><?php echo htmlspecialchars($tour['title']); ?></h3>
                        <p class="tour-card-excerpt"><?php echo htmlspecialchars($tour['excerpt'] ?? ''); ?></p>
                        <div class="tour-card-footer">
                            <span class="tour-price">From <?php echo htmlspecialchars($tour['currency'] ?? 'USD'); ?> <?php echo number_format($tour['price_from'] ?? 0, 2); ?></span>
                            <span class="tour-cta">View Details →</span>
                        </div>
                    </div>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
        <div class="section-footer">
            <a href="/tours" class="btn btn-secondary">View All Tours</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Services Section -->
<section class="section services">
    <div class="container">
        <div class="section-header">
            <h2>Our Services</h2>
            <p>Comprehensive travel solutions for every need</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <img src="/assets/images/icon/country.svg" alt="City Tours" aria-hidden="true">
                </div>
                <h3>City Tours</h3>
                <p>Explore Dubai and Abu Dhabi's iconic landmarks with expert guides</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <img src="/assets/images/icon/award.svg" alt="Desert Safari" aria-hidden="true">
                </div>
                <h3>Desert Safari</h3>
                <p>Experience the magic of the Arabian desert with thrilling adventures</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <img src="/assets/images/icon/flight-booking.svg" alt="Luxury Transfers" aria-hidden="true">
                </div>
                <h3>Luxury Transfers</h3>
                <p>Premium transportation services for a comfortable journey</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <img src="/assets/images/icon/happy.svg" alt="Adventure Activities" aria-hidden="true">
                </div>
                <h3>Adventure Activities</h3>
                <p>Thrilling experiences for the adventurous traveler</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <img src="/assets/images/icon/document.svg" alt="Customized Itineraries" aria-hidden="true">
                </div>
                <h3>Customized Itineraries</h3>
                <p>Tailored travel plans designed just for you</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <img src="/assets/images/icon/travel-insurance.svg" alt="Hotel Bookings" aria-hidden="true">
                </div>
                <h3>Hotel Bookings</h3>
                <p>Best rates on premium accommodations</p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="section why-choose-us">
    <div class="container">
        <div class="section-header">
            <h2>Why Choose Direction Wise Tourism?</h2>
        </div>
        <div class="why-grid">
            <div class="why-item">
                <h3>Licensed Expert Guides</h3>
                <p>Our founder, Niranjan Singh Shekhawat, is a licensed UAE tour guide with over 15 years of experience.</p>
            </div>
            <div class="why-item">
                <h3>Premium Service</h3>
                <p>We specialize in luxury tours and VIP travel experiences, ensuring the highest standards of service.</p>
            </div>
            <div class="why-item">
                <h3>Personalized Attention</h3>
                <p>Every tour is customized to meet your preferences and create unforgettable memories.</p>
            </div>
            <div class="why-item">
                <h3>Local Expertise</h3>
                <p>Deep knowledge of Dubai and Abu Dhabi's culture, history, and hidden gems.</p>
            </div>
        </div>
    </div>
</section>

<!-- Founder Section -->
<section class="section founder">
    <div class="container">
        <div class="founder-content">
            <div class="founder-image">
                <picture>
                    <source srcset="/assets/images/founder.webp" type="image/webp">
                    <img src="/assets/images/founder.jpg" alt="Niranjan Singh Shekhawat - Founder" loading="lazy" width="400" height="400">
                </picture>
            </div>
            <div class="founder-text">
                <h2>Meet Our Founder</h2>
                <h3>Niranjan Singh Shekhawat</h3>
                <p class="founder-role">Licensed UAE Tour Guide | 15+ Years Experience</p>
                <p>With over 15 years of experience as a licensed tour guide in the UAE, Niranjan Singh Shekhawat founded Direction Wise Tourism to share his passion for the region's rich culture, stunning architecture, and breathtaking landscapes.</p>
                <p>His expertise and dedication ensure that every guest receives an authentic, memorable, and luxurious travel experience in Dubai and Abu Dhabi.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section testimonials">
    <div class="container">
        <div class="section-header">
            <h2>What Our Guests Say</h2>
        </div>
        <div class="testimonials-grid">
            <blockquote class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"An absolutely amazing experience! Niranjan was an incredible guide who showed us the best of Dubai. Highly recommend!"</p>
                <footer class="testimonial-author">
                    <strong>Sarah M.</strong>
                    <span>United States</span>
                </footer>
            </blockquote>
            <blockquote class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"The desert safari was unforgettable. Professional service from start to finish. Will definitely book again!"</p>
                <footer class="testimonial-author">
                    <strong>James L.</strong>
                    <span>United Kingdom</span>
                </footer>
            </blockquote>
            <blockquote class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">"Luxury at its finest! Every detail was perfect. Direction Wise Tourism exceeded all our expectations."</p>
                <footer class="testimonial-author">
                    <strong>Maria K.</strong>
                    <span>Germany</span>
                </footer>
            </blockquote>
        </div>
    </div>
</section>

<!-- Contact & Booking Section -->
<section class="section contact-booking" id="booking">
    <div class="container">
        <div class="section-header">
            <h2>Book Your Experience</h2>
            <p>Ready to explore Dubai and Abu Dhabi? Get in touch with us today!</p>
        </div>
        <div class="contact-grid">
            <div class="contact-info">
                <h3>Contact Information</h3>
                <ul class="contact-list">
                    <li>
                        <strong>Phone:</strong>
                        <a href="tel:+971528492942">+971 52 849 2942</a>
                    </li>
                    <li>
                        <strong>Email:</strong>
                        <a href="mailto:info@directionwisetourism.com">info@directionwisetourism.com</a>
                    </li>
                    <li>
                        <strong>Office:</strong>
                        <address>
                            509, MAKEYA SHARAFI Building<br>
                            Sharaf DG Metro Station<br>
                            Bur Dubai, UAE
                        </address>
                    </li>
                </ul>
            </div>
            <div class="booking-form-wrapper">
                <form id="booking-form" class="booking-form" novalidate>
                    <div class="form-group">
                        <label for="booking-name">Full Name *</label>
                        <input type="text" id="booking-name" name="name" required aria-required="true" aria-describedby="booking-name-error">
                        <span class="error-message" id="booking-name-error" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label for="booking-email">Email *</label>
                        <input type="email" id="booking-email" name="email" required aria-required="true" aria-describedby="booking-email-error">
                        <span class="error-message" id="booking-email-error" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label for="booking-phone">Phone *</label>
                        <input type="tel" id="booking-phone" name="phone" required aria-required="true" aria-describedby="booking-phone-error">
                        <span class="error-message" id="booking-phone-error" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label for="booking-tour">Select Tour</label>
                        <select id="booking-tour" name="tour_id">
                            <option value="">General Inquiry</option>
                            <?php if (!empty($allTours)): ?>
                                <?php foreach ($allTours as $tour): ?>
                                <option value="<?php echo htmlspecialchars($tour['id']); ?>"><?php echo htmlspecialchars($tour['title']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="booking-date">Preferred Date *</label>
                            <input type="date" id="booking-date" name="date" required aria-required="true" aria-describedby="booking-date-error" min="<?php echo date('Y-m-d'); ?>">
                            <span class="error-message" id="booking-date-error" role="alert"></span>
                        </div>
                        <div class="form-group">
                            <label for="booking-guests">Number of Guests</label>
                            <input type="number" id="booking-guests" name="guests" min="1" value="1" aria-describedby="booking-guests-error">
                            <span class="error-message" id="booking-guests-error" role="alert"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="booking-message">Message</label>
                        <textarea id="booking-message" name="message" rows="4" aria-describedby="booking-message-error"></textarea>
                        <span class="error-message" id="booking-message-error" role="alert"></span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-large">Submit Booking</button>
                    <div class="form-message" id="booking-form-message" role="alert"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- JSON-LD for Home Page -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "TravelAgency",
  "name": "Direction Wise Tourism LLC",
  "description": "Luxury Tours & VIP Travel Experiences in Dubai & Abu Dhabi",
  "url": "<?php echo BASE_URL; ?>",
  "telephone": "+971528492942",
  "email": "info@directionwisetourism.com",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "509, MAKEYA SHARAFI Building, Sharaf DG Metro Station",
    "addressLocality": "Bur Dubai",
    "addressCountry": "AE"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "25.276987",
    "longitude": "55.296249"
  },
  "founder": {
    "@type": "Person",
    "name": "Niranjan Singh Shekhawat",
    "jobTitle": "Licensed UAE Tour Guide"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "reviewCount": "50"
  }
}
</script>

