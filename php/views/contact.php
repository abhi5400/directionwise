<?php
/**
 * Contact Page View
 */
?>

<section class="section contact-page">
    <div class="container">
        <div class="section-header">
            <h1>Contact Us</h1>
            <p>Get in touch with us to plan your perfect Dubai and Abu Dhabi experience</p>
        </div>

        <div class="contact-grid">
            <div class="contact-info">
                <h2>Contact Information</h2>
                <div class="contact-details">
                    <div class="contact-item">
                        <h3>Phone</h3>
                        <p><a href="tel:+971528492942">+971 52 849 2942</a></p>
                    </div>
                    <div class="contact-item">
                        <h3>Email</h3>
                        <p><a href="mailto:info@directionwisetourism.com">info@directionwisetourism.com</a></p>
                    </div>
                    <div class="contact-item">
                        <h3>Office Address</h3>
                        <address>
                            509, MAKEYA SHARAFI Building<br>
                            Sharaf DG Metro Station<br>
                            Bur Dubai, UAE
                        </address>
                    </div>
                    <div class="contact-item">
                        <h3>Business Hours</h3>
                        <p>Monday - Sunday: 9:00 AM - 6:00 PM (GST)</p>
                    </div>
                </div>
            </div>

            <div class="contact-form-wrapper" id="booking">
                <h2>Send Us a Message</h2>
                <form id="contact-form" class="contact-form" novalidate>
                    <div class="form-group">
                        <label for="contact-name">Full Name *</label>
                        <input type="text" id="contact-name" name="name" required aria-required="true" aria-describedby="contact-name-error">
                        <span class="error-message" id="contact-name-error" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label for="contact-email">Email *</label>
                        <input type="email" id="contact-email" name="email" required aria-required="true" aria-describedby="contact-email-error">
                        <span class="error-message" id="contact-email-error" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label for="contact-phone">Phone</label>
                        <input type="tel" id="contact-phone" name="phone" aria-describedby="contact-phone-error">
                        <span class="error-message" id="contact-phone-error" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label for="contact-message">Message *</label>
                        <textarea id="contact-message" name="message" rows="6" required aria-required="true" aria-describedby="contact-message-error"></textarea>
                        <span class="error-message" id="contact-message-error" role="alert"></span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-large">Send Message</button>
                    <div class="form-message" id="contact-form-message" role="alert"></div>
                </form>
            </div>
        </div>

        <div class="map-container">
            <h2>Find Us</h2>
            <div id="map" class="map" role="img" aria-label="Map showing Direction Wise Tourism office location in Bur Dubai">
                <!-- Map will be loaded via JavaScript for better performance -->
                <p>Loading map...</p>
            </div>
        </div>
    </div>
</section>

