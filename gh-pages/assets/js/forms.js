/**
 * Form Handling
 * Handles booking and contact form submissions
 */

(function() {
    'use strict';

    // Booking Form Handler
    const bookingForm = document.getElementById('booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', handleBookingSubmit);
    }

    // Contact Form Handler
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactSubmit);
    }

    /**
     * Handle booking form submission
     */
    async function handleBookingSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Convert to JSON
        const jsonData = {
            name: data.name,
            email: data.email,
            phone: data.phone,
            tour_id: data.tour_id || null,
            date: data.date,
            guests: parseInt(data.guests) || 1,
            message: data.message || ''
        };

        // Clear previous errors
        clearFormErrors(form);
        
        // Validate
        const errors = validateBookingData(jsonData);
        if (Object.keys(errors).length > 0) {
            showFormErrors(form, errors);
            return;
        }

        // Disable submit button
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';

        try {
            const response = await fetch('/api/book', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(jsonData)
            });

            const result = await response.json();

            if (response.ok && result.success) {
                showFormSuccess(form, result.message || 'Booking submitted successfully! We will contact you soon.');
                form.reset();
            } else {
                showFormError(form, result.message || 'An error occurred. Please try again.');
                if (result.errors) {
                    showFormErrors(form, result.errors);
                }
            }
        } catch (error) {
            console.error('Booking error:', error);
            showFormError(form, 'Network error. Please check your connection and try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    }

    /**
     * Handle contact form submission
     */
    async function handleContactSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        
        // Clear previous errors
        clearFormErrors(form);
        
        // Validate
        const data = Object.fromEntries(formData);
        const errors = validateContactData(data);
        if (Object.keys(errors).length > 0) {
            showFormErrors(form, errors);
            return;
        }

        // Disable submit button
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';

        try {
            const response = await fetch('/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(formData)
            });

            const result = await response.json();

            if (response.ok && result.success) {
                showFormSuccess(form, result.message || 'Message sent successfully! We will get back to you soon.');
                form.reset();
            } else {
                showFormError(form, result.message || 'An error occurred. Please try again.');
                if (result.errors) {
                    showFormErrors(form, result.errors);
                }
            }
        } catch (error) {
            console.error('Contact form error:', error);
            showFormError(form, 'Network error. Please check your connection and try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    }

    /**
     * Validate booking data
     */
    function validateBookingData(data) {
        const errors = {};

        if (!data.name || data.name.trim().length < 2) {
            errors.name = 'Name must be at least 2 characters';
        }

        if (!data.email || !isValidEmail(data.email)) {
            errors.email = 'Valid email is required';
        }

        if (!data.phone || data.phone.trim().length < 10) {
            errors.phone = 'Valid phone number is required';
        }

        if (!data.date) {
            errors.date = 'Date is required';
        } else {
            const selectedDate = new Date(data.date);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (selectedDate < today) {
                errors.date = 'Date must be in the future';
            }
        }

        if (data.guests && (isNaN(data.guests) || data.guests < 1)) {
            errors.guests = 'Number of guests must be at least 1';
        }

        return errors;
    }

    /**
     * Validate contact data
     */
    function validateContactData(data) {
        const errors = {};

        if (!data.name || data.name.trim().length < 2) {
            errors.name = 'Name must be at least 2 characters';
        }

        if (!data.email || !isValidEmail(data.email)) {
            errors.email = 'Valid email is required';
        }

        if (!data.message || data.message.trim().length < 10) {
            errors.message = 'Message must be at least 10 characters';
        }

        return errors;
    }

    /**
     * Validate email format
     */
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    /**
     * Show form errors
     */
    function showFormErrors(form, errors) {
        Object.keys(errors).forEach(field => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                const errorId = input.getAttribute('aria-describedby');
                const errorElement = errorId ? document.getElementById(errorId) : null;
                
                if (errorElement) {
                    errorElement.textContent = errors[field];
                    errorElement.style.display = 'block';
                }
                
                input.setAttribute('aria-invalid', 'true');
                input.classList.add('error');
            }
        });
    }

    /**
     * Clear form errors
     */
    function clearFormErrors(form) {
        const errorMessages = form.querySelectorAll('.error-message');
        errorMessages.forEach(el => {
            el.textContent = '';
            el.style.display = 'none';
        });

        const inputs = form.querySelectorAll('[aria-invalid="true"]');
        inputs.forEach(input => {
            input.removeAttribute('aria-invalid');
            input.classList.remove('error');
        });

        const messageEl = form.querySelector('.form-message');
        if (messageEl) {
            messageEl.style.display = 'none';
            messageEl.className = 'form-message';
        }
    }

    /**
     * Show form success message
     */
    function showFormSuccess(form, message) {
        const messageEl = form.querySelector('.form-message') || createMessageElement(form);
        messageEl.textContent = message;
        messageEl.className = 'form-message success';
        messageEl.style.display = 'block';
        messageEl.setAttribute('role', 'status');
        
        // Scroll to message
        messageEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /**
     * Show form error message
     */
    function showFormError(form, message) {
        const messageEl = form.querySelector('.form-message') || createMessageElement(form);
        messageEl.textContent = message;
        messageEl.className = 'form-message error';
        messageEl.style.display = 'block';
        messageEl.setAttribute('role', 'alert');
        
        // Scroll to message
        messageEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /**
     * Create message element if it doesn't exist
     */
    function createMessageElement(form) {
        const messageEl = document.createElement('div');
        messageEl.className = 'form-message';
        messageEl.id = form.id + '-message';
        form.appendChild(messageEl);
        return messageEl;
    }

    // Real-time validation
    document.querySelectorAll('input, textarea, select').forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            if (this.hasAttribute('aria-invalid')) {
                validateField(this);
            }
        });
    });

    /**
     * Validate individual field
     */
    function validateField(field) {
        const value = field.value.trim();
        let error = '';

        if (field.hasAttribute('required') && !value) {
            error = 'This field is required';
        } else if (field.type === 'email' && value && !isValidEmail(value)) {
            error = 'Please enter a valid email address';
        } else if (field.type === 'tel' && value && value.length < 10) {
            error = 'Please enter a valid phone number';
        } else if (field.type === 'date' && value) {
            const selectedDate = new Date(value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (selectedDate < today) {
                error = 'Date must be in the future';
            }
        }

        const errorId = field.getAttribute('aria-describedby');
        const errorElement = errorId ? document.getElementById(errorId) : null;

        if (error) {
            if (errorElement) {
                errorElement.textContent = error;
                errorElement.style.display = 'block';
            }
            field.setAttribute('aria-invalid', 'true');
            field.classList.add('error');
        } else {
            if (errorElement) {
                errorElement.textContent = '';
                errorElement.style.display = 'none';
            }
            field.removeAttribute('aria-invalid');
            field.classList.remove('error');
        }
    }
})();

