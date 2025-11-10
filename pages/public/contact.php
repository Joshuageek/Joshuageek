<?php
include(__DIR__ . '/../../includes/layouts/header.php');
?>

    <style>
        /* Improved Contact Page Styles */
        .contact-hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('images/1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 60vh;
            display: flex;
            align-items: center;
        }

        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: -80px;
            position: relative;
            z-index: 2;
        }

        .contact-card {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
        }

        .contact-info-card {
            background: #f8f9fa;
        }

        .contact-icon {
            font-size: 2.5rem;
            color: #42b983;
            margin-bottom: 20px;
        }

        .contact-form .form-group {
            margin-bottom: 20px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 5px;
            transition: border 0.3s ease;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #42b983;
            outline: none;
        }

        .contact-form textarea {
            min-height: 150px;
            resize: vertical;
        }

        .submit-btn {
            background: #42b983;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
            width: 100%;
        }

        .submit-btn:hover {
            background: #3aa876;
        }

        .map-container {
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .hours-list {
            list-style: none;
            padding: 0;
        }

        .hours-list li {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
                margin-top: 30px;
            }

            .contact-hero-section {
                min-height: 40vh;
                background-attachment: scroll;
            }
        }
    </style>

    <!-- Hero Section -->
    <section class="contact-hero-section">
        <div class="container text-center">
            <h1 class="section-title white wow fadeInDown">Get In Touch</h1>
            <p class="hero-text wow fadeInUp" data-wow-delay="0.3s">We'd love to hear from you. Reach out for questions, support, or just to say hello!</p>
        </div>
    </section>

    <!-- Main Contact Content -->
    <div class="contact-container">
        <div class="contact-grid">
            <!-- Contact Information Card -->
            <div class="contact-card contact-info-card wow fadeInLeft">
                <div class="contact-icon">
                    <i class="fa fa-info-circle"></i>
                </div>
                <h3>Contact Information</h3>
                <div class="contact-details">
                    <p><i class="fa fa-map-marker"></i> 123 Wellness Way, Suite 200<br>San Francisco, CA 94107</p>
                    <p><i class="fa fa-phone"></i> (415) 555-0199</p>
                    <p><i class="fa fa-envelope"></i> support@yourtherapy.com</p>
                </div>

                <h4 class="mt-4">Business Hours</h4>
                <ul class="hours-list">
                    <li><span>Monday - Friday</span> <span>9:00 AM - 6:00 PM</span></li>
                    <li><span>Saturday</span> <span>10:00 AM - 4:00 PM</span></li>
                    <li><span>Sunday</span> <span>Closed</span></li>
                </ul>

                <div class="social-links mt-4">
                    <a href="#" class="social-icon"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fa fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fa fa-linkedin"></i></a>
                </div>
            </div>

            <!-- Contact Form Card -->
            <div class="contact-card wow fadeInRight">
                <h3>Send Us a Message</h3>
                <p>Fill out the form below and we'll respond within 24 hours</p>

                <!-- Success Message (hidden by default) -->
                <div class="alert alert-success contact_success_box" style="display:none;">
                    Thank you! Your message has been sent successfully.
                </div>

                <form id="contact-form" class="contact-form" action="php/contact.php" method="post">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name*" required>
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" placeholder="Your Email*" required>
                    </div>

                    <div class="form-group">
                        <input type="tel" name="phone" placeholder="Phone Number">
                    </div>

                    <div class="form-group">
                        <select name="subject" class="form-control" required>
                            <option value="" disabled selected>Select Subject*</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="Appointment">Appointment Request</option>
                            <option value="Support">Technical Support</option>
                            <option value="Feedback">Feedback</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <textarea name="message" placeholder="Your Message*" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-container wow fadeInUp" data-wow-delay="0.3s">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.234814298456!2d-122.4194156846822!3d37.77492997975922!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80859a6d00690021%3A0x4a501367f076adff!2sSan+Francisco%2C+CA%2C+USA!5e0!3m2!1sen!2sng!4v1561592631815!5m2!1sen!2sng"
                    width="100%"
                    height="100%"
                    frameborder="0"
                    style="border:0"
                    allowfullscreen>
            </iframe>
        </div>
    </div>

<?php include(__DIR__ . '/../../includes/layouts/footer.php'); ?>