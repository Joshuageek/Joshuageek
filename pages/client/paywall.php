<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Therapeutic Services | Professional Mental Health Support</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c5f5d;
            --primary-light: #4a8b87;
            --secondary-color: #7fb069;
            --accent-color: #d4a574;
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --text-muted: #718096;
            --bg-primary: #f8f9fa;
            --bg-white: #ffffff;
            --border-light: #e2e8f0;
            --success-color: #48bb78;
            --shadow-soft: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .serif-font {
            font-family: 'Playfair Display', serif;
        }

        /* Header Section */
        .header-section {
            background-color: var(--bg-white);
            padding: 4rem 0 3rem;
            border-bottom: 1px solid var(--border-light);
        }

        .btn-home {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .btn-home:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .main-title {
            font-size: 2.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .main-subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
            max-width: 700px;
            margin: 0 auto 2rem;
            line-height: 1.7;
        }

        /* Trust Indicators */
        .trust-bar {
            background: var(--bg-white);
            padding: 1.25rem 0;
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
        }

        .trust-item {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            letter-spacing: 0.3px;
        }

        .trust-item i {
            color: var(--success-color);
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        /* Pricing Cards */
        .pricing-section {
            padding: 4rem 0;
        }

        .service-card {
            background: var(--bg-white);
            border: 1px solid var(--border-light);
            border-radius: 8px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .service-card:hover {
            box-shadow: var(--shadow-medium);
            transform: translateY(-3px);
        }

        .service-card.recommended {
            border-top: 3px solid var(--primary-color);
        }

        .recommended-badge {
            position: absolute;
            top: 7px;
            right: 15px;
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .service-header {
            text-align: center;
            padding: 2rem 1.5rem 1.5rem;
            border-bottom: 1px solid var(--border-light);
        }

        .service-type {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
            letter-spacing: 0.3px;
        }

        .service-description {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .price-display {
            margin-bottom: 1rem;
        }

        .price-amount {
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .price-currency {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-muted);
            vertical-align: top;
        }

        .price-period {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .service-details {
            padding: 1.5rem;
        }

        .detail-section {
            margin-bottom: 1.5rem;
        }

        .detail-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .detail-list li {
            padding: 0.5rem 0;
            color: var(--text-secondary);
            display: flex;
            align-items: flex-start;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .detail-list li i {
            color: var(--success-color);
            margin-right: 0.75rem;
            margin-top: 0.2rem;
            flex-shrink: 0;
            font-size: 0.9rem;
        }

        .btn-select {
            background-color: var(--primary-color);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
        }

        .btn-select:hover {
            background-color: var(--primary-light);
            color: white;
        }

        .btn-select.secondary {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-select.secondary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Information Section */
        .info-section {
            background: var(--bg-white);
            padding: 3rem 0;
            border-top: 1px solid var(--border-light);
        }

        .info-card {
            text-align: center;
            padding: 1.5rem;
        }

        .info-icon {
            width: 48px;
            height: 48px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.25rem;
        }

        .info-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .info-text {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.6;
        }

        /* Footer */
        .footer-section {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0;
            font-size: 0.85rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
            margin-right: 1rem;
        }

        .footer-links a:hover {
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-title {
                font-size: 1.75rem;
            }
            
            .main-subtitle {
                font-size: 1rem;
            }
            
            .trust-item {
                margin-bottom: 0.75rem;
                justify-content: flex-start;
            }
            
            .service-card {
                margin-bottom: 1.5rem;
            }
            
            .info-card {
                margin-bottom: 1.5rem;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <section class="header-section fade-in">
        <div class="container">
            <div class="text-center">
                <div class="mb-4">
                    <a href="./index.php" class="btn-home">
                        <i class="bi bi-arrow-left me-2"></i>Return to Home
                    </a>
                </div>
                <h1 class="main-title serif-font">Therapeutic Services</h1>
                <p class="main-subtitle">
                    Professional mental health support tailored to your needs. Our licensed therapists provide evidence-based care through multiple modalities to suit your preferences and lifestyle.
                </p>
            </div>
        </div>
    </section>

    <!-- Trust Bar -->
    <section class="trust-bar fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="trust-item">
                        <i class="bi bi-shield-check"></i>
                        HIPAA Compliant
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="trust-item">
                        <i class="bi bi-award"></i>
                        Licensed Professionals
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="trust-item">
                        <i class="bi bi-lock"></i>
                        Secure Platform
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="trust-item">
                        <i class="bi bi-people"></i>
                        Client-Centered
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="container">
            <div class="row justify-content-center g-4">
                <!-- Text-Based Therapy -->
                <div class="col-lg-4 col-md-6">
                    <div class="service-card fade-in">
                        <div class="service-header">
                            <h3 class="service-type">Text Therapy</h3>
                            <p class="service-description">
                                Asynchronous messaging with your therapist for thoughtful, written communication
                            </p>
                            <div class="price-display">
                                <span class="price-currency">UGX</span>
                                <span class="price-amount">100,000</span>
                            </div>
                            <p class="price-period">per month</p>
                        </div>
                        
                        <div class="service-details">
                            <div class="detail-section">
                                <h6 class="detail-title">Session Details</h6>
                                <ul class="detail-list">
                                    <li><i class="bi bi-check-circle"></i>4 therapeutic exchanges</li>
                                    <li><i class="bi bi-check-circle"></i>40 minutes per session</li>
                                    <li><i class="bi bi-check-circle"></i>Secure messaging platform</li>
                                </ul>
                            </div>
                            
                            <div class="detail-section">
                                <h6 class="detail-title">Included Features</h6>
                                <ul class="detail-list">
                                    <li><i class="bi bi-check-circle"></i>Session transcripts</li>
                                    <li><i class="bi bi-check-circle"></i>Between-session messaging</li>
                                    <li><i class="bi bi-check-circle"></i>Progress tracking</li>
                                </ul>
                            </div>
                            
                            <button class="btn-select secondary mt-3">Select Text Therapy</button>
                        </div>
                    </div>
                </div>

                <!-- Voice Therapy (Recommended) -->
                <div class="col-lg-4 col-md-6">
                    <div class="service-card recommended fade-in" style="animation-delay: 0.2s;">
                        <div class="recommended-badge">Recommended</div>
                        <div class="service-header">
                            <h3 class="service-type">Voice Therapy</h3>
                            <p class="service-description">
                                Real-time audio sessions providing immediate therapeutic interaction
                            </p>
                            <div class="price-display">
                                <span class="price-currency">UGX</span>
                                <span class="price-amount">200,000</span>
                            </div>
                            <p class="price-period">per month</p>
                        </div>
                        
                        <div class="service-details">
                            <div class="detail-section">
                                <h6 class="detail-title">Session Details</h6>
                                <ul class="detail-list">
                                    <li><i class="bi bi-check-circle"></i>4 scheduled sessions</li>
                                    <li><i class="bi bi-check-circle"></i>30 minutes per session</li>
                                    <li><i class="bi bi-check-circle"></i>Encrypted voice calls</li>
                                </ul>
                            </div>
                            
                            <div class="detail-section">
                                <h6 class="detail-title">Included Features</h6>
                                <ul class="detail-list">
                                    <li><i class="bi bi-check-circle"></i>Session recordings</li>
                                    <li><i class="bi bi-check-circle"></i>Priority scheduling</li>
                                    <li><i class="bi bi-check-circle"></i>Crisis support</li>
                                    <li><i class="bi bi-check-circle"></i>Therapeutic resources</li>
                                </ul>
                            </div>
                            
                            <button class="btn-select mt-3">Select Voice Therapy</button>
                        </div>
                    </div>
                </div>

                <!-- Video Therapy -->
                <div class="col-lg-4 col-md-6">
                    <div class="service-card fade-in" style="animation-delay: 0.4s;">
                        <div class="service-header">
                            <h3 class="service-type">Video Therapy</h3>
                            <p class="service-description">
                                Face-to-face virtual sessions for comprehensive therapeutic engagement
                            </p>
                            <div class="price-display">
                                <span class="price-currency">UGX</span>
                                <span class="price-amount">300,000</span>
                            </div>
                            <p class="price-period">per month</p>
                        </div>
                        
                        <div class="service-details">
                            <div class="detail-section">
                                <h6 class="detail-title">Session Details</h6>
                                <ul class="detail-list">
                                    <li><i class="bi bi-check-circle"></i>4 scheduled sessions</li>
                                    <li><i class="bi bi-check-circle"></i>30 minutes per session</li>
                                    <li><i class="bi bi-check-circle"></i>Secure video platform</li>
                                </ul>
                            </div>
                            
                            <div class="detail-section">
                                <h6 class="detail-title">Included Features</h6>
                                <ul class="detail-list">
                                    <li><i class="bi bi-check-circle"></i>Screen sharing</li>
                                    <li><i class="bi bi-check-circle"></i>Flexible scheduling</li>
                                    <li><i class="bi bi-check-circle"></i>Personalized plans</li>
                                    <li><i class="bi bi-check-circle"></i>24/7 support</li>
                                    <li><i class="bi bi-check-circle"></i>Family sessions</li>
                                </ul>
                            </div>
                            
                            <button class="btn-select secondary mt-3">Select Video Therapy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Section -->
    <section class="info-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-card fade-in">
                        <div class="info-icon">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <h5 class="info-title">Evidence-Based Practice</h5>
                        <p class="info-text">Our therapists utilize clinically validated approaches including CBT, DBT, and psychodynamic therapy.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card fade-in" style="animation-delay: 0.2s;">
                        <div class="info-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h5 class="info-title">Flexible Scheduling</h5>
                        <p class="info-text">Book sessions at times that accommodate your schedule, including early mornings and evenings.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card fade-in" style="animation-delay: 0.4s;">
                        <div class="info-icon">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h5 class="info-title">Client Autonomy</h5>
                        <p class="info-text">Modify or discontinue services at any time. Your therapeutic journey remains under your control.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-3">© 2023 Therapeutic Services. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="footer-links">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms of Service</a>
                        <a href="#">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Professional interaction handling
        document.querySelectorAll('.btn-select').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const serviceType = this.closest('.service-card').querySelector('.service-type').textContent;
                const button = this;
                
                // Show loading state
                const originalText = button.innerHTML;
                button.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing';
                button.disabled = true;
                
                // Simulate processing delay
                setTimeout(() => {
                    // In a real implementation, this would redirect to a payment/registration page
                    console.log(`Selected service: ${serviceType}`);
                    
                    // Reset button state
                    button.innerHTML = originalText;
                    button.disabled = false;
                    
                    // Show confirmation modal
                    const modalHtml = `
                        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title fw-bold">Service Selected</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>You've selected our <b class="text-success">${serviceType}</b> service. You will now be redirected to your <b>admin account</b> for your first session.</p>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                        <a href="./admin/" type="button" class="btn btn-sm btn-primary">Continue to Admin Account</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Inject modal into DOM
                    document.body.insertAdjacentHTML('beforeend', modalHtml);
                    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                    modal.show();
                    
                    // Remove modal from DOM after it's hidden
                    document.getElementById('confirmationModal').addEventListener('hidden.bs.modal', function() {
                        this.remove();
                    });
                    
                }, 1500);
            });
        });
    </script>
</body>
</html>