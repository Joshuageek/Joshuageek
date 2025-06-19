<?php 
include('header.php');

?>
<!-- Hero Section --> 
<section id="hero-section">   
  <div class="container">     
    <div class="row align-items-center">       
      <!-- Content Column -->    
      <div class="col-md-6 content-column">
        <!-- <h1 class="fs-3 fw-bold text-danger">User Role: <?php echo $user_role ?? 'NO ROLE';  ?></h1>
        <h1 class="fs-3 fw-bold text-danger">User Id: <?php echo $user_id ?? 'NO ID';  ?></h1> -->
        <h1>Your Mental Wellness Journey Starts Here</h1>         
        <p class="subtitle"><h4>Connect with licensed therapists in minutes. Accessible, confidential support designed for young adults.</h4></p>                  
        <div class="button-group">           
          <button class="btn btn-primary">             
            <span class="status-dot blinking"></span>             
            Book Session           
          </button>           
          <button class="btn btn-secondary">Get Started</button>         
        </div>                  
        
        <div class="bottom-row">
          <div class="thumbnails-container">
            <p class="sessions-count"></p>
            <div class="thumbnails">           
              <div class="thumbnail-circle"><img src="images/jose.jpg" alt="User" /></div>           
              <div class="thumbnail-circle"><img src="images/3.jpg" alt="User" /></div>           
              <div class="thumbnail-circle"><img src="images/teen1.jpg" alt="User" /></div>
              <div class="thumbnail-circle"><img src="images/teen.jpg" alt="User" /></div>
            </div>
          </div>
        </div>
      </div>        
      
      <!-- Image Column -->       
      <div class="col-md-6 image-column">         
        <div class="image-container">           
          <img src="images/onnneee.jpg" alt="Mental Health Support" class="hero-image">
          
          <!-- Floating badges -->
          <div class="rating-badge">4.9/5             
            <span class="stars">★★★★★</span>                        
          </div>
          
          <div class="info-badge badge-therapists">
            <span class="badge-number">50+</span>
            <span class="badge-text">Licensed Therapists</span>
          </div>
          
          <div class="info-badge badge-support">
            <span class="badge-number">24/7</span>
            <span class="badge-text">Support Access</span>
          </div>
          
          <!-- Decorative contours -->
          <div class="contour contour-1"></div>
          <div class="contour contour-2"></div>
          <div class="contour contour-3"></div>
          <div class="contour contour-4"></div>
          <div class="contour contour-5"></div>
        </div>       
      </div>     
    </div>   
  </div> 
</section>  

<style> 
  #hero-section {   
    padding: 100px 0;   
    background: #F5F7FF;   
    position: relative;   
    overflow: hidden; 
  }  

  .content-column {   
    position: relative;   
    z-index: 2;   
    padding-right: 50px; 
  }  

  h1 {   
    font-size: 2.8rem;   
    color: #A8C3A4;   
    margin-bottom: 25px;   
    line-height: 1.3; 
  }  

  .subtitle {   
    color: #A8C3A4;   
    font-size: 1.1rem;   
    margin-bottom: 35px;   
    line-height: 1.7; 
  }  

  .button-group {   
    display: flex;   
    gap: 15px;   
    margin-bottom: 30px; 
  }  

  .btn {   
    padding: 12px 30px;   
    border-radius: 8px;   
    font-weight: 600;   
    transition: all 0.3s ease;   
    border: 2px solid transparent; 
  }  

  /* Primary button with outline and no fill */
  .btn-primary {   
    background: transparent;   
    color: #A8C3A4;   
    border: 2px solid #A8C3A4;
    display: flex;   
    align-items: center;   
    gap: 10px; 
  }  

  /* Secondary button with fill */
  .btn-secondary {   
    background: #A8C3A4;   
    color: white;
    border-color: #A8C3A4; 
  }  

  .status-dot {   
    width: 10px;   
    height: 10px;   
    background: #4CAF50;   
    border-radius: 50%;   
    display: block; 
  }

  /* Blinking animation for the green dot */
  .blinking {
    animation: blink 1.5s infinite;
  }

  @keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 0.3; }
    100% { opacity: 1; }
  }

  .bottom-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 30px;
  }

  .thumbnails-container {
    display: flex;
    flex-direction: column;
    gap: -10px;
  }

  .sessions-count {   
    color: #5F6C7B;   
    font-size: 0.9rem;   
    margin-bottom: 10px; 
  }  

  .thumbnails {   
    display: flex;   
    position: relative;
    align-items: center;
  }  

  .thumbnail-circle {   
    width: 40px;   
    height: 40px;   
    border-radius: 50%;   
    background: #D1D9FF;   
    border: 2px solid white;   
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-left: -30px; /* Adjusted negative margin */
  }

  .thumbnail-circle:first-child {
    margin-left: 0;
  }

  .thumbnails::after {
    content: "100+ sessions completed this month";
    font-size: 0.9rem;
    color: #5F6C7B;
    margin-left: 15px;
  }

  .thumbnail-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .image-column {   
    position: relative; 
  }  

  .image-container {   
    position: relative;   
    border-radius: 20px;   
    overflow: visible; 
    margin-bottom: 60px; /* Space for badges that extend below */
  }  

  .hero-image {   
    width: 100%;   
    height: 400px;   
    object-fit: cover;   
    border-radius: 20px;   
    position: relative;   
    z-index: 1; 
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
  }  

  /* Badges */
  .rating-badge, .info-badge {   
    position: absolute;
    background: white;   
    padding: 12px 20px;   
    border-radius: 15px;   
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    display: flex;   
    flex-direction: column;
    align-items: center;
    z-index: 3;
    transition: transform 0.3s ease;
  }

  .rating-badge {
    top: -20px;   
    right: -20px;
  }

  .rating-badge:hover, .info-badge:hover {
    transform: translateY(-5px);
  }

  .badge-therapists {
    bottom: -30px;
    left: 30px;
  }

  .badge-support {
    bottom: -30px;
    right: 30px;
  }

  .badge-number {
    font-weight: bold;
    font-size: 1.2rem;
    color: #A8C3A4;
  }

  .badge-text {
    font-size: 0.8rem;
    color: #5F6C7B;
  }

  .stars {   
    color: #A8C3A4;   
    font-size: 0.9rem; 
  }

  /* Decorative contours */
  .contour {
    position: absolute;
    border: 2px solid rgba(76, 175, 80, 0.15);
    border-radius: 35px;
    z-index: 0;
  }

  .contour-1 {
    top: -15px;
    left: -15px;
    right: 25px;
    bottom: 25px;
    border-top-right-radius: 60px;
    border-bottom-left-radius: 100px;
  }

  .contour-2 {
    top: -25px;
    left: -25px;
    right: 40px;
    bottom: 40px;
    border-top-right-radius: 80px;
    border-bottom-left-radius: 120px;
  }

  .contour-3 {
    top: 15px;
    left: 20px;
    right: -15px;
    bottom: -15px;
    border-top-left-radius: 80px;
    border-bottom-right-radius: 50px;
  }

  .contour-4 {
    top: 30px;
    left: 35px;
    right: -25px;
    bottom: -25px;
    border-top-left-radius: 100px;
    border-bottom-right-radius: 70px;
  }

  @media (max-width: 768px) {   
    #hero-section {     
      padding: 60px 0;   
    }      
    
    h1 {     
      font-size: 2rem;   
    }      
    
    .content-column {     
      padding-right: 15px;     
      margin-bottom: 40px;   
    }      
    
    .button-group {     
      flex-direction: column;   
    }      
    
    .hero-image {     
      height: 350px;   
    }      
    
    .bottom-row {
      flex-direction: column;
      align-items: flex-start;
      gap: 20px;
    }

    .rating-badge {
      top: -10px;
      right: -10px;
    }

    .badge-therapists,
    .badge-support {
      padding: 8px 15px;
    }

    .contour {
      display: none;
    }
  } 
</style>

 <!-- Home Menu Section -->
  <section class="section home-hero">
    <div class="hero-space"></div>
    <div class="section_content home-hero-space">
      <h1>
        <span class="exp--10">Space</span>
        <span class="exp--20">to</span>
        <span class="exp--30">figure</span>
        <span class="exp--40">things</span>
        <span class="exp--50">out</span>
      </h1>
      <p>Which category do you relate to?</p>
      <div class="hero-services">
        <a class="hero_service individual" href="#">
          <div class="hero__service-img-wrap">
            <img sizes="(max-width: 558px) 100vw, 558px" src="images/ind.jpg" alt="Individual" loading="lazy" class="hero__service-img">
          </div>
          <h2 class="heading-style-h3-2 margin-bottom margin-small">Individual</h2>
          <p class="margin-bottom margin-xsmall">For ages 18+</p>
          <div class="text-link hero"></div>
        </a>
        <a class="hero_service teens" href="#">
          <div class="hero__service-img-wrap">
            <img sizes="(max-width: 558px) 100vw, 558px" src="images/some.jpg" alt="Teens" loading="lazy" class="hero__service-img">
          </div>
          <h2 class="heading-style-h3-2 margin-bottom margin-small">Teens</h2>
          <p class="margin-bottom margin-xsmall">For ages 13-17</p>
          <div class="text-link hero"></div>
        </a>
        <a class="hero_service couples" href="#">
          <div class="hero__service-img-wrap">
            <img sizes="(max-width: 558px) 100vw, 558px" src="images/couple.jpg" alt="Couples" loading="lazy" class="hero__service-img">
          </div>
          <h2 class="heading-style-h3-2 margin-bottom margin-small">Couples</h2>
          <p class="margin-bottom margin-xsmall">For partnerships</p>
          <div class="text-link hero"></div>
        </a>
        <a class="hero_service medication" href="#">
          <div class="hero__service-img-wrap">
            <img sizes="(max-width: 558px) 100vw, 558px" src="images/med.jpg" alt="Medication" loading="lazy" class="hero__service-img">
          </div>
          <h2 class="heading-style-h3-2 margin-bottom margin-small">Medication</h2>
          <p class="margin-bottom margin-xsmall">Psychiatry &amp; prescriptions</p>
          <div class="text-link hero"></div>
        </a>
      </div>
    </div>
  </section>
  
  <!-- Services Section -->
  <section class="services-section py-5">
    <div class="container">
      <div class="row text-center mb-5">
        <div class="col-12">
          <h2 class="section-title display-4 fw-bold text-primary mb-4">Our Services</h2>
          <p class="lead text-muted">Professional care tailored to your unique needs</p>
        </div>
      </div>
      
      <div class="row g-4">
        <!-- Individual Therapy -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-light text-primary rounded-circle mb-4">
                <i class="fas fa-user-friends fa-2x"></i>
              </div>
              <h3 class="h4 fw-bold mb-3">Individual Therapy</h3>
              <ul class="list-unstyled text-muted">
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Anxiety & depression support
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Stress management
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Trauma recovery
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Relationship guidance
                </li>
              </ul>
            </div>
          </div>
        </div>
  
        <!-- Couples Therapy -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-light text-primary rounded-circle mb-4">
                <i class="fas fa-heart fa-2x"></i>
              </div>
              <h3 class="h4 fw-bold mb-3">Couples Therapy</h3>
              <ul class="list-unstyled text-muted">
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Communication improvement
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Conflict resolution
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Intimacy building
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Flexible session options
                </li>
              </ul>
            </div>
          </div>
        </div>
  
        <!-- Student Support -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-light text-primary rounded-circle mb-4">
                <i class="fas fa-graduation-cap fa-2x"></i>
              </div>
              <h3 class="h4 fw-bold mb-3">Student Support</h3>
              <ul class="list-unstyled text-muted">
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Academic stress management
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Career counseling
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Identity exploration
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Affordable pricing
                </li>
              </ul>
            </div>
          </div>
        </div>
  
        <!-- Work Therapy -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-light text-primary rounded-circle mb-4">
                <i class="fas fa-briefcase fa-2x"></i>
              </div>
              <h3 class="h4 fw-bold mb-3">Work Therapy</h3>
              <ul class="list-unstyled text-muted">
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Workplace stress management
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Professional relationship coaching
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Work-life balance
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Career transitions
                </li>
              </ul>
            </div>
          </div>
        </div>
  
        <!-- Postpartum Support -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-light text-primary rounded-circle mb-4">
                <i class="fas fa-baby fa-2x"></i>
              </div>
              <h3 class="h4 fw-bold mb-3">Postpartum Support</h3>
              <ul class="list-unstyled text-muted">
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Postpartum depression support
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Emotional adjustment
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Coping strategies
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  New parent counseling
                </li>
              </ul>
            </div>
          </div>
        </div>
  
        <!-- Corporate Wellness -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-light text-primary rounded-circle mb-4">
                <i class="fas fa-building fa-2x"></i>
              </div>
              <h3 class="h4 fw-bold mb-3">Corporate Wellness</h3>
              <ul class="list-unstyled text-muted">
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Employee wellness programs
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Stress management workshops
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Team building exercises
                </li>
                <li class="mb-2 d-flex">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  Leadership coaching
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <style>
    .services-section {
      background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    }
    
    .icon-box {
      width: 70px;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .hover-shadow {
      transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .hover-shadow:hover {
      transform: translateY(-5px);
      box-shadow: 0 1rem 3rem rgba(0,0,0,.1)!important;
    }
    
    .bg-primary-light {
      background-color: rgba(13,110,253,0.1);
    }
    
    .text-primary {
      color: #A8C3A4!important;
    }
  </style>
  
  <!-- Include Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <section class="compare-section">
    <div class="container">
      <h2>Luna vs. In-person therapy</h2>
      <table class="compare-table">
        <thead>
          <tr>
            <th></th>
            <th>Luna</th>
            <th>In-person Therapy</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="feature-name">Flexible Scheduling</td>
            <td><div class="check-circle"><i class="fa fa-check check"></i></div></td>
            <td><div class="check-circle"><i class="fa fa-times x-mark"></i></div></td>
          </tr>
          <tr>
            <td class="feature-name">Convenient, on-your-time options</td>
            <td><div class="check-circle"><i class="fa fa-check check"></i></div></td>
            <td><div class="check-circle"><i class="fa fa-times x-mark"></i></div></td>
          </tr>
          <tr>
            <td class="feature-name">Affordable subscriptions</td>
            <td><div class="check-circle"><i class="fa fa-check check"></i></div></td>
            <td><div class="check-circle"><i class="fa fa-times x-mark"></i></div></td>
          </tr>
          <tr>
            <td class="feature-name">Privacy</td>
            <td><div class="check-circle"><i class="fa fa-check check"></i></div></td>
            <td><div class="check-circle"><i class="fa fa-times x-mark"></i></div></td>
          </tr>
          <tr>
            <td class="feature-name">Diverse licensed therapists</td>
            <td><div class="check-circle"><i class="fa fa-check check"></i></div></td>
            <td><div class="check-circle"><i class="fa fa-check check"></i></div></td>
          </tr>
          <tr>
            <td class="feature-name">Video, text, and audio options</td>
            <td><div class="check-circle"><i class="fa fa-check check"></i></div></td>
            <td><div class="check-circle"><i class="fa fa-times x-mark"></i></div></td>
          </tr>
          <tr>
            <td class="feature-name">No commute or waiting</td>
            <td><div class="check-circle"><i class="fa fa-check check"></i></div></td>
            <td><div class="check-circle"><i class="fa fa-times x-mark"></i></div></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
  
 
<!-- How It Works Section -->
<section class="section-white small-padding-bottom">
  <div class="container">
    <div class="row margin-bottom-40">
      <div class="col-md-12 text-center">
        <div class="text-center">
          <span class="comic-text wow fadeIn"></span>
          <h1 class="section-title wow bounceIn">How Luna works</h1>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 wow bounceInUp">
        <div class="blog-item">
          <div class="popup-wrapper">
            <div class="popup-gallery">
              <a href="#" class="blog-item-pic"><span class="eye-wrapper"><i class="pe-7s-link eye-icon"></i></span></a>
            </div>
          </div>
          <div class="blog-item-inner">
            <h3 class="blog-title"><a href="#">Match with a Therapist</a></h3>
            <p>Answer a few quick questions about your healthcare needs, and we’ll connect you to a qualified therapist who fits your preferences.</p>
            <a href="questionnaire.html" class="btn btn-lg btn-yellow-small scrool">Questionnaire</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 wow bounceInUp">
        <div class="blog-item">
          <div class="popup-wrapper">
            <div class="popup-gallery">
              <a href="#" class="blog-item-pic"><span class="eye-wrapper"><i class="pe-7s-link eye-icon"></i></span></a>
            </div>
          </div>
          <div class="blog-item-inner">
            <h3 class="blog-title"><a href="#">Schedule Your Appointment</a></h3>
            <p>Easily book your session, choose your appointments at a time that works for you.</p>
            <a href="booking.html" class="btn btn-lg btn-yellow-small scrool">Book</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 wow bounceInUp">
        <div class="blog-item">
          <div class="popup-wrapper">
            <div class="popup-gallery">
              <a href="#" class="blog-item-pic"><span class="eye-wrapper"><i class="pe-7s-link eye-icon"></i></span></a>
            </div>
          </div>
          <div class="blog-item-inner">
            <h3 class="blog-title"><a href="#">Get Started</a></h3>
            <p>Join your appointment through a secure link. Get personalized care and ongoing support tailored to your needs.</p>
            <a href="#" class="btn btn-lg btn-yellow-small scrool">Get Started</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>  


<!--begin testimonial section -->
<section class="section-white no-padding-bottom">
  <div class="container">
      <div class="row">
          <div class="col-md-12 text-center">
              <div class="text-center">
                  <span class="comic-text">Testimonies</span>
                  <h1 class="section-title no-margin">WHAT OUR CLIENTS HAVE TO SAY</h1>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-12 text-center">
              <div id="rev_slider_108_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container">
                  <div id="rev_slider_108_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.0.7">
                      <ul>
                          <!-- TESTIMONY CARD 1 -->
                          <li data-index="rs-326" data-transition="fade" data-slotamount="7" data-easein="default" data-easeout="default" data-masterspeed="300">
                              <div class="testimonial-card">
                                  <div class="quote-icon">"</div>
                                  <p class="testimonial-text">As an introvert, the idea of getting mental health support from the comfort of my room makes me feel seen. I'm really looking forward to this.</p>
                                  <div class="testimonial-author">
                                      <h4>Brian K.</h4>
                                      <p>Wakiso</p>
                                  </div>
                              </div>
                          </li>

                          <!-- TESTIMONY CARD 2 -->
                          <li data-index="rs-327" data-transition="fade" data-slotamount="7" data-easein="default" data-easeout="default" data-masterspeed="300">
                              <div class="testimonial-card">
                                  <div class="quote-icon">"</div>
                                  <p class="testimonial-text">After having my baby, I went through a lot emotionally, but I didn't know where to turn. Speaking to a therapist without leaving the house makes me feel less alone.</p>
                                  <div class="testimonial-author">
                                      <h4>Diana K.</h4>
                                      <p>Kampala</p>
                                  </div>
                              </div>
                          </li>

                          <!-- TESTIMONY CARD 3 -->
                          <li data-index="rs-328" data-transition="fade" data-slotamount="7" data-easein="default" data-easeout="default" data-masterspeed="300">
                              <div class="testimonial-card">
                                  <div class="quote-icon">"</div>
                                  <p class="testimonial-text">As a student, it's hard to find affordable therapy. I can't wait for an option that's both easy to access and doesn't break the bank.</p>
                                  <div class="testimonial-author">
                                      <h4>Joel A.</h4>
                                      <p>Makerere University</p>
                                  </div>
                              </div>
                          </li>

                          <!-- TESTIMONY CARD 4 -->
                          <li data-index="rs-329" data-transition="fade" data-slotamount="7" data-easein="default" data-easeout="default" data-masterspeed="300">
                              <div class="testimonial-card">
                                  <div class="quote-icon">"</div>
                                  <p class="testimonial-text">Sometimes it's hard to find someone to talk to, especially when you're far from the city. Being able to get help without traveling miles would make such a difference.</p>
                                  <div class="testimonial-author">
                                      <h4>Roland, M</h4>
                                      <p>MUBS University Student</p>
                                  </div>
                              </div>
                          </li>

                          <!-- TESTIMONY CARD 5 -->
                          <li data-index="rs-330" data-transition="fade" data-slotamount="7" data-easein="default" data-easeout="default" data-masterspeed="300">
                              <div class="testimonial-card">
                                  <div class="quote-icon">"</div>
                                  <p class="testimonial-text">The convenience of telemedicine is a game changer. It means quicker access to mental healthcare for my family.</p>
                                  <div class="testimonial-author">
                                      <h4>Rebecca N</h4>
                                      <p>Entebbe</p>
                                  </div>
                              </div>
                          </li>

                          <!-- TESTIMONY CARD 6 -->
                          <li data-index="rs-331" data-transition="fade" data-slotamount="7" data-easein="default" data-easeout="default" data-masterspeed="300">
                              <div class="testimonial-card">
                                  <div class="quote-icon">"</div>
                                  <p class="testimonial-text">The idea that Luna Health could bring help straight to us, no matter where we are, is really comforting.</p>
                                  <div class="testimonial-author">
                                      <h4>Kenneth M</h4>
                                      <p>Bugolobi</p>
                                  </div>
                              </div>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<!--end testimonial section -->

<style>
  /* Testimonials Section Styling */
  .section-white {
    background: #fff;
    padding: 60px 0;
  }

  .comic-text {
    font-family: 'Montserrat', sans-serif;
    font-size: 10px;
    font-weight: 500;
    color: #A8C3A4;
    display: block;
    margin-bottom: 15px;
  }

  .section-title {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 60px; /* Increased spacing between title and cards */
    color: #2D3436;
    text-transform: uppercase;
  }

  /* Testimonial Cards */
  .testimonial-card {
    background: #FFFFFF;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 30px;
    width: 100%;
    max-width: 420px;
    height: 420px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    margin: 0 auto;
  }

  .testimonial-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background-color: #A8C3A4;
  }

  .quote-icon {
    font-size: 48px;
    color: #A8C3A4;
    line-height: 0.8;
    margin-bottom: 20px;
  }

  .testimonial-text {
    font-size: 16px;
    line-height: 1.6;
    color: #636E72;
    margin-bottom: 25px;
  }

  .testimonial-author h4 {
    font-size: 18px;
    margin: 0 0 5px 0;
    color: #2D3436;
  }

  .testimonial-author p {
    font-size: 14px;
    color: #828282;
    margin: 0;
  }

  /* Remove Revolution Slider Thumbnails */
  .tp-thumbs {
    display: none !important;
  }

  /* Adjust Revolution Slider Container */
  .rev_slider_wrapper {
    margin-top: 0 !important;
    margin-bottom: 0 !important;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .testimonial-card {
        width: 100%;
        height: auto;
        min-height: 300px;
        padding: 20px;
    }
    
    .testimonial-text {
        font-size: 14px;
    }
    
    .section-title {
        font-size: 24px;
    }
  }
</style>



<?php include('footer.php');?>