<?php include(__DIR__ . '/../../includes/layouts/header.php');?>

  <style>
    
    /* Hero Section */
    #hero-section {
      background-color: #F5F7FF;
      padding: 120px 0 80px;
      text-align: center;
    }
    
    .hero-content h1 {
      font-size: 2.8rem;
      color: #A8C3A4;
      margin-bottom: 20px;
    }
    
    .hero-content p {
      font-size: 1.1rem;
      color: #5F6C7B;
      max-width: 700px;
      margin: 0 auto 30px;
    }
    
    .btn {
      display: inline-block;
      padding: 12px 30px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s;
      margin: 5px;
    }
    
    .btn-primary {
      background-color: #A8C3A4;
      color: white;
    }
    
    .btn-secondary {
      background-color: transparent;
      color: #A8C3A4;
      border: 2px solid #A8C3A4;
    }
    
    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    /* Benefits Section */
    .benefits-section {
      padding: 80px 0;
      background-color: #fff;
    }
    
    .section-title {
      text-align: center;
      margin-bottom: 50px;
      font-size: 2.2rem;
      color: #333;
    }
    
    .benefits-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
    }
    
    .benefit-card {
      background: #f9f9f9;
      border-radius: 10px;
      padding: 30px;
      text-align: center;
      transition: transform 0.3s;
    }
    
    .benefit-card:hover {
      transform: translateY(-5px);
    }
    
    .benefit-card i {
      font-size: 2.5rem;
      color: #A8C3A4;
      margin-bottom: 20px;
    }
    
    .benefit-card h3 {
      margin-bottom: 15px;
      color: #333;
    }
    
    /* Earnings Section */
    .earnings-section {
      padding: 10px 0;
      background-color: #f5f5f5;
    }
    
    .earnings-card {
      background: white;
      border-radius: 10px;
      padding: 60px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      text-align: center;
      max-width: 700px;
      margin: 0 auto;
    }
    
    .earnings-card h2 {
      font-size: 2.5rem;
      color: #A8C3A4;
      margin-bottom: 20px;
    }
    
    .earnings-card p {
      margin-bottom: 30px;
    }
    
    /* Requirements Section */
    .requirements-section {
      padding: 80px 0;
      background-color: #fff;
    }
    
    .requirements-container {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
    }
    
    .requirements-card {
      flex: 1 1 300px;
      background: #f9f9f9;
      border-radius: 10px;
      padding: 30px;
    }
    
    .requirements-card h3 {
      margin-bottom: 20px;
      color: #A8C3A4;
    }
    
    .requirements-list {
      list-style: none;
    }
    
    .requirements-list li {
      margin-bottom: 10px;
      padding-left: 25px;
      position: relative;
    }
    
    .requirements-list li:before {
      content: "•";
      color: #A8C3A4;
      font-size: 1.5rem;
      position: absolute;
      left: 0;
      top: -5px;
    }
    
    /* How It Works Section */
    .how-it-works-section {
      padding: 80px 0;
      background-color: #f5f5f5;
    }
    
    .steps-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
    }
    
    .step-card {
      background: white;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      text-align: center;
    }
    
    .step-card i {
      font-size: 2.5rem;
      color: #A8C3A4;
      margin-bottom: 20px;
    }
    
    /* Testimonials Section */
    .testimonials-section {
      padding: 80px 0;
      background-color: #fff;
    }
    
    .testimonial-card {
      background: #f9f9f9;
      border-radius: 10px;
      padding: 30px;
      margin-bottom: 30px;
    }
    
    .testimonial-header {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .testimonial-avatar {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background-color: #ddd;
      margin-right: 15px;
    }
    
    .testimonial-author {
      font-weight: 600;
    }
    
    .testimonial-role {
      color: #777;
      font-size: 0.9rem;
    }
    
    /* CTA Section */
    .cta-section {
      padding: 80px 0;
      background-color: #A8C3A4;
      color: white;
      text-align: center;
    }
    
    .cta-section h2 {
      font-size: 2.2rem;
      margin-bottom: 30px;
    }
    
    
  </style>

  <!-- Hero Section -->
  <section id="hero-section">
    <div class="container">
      <div class="hero-content">
        <h1>Join Our Network of Therapists</h1>
        <p>Experience the benefits of private practice without the challenges. Make your own schedule and let us handle insurance billing, marketing, and admin costs.</p>
        <div class="hero-buttons">
          <a href="mailto:hello@luna.health" class="btn btn-primary">Apply Now</a>
          <a href="signthera.php" class="btn btn-secondary">Sign Up</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Benefits Section -->
  <section class="benefits-section">
    <div class="container">
      <h2 class="section-title">Benefits of Luna</h2>
      <div class="benefits-grid">
        <div class="benefit-card">
          <i class="fa fa-dollar"></i>
          <h3>Competitive Pay</h3>
          <p>Earn up to 100.000 per hour for live sessions via video, audio, or chat.</p>
        </div>
        <div class="benefit-card">
          <i class="fa fa-bonus"></i>
          <h3>No Overhead</h3>
          <p>We handle insurance claims, check coverage, and manage administrative costs.</p>
        </div>
        <div class="benefit-card">
          <i class="fa fa-flex"></i>
          <h3>Flexibility</h3>
          <p>Choose your time commitment and set a schedule that works for you.</p>
        </div>
        <div class="benefit-card">
          <i class="fa fa-support"></i>
          </div>
      </div>
    </div>
  </section>

  <!-- Earnings Section -->
  <section class="earnings-section">
    <div class="container">
      <div class="earnings-card">
        <h2>Who We’re Looking For</h2>
        <p><ul>
            <li><p>Licensed clinical psychologists, counselors, and mental health professionals.</li></p>
          	<li><p>Fluent in English (and a bonus if you speak Luganda, Lusoga, Runyankore, etc.).</li></p>
          	<li><p>Compassionate, tech-comfortable, and committed to delivering quality care.</li></p>
          </p></ul>
        <a href="#earnings-details" class="btn btn-primary"></a>
      </div>
    </div>
  </section>

  <!-- Requirements Section -->
   <style>
  .requirements-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    align-items: stretch;
}

.svg-container {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
}

.svg-container svg {
    width: 100%;
    height: auto;
    max-width: 500px;
}

.requirements-card {
    height: 100%;
    display: flex;
    flex-direction: column;
}</style>
<section class="requirements-section">
  <div class="container">
      <h2 class="section-title">Requirements</h2>
      <div class="requirements-container">
          <div class="requirements-card">
              <h3>Therapist Requirements</h3>
              <ul class="requirements-list">
                  <li>Degree in social work, counselling, or behavioral science</li>
                  <li>Proof of certification and licensing</li>
                  <li>National ID or Passport</li>
                  <li>At least 2 years of experience (preferred)</li>
                  <li>Reliable internet connection</li>
                  <li>Desktop or laptop computer with a reliable internet connection and a webcam</li>
                  <li>Current residence in the EAST AFRICA</li>
              </ul>
              <p><em>Note: Unfortunately, if you are an intern or require supervision to provide therapy services, you are currently ineligible to be a provider at Luna. Therapists are not Luna employees, but independent providers.</em></p>
          </div>
          <div class="requirements-card">
              <div class="">
                  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                       viewBox="0 0 550 550" preserveAspectRatio="xMidYMid meet">
                      <path fill="none" opacity="1" stroke="#000000" stroke-linecap="solid" 
                            stroke-linejoin="round" stroke-width="3"
                            d="M415.5,506c-11.1-3.9-20.7-10.4-29.4-18.1c-8.1-7.1-15.5-15-20-25
                               c-4.3-9.6-5.9-19.9-2.8-29.9c3.4-10.7,7.6-18,23.3-18.4c12.2-0.3,24.4,0.6,36.5,2.4
                               c4.1,0.6,8.3,0.2,12.5,0.9c5.1,0.8,10.3,0.9,15.5,0.6c9.7-0.6,12.8-2.6,15.3-12c2.8-10.4,0.7-21.4-9.4-27.4
                               c-3.8-2.3-8.1-3.4-12.5-3.9c-7.3-0.9-14.7-1.4-22-2.1c-17.6-1.6-29.2-9.1-33.9-27.5c-2.5-9.6,1.7-17.6,9.4-22.9
                               c8.8-6.8,19.8-10.7,31-14.5c8.1-2.8,16.2-5.5,24-9.1c6.1-2.8,12.4-6,16.9-11c8.9-8.5,9.2-17.3,1.6-27.3
                               c-4.4-5.8-10.7-9.2-17.4-12.2c-9.6-4.3-19.8-7.6-28.6-13.8c-10.9-7.7-14-18.7-12.2-30.5c2.6-17.5,5.3-35,3.5-52.5
                               c-2.4-25.9-10.1-50.5-25.6-72c-10.7-14.8-24.3-26.2-42.5-31c-5.4-1.4-10.9-2.5-16.5-2.5c-11.3,0-22.7-0.7-34,1.1
                               c-10.3,1.7-20.3,4.5-30.5,6.3c-8.1,1.4-16.1,2.3-24.5,1.8c-25.7-1.7-50.6,1.7-74.5,12.1c-18.5,8-34.9,19.1-48.8,33.3
                               c-22.5,22.9-36.8,50.7-42.3,82.4c-2.3,12.9-3.1,26.1-1.6,39.5c1,9.1,1.3,18.4,2.4,27.5c1.2,9.4,2.6,18.8,5,28
                               c3.8,16.1,8.2,32,13.8,47.6c10,27.5,23.3,53.1,41.6,76c12.4,15.6,26.6,29.1,44.4,38.6c12,6.4,24.6,10.4,38,9.8
                               c15-0.7,28.6-6.2,41-14.8c17.2-11.9,30.8-27.1,43.1-43.9c10.2-13.9,18.9-28.7,26.8-44c8.4-16.1,15.7-32.8,21.9-49.9
                               c6.9-18.9,12.6-39.2,16.6-59c3.1-15.5,5.5-31.1,5.4-47c0-7.9-1-15.9-4-23.4c-3.5-9-10.6-13.7-19.9-15.6
                               c-12.6-2.8-25.6,0.6-38.3,5.2c-16.8,6.2-31.7,15.8-44.2,28.8c-10.9,11.3-19.2,24.2-23.4,39.5c-2,7.5-3.6,15.2-3.5,23
                               c0.2,18.5,0.8,37,0.8,55.5c0,8.9-2.6,17-9.9,23c-6.3,5.4-12.5,6.6-19,5.7c-2.1-0.3-4.5-0.1-6.5-1.3"/>
                      <path fill="none" opacity="1" stroke="#000000" stroke-linecap="round" 
                            stroke-linejoin="round" stroke-width="3"
                            d="M186,376c6.4-9,14.8-15.5,25.5-18.4c18.1-4.9,35.8,4.8,43.2,18
                               c-11.6,3.5-23.3,4.6-35.2,3c-6.7-0.9-13.3-2.8-20-3.9c-6.4-1.1-8.2,1.6-6.6,8c2.4,9.2,10.1,16.8,22.6,16.5
                               c3.2-0.1,6.4-0.3,9.5,0c12.2,1.1,21-6.1,24.5-17.5"/>
                      <path fill="none" opacity="1" stroke="#000000" stroke-linecap="round" 
                            stroke-linejoin="round" stroke-width="3"
                            d="M271,226c6.8,10.6,15.3,19.3,26.5,25.6c15.9,9,33.6,6.3,47.5-3.7
                               c6.4-4.6,12-10,17.5-15.5"/>
                  </svg>
              </div>
          </div>
      </div>
  </div>
</section>
  <!-- How It Works Section -->
<section class="how-it-works-section">
  <div class="container">
      <h2 class="section-title">How to Get Started</h2>
      <div class="steps-container">
          <div class="step-card">
              <i class="fas fa-user-edit"></i>
              <h3>Sign Up</h3>
              <p>Fill the sign-up form with your credentials and availability.</p>
          </div>
          <div class="step-card">
              <i class="fas fa-clipboard-check"></i>
              <h3>Verification</h3>
              <p>Our team will verify your qualifications and license to ensure they meet our standard of care.</p>
          </div>
          <div class="step-card">
              <i class="fas fa-laptop-code"></i>
              <h3>Onboarding</h3>
              <p>Receive training on using the Luna platform.</p>
          </div>
          <div class="step-card">
              <i class="fas fa-comments"></i>
              <h3>Start Consulting</h3>
              <p>Begin offering online sessions to clients</p>
          </div>
      </div>
  </div>
</section>

<style>
.steps-container {
  display: flex;
  justify-content: space-between;
  gap: 20px;
  flex-wrap: nowrap;
  overflow-x: auto; /* For mobile responsiveness */
}

.step-card {
  flex: 1 1 25%;
  min-width: 250px;
  padding: 25px;
  text-align: center;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.step-card i {
  font-size: 2.5rem;
  color: #2F80ED;
  margin-bottom: 15px;
}

.step-card h3 {
  margin: 10px 0;
  color: #2D3436;
}

.step-card p {
  color: #636E72;
  line-height: 1.6;
}

@media (max-width: 768px) {
  .steps-container {
      flex-wrap: wrap;
  }
  .step-card {
      flex: 1 1 45%;
      margin-bottom: 20px;
  }
}
</style>
  <!-- Testimonials Section -->
  <section class="testimonials-section">
    <div class="container">
      <h2 class="section-title">What Our Therapists Say</h2>
      <div class="testimonial-card">
        <div class="testimonial-header">
          <div class="testimonial-avatar"></div>
          <div>
            <div class="testimonial-author">Trevor Atwine, LPC</div>
            <div class="testimonial-role">Luna Therapist since 2025</div>
          </div>
        </div>
        <p>"The best part about Luna is that I can set my hours to be as flexible as I need. I also choose how many clients I work with on the platform at any time. The design makes it so much easier to get notes completed, often being able to complete them right after the session ends."</p>
      </div>
      <!-- More testimonials can be added here -->
       
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta-section">
    <div class="container">
      <h2>Ready to join our network?</h2>
      <a href="mailto:hello@luna.health" class="btn btn-lg" style="background-color: white; color: #A8C3A4; padding: 15px 40px; font-size: 1.2rem;">Apply Now</a>
    </div>
  </section>

 <?php include(__DIR__ . '/../../includes/layouts/footer.php'); ?>