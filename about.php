<?php include('header.php');?>
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://kit.fontawesome.com/a076d05399.css"
      crossorigin="anonymous"
    />
    <style>

      /* Hero Section */
      .hero-section {
        background-color: #f5f7ff;
        padding: 120px 0 80px;
        text-align: center;
      }

      .hero-content h1 {
        font-size: 2.8rem;
        color: #a8c3a4;
        margin-bottom: 20px;
      }

      .hero-content p {
        font-size: 1.1rem;
        color: #5f6c7b;
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
        background-color: #a8c3a4;
        color: white;
      }

      .btn-secondary {
        background-color: transparent;
        color: #a8c3a4;
        border: 2px solid #a8c3a4;
      }

      .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      }

      /* About Section */
      .about-section {
        padding: 80px 0;
        background-color: #fff;
      }

      .section-title {
        text-align: center;
        margin-bottom: 50px;
        font-size: 2.2rem;
        color: #333;
      }

      .about-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
      }

      .about-card {
        background: #f9f9f9;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        transition: transform 0.3s;
      }

      .about-card:hover {
        transform: translateY(-5px);
      }

      .about-card i {
        font-size: 2.5rem;
        color: #a8c3a4;
        margin-bottom: 20px;
      }

      .about-card h3 {
        margin-bottom: 15px;
        color: #333;
      }

      /* Our Values */
      .values-list {
        list-style: disc inside;
        margin: 0 auto;
        padding: 0;
        max-width: 200px;
        text-align: left;
        font-size: 1rem;
        color: #333;
      }
      .values-list li {
        margin: 5px 0;
      }

      /* What We Offer */
      .offer-list {
        display: grid;
        gap: 0.5rem;
        text-align: left;
        padding-left: 10%;
      }
      .offer-item {
        display: flex;
        align-items: center;
      }
      .check-icon {
        font-size: 1rem;
        color: green;
        margin-right: 0.5rem;
      }

      /* Why Choose Us - Centered */
      .why-choose-us {
        text-align: center;
      }
      .btn-green {
        background-color: #a8c3a4;
        color: #fff;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 50px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        display: inline-block;
        margin-top: 20px;
      }
      .btn-green:hover {
        background-color: #d8c4e7;
      }

      /* Story Section */
      .story-section {
        padding: 80px 0;
        background-color: #f5f5f5;
      }

      .story-container {
        max-width: 800px;
        margin: 0 auto;
      }

      .story-content {
        background: white;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        text-align: center;
      }

      .story-content h3 {
        font-size: 1.8rem;
        color: #a8c3a4;
        margin-bottom: 20px;
      }

      .story-content p {
        margin-bottom: 20px;
        font-size: 1.1rem;
      }

      .quote {
        font-style: italic;
        color: #5f6c7b;
        margin: 20px 0;
        padding-left: 20px;
        border-left: 3px solid #a8c3a4;
      }

      /* Promise Section */
      .promise-section {
        padding: 80px 0;
        background-color: #fff;
      }

      .promise-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
      }

      .promise-card {
        background: #f9f9f9;
        border-radius: 10px;
        padding: 30px;
      }

      /* Testimonials Infinite Marquee */
      .testimonials-section {
        padding: 80px 0;
        background-color: #fff;
      }
      .testimonial-marquee {
        overflow: hidden;
        position: relative;
        width: 100%;
        height: 200px;
      }
      .testimonial-track {
        display: flex;
        width: max-content;
        animation: marquee 20s linear infinite;
        gap: 50px;
      }
      .testimonial-card {
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #f9f9f9;
        border-radius: 10px;
        padding: 30px;
        min-width: 300px;
        text-align: center;
      }
      @keyframes marquee {
        0% {
          transform: translateX(0);
        }
        100% {
          transform: translateX(-100%);
        }
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
        background-color: #a8c3a4;
        color: white;
        text-align: center;
      }

      .cta-section h2 {
        font-size: 2.2rem;
        margin-bottom: 30px;
      }

    </style>
 

    <!-- Hero Section -->
    <section class="hero-section">
      <div class="container">
        <div class="hero-content">
          <h1>About Luna</h1>
          <p>
            Transforming mental health care through innovation and compassion
          </p>
          <div class="hero-buttons">
            <a href="#learn-more" class="btn btn-primary">Learn More</a>
            <a href="#contact" class="btn btn-secondary">Contact Us</a>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="learn-more">
      <div class="container">
        <h2 class="section-title">Who We Are</h2>
        <div class="about-grid">
          <div class="about-card">
            <i class="fas fa-bullseye"></i>
            <h3>Our Mission</h3>
            <p>
              To break down the barriers to healthcare by combining innovation
              and compassion—making quality care accessible to all.
            </p>
          </div>
          <div class="about-card">
            <i class="fas fa-heart"></i>
            <h3>Our Values</h3>
            <ul class="values-list">
              <li>Compassion</li>
              <li>Accessibility</li>
              <li>Privacy</li>
              <li>Innovation</li>
              <li>Equity</li>
            </ul>
          </div>
          <div class="about-card">
            <i class="fas fa-cogs"></i>
            <h3>What We Offer</h3>
            <div class="offer-list">
              <div class="offer-item">
                <span class="check-icon">&#x2713;</span>
                <span>One-on-one virtual therapy</span>
              </div>
              <div class="offer-item">
                <span class="check-icon">&#x2713;</span>
                <span>Mental health support</span>
              </div>
              <div class="offer-item">
                <span class="check-icon">&#x2713;</span>
                <span>Flexible scheduling</span>
              </div>
              <div class="offer-item">
                <span class="check-icon">&#x2713;</span>
                <span>Affordable rates</span>
              </div>
              <div class="offer-item">
                <span class="check-icon">&#x2713;</span>
                <span>Local language support</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Centered Why Choose Us Section -->
        <div
          style="
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
          "
        >
          <div class="about-card why-choose-us" style="margin: auto">
            <i class="fas fa-thumbs-up"></i>
            <h3>Why Choose Us?</h3>
            <p
              class="text-gray-600 leading-relaxed text-lg font-light italic mb-6"
            >
              "No waitlists. No awkward clinic visits. Just you, your phone, and
              a therapist ready to listen."
            </p>
            <a href="#contact" class="btn-green">Get Started Today</a>
          </div>
        </div>
      </div>
    </section>
    <!-- Story Section -->
    <section class="story-section">
      <div class="container">
        <h2 class="section-title">Discover Our Story</h2>
        <div class="story-container">
          <div class="story-content">
            <h3>Luna Teletherapy</h3>
            <p>
              Luna Teletherapy was born out of something deeply personal.
              I've been through my own struggles with mental health, moments
              when I felt overwhelmed, anxious, and alone. And during those
              times, finding someone to talk to felt like another mountain to
              climb.
            </p>
            <p>
              That's why I started Luna. It's not just a platform, it's a
              passion project, created with empathy and the understanding that
              sometimes, all we really need is a safe space to be heard.
            </p>
            <p>
              Here, we make it simple for you to connect with a licensed
              therapist, no long queues, no judgment, no pressure. Just real
              conversations with professionals who care. You can book a session
              right from your phone, choose a time that works for you, and get
              the support you need from wherever you are.
            </p>
            <p>
              We work with therapists who understand the complexities of mental
              health, from stress, anxiety, and depression, to trauma, burnout,
              and relationship struggles. We're here for your hardest days, your
              quiet moments, and everything in between.
            </p>
            <p>
              This isn't just about therapy, it's about reminding you that
              you're not alone, and that help is just a conversation away.
            </p>
            <div class="quote">
              <p>
                "Healing doesn't mean the damage never existed. It means the
                damage no longer controls your life."
              </p>
              <p>— Akshay Dubey</p>
            </div>
            <p>
              <strong>Founder's Note</strong><br />
              I created Luna because I needed something like it too. If
              you're here reading this, know that you're already taking a brave
              step, and we're here to walk the rest with you.
            </p>
            <p><strong>Brendah Namubali, Co-founder</strong></p>
          </div>
        </div>
      </div>
    </section>

    <!-- Promise Section -->
    <section class="promise-section">
      <div class="container">
        <h2 class="section-title">Our Promise To You</h2>
        <div class="promise-container">
          <div class="promise-card">
            <h3>Convenience & Accessibility</h3>
            <p>
              Wherever you are—home, work, or on the go—we connect you with
              mental health professionals through seamless virtual
              consultations.
            </p>
          </div>
          <div class="promise-card">
            <h3>Time Efficiency</h3>
            <p>
              Our platform is designed for quick scheduling and hassle-free
              sessions, so you receive timely care without disruptions.
            </p>
          </div>
          <div class="promise-card">
            <h3>Personalized Support</h3>
            <p>
              Your journey is unique. Our experts listen and provide care
              tailored to your individual needs.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section with Infinite Marquee -->
    <section class="testimonials-section">
      <div class="container">
        <h2 class="section-title">What Our Patients Say</h2>
        <div class="testimonial-marquee">
          <div class="testimonial-track">
            <div class="testimonial-card">
              <div class="testimonial-header">
                <div class="testimonial-avatar"></div>
                <div>
                  <div class="testimonial-author">Rochak Kohli</div>
                  <div class="testimonial-role">Patient</div>
                </div>
              </div>
              <p>
                "Healing takes time, and asking for help is a courageous step
                forward."
              </p>
            </div>
            <div class="testimonial-card">
              <div class="testimonial-header">
                <div class="testimonial-avatar"></div>
                <div>
                  <div class="testimonial-author">Dusabe Kevin</div>
                  <div class="testimonial-role">Patient</div>
                </div>
              </div>
              <p>
                "You don’t have to control your thoughts; just stop letting them
                control you."
              </p>
            </div>
            <div class="testimonial-card">
              <div class="testimonial-header">
                <div class="testimonial-avatar"></div>
                <div>
                  <div class="testimonial-author">Rochak Kohli</div>
                  <div class="testimonial-role">Patient</div>
                </div>
              </div>
              <p>
                "Healing takes time, and asking for help is a courageous step
                forward."
              </p>
            </div>
            <div class="testimonial-card">
              <div class="testimonial-header">
                <div class="testimonial-avatar"></div>
                <div>
                  <div class="testimonial-author">Dusabe Kevin</div>
                  <div class="testimonial-role">Patient</div>
                </div>
              </div>
              <p>
                "You don’t have to control your thoughts; just stop letting them
                control you."
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="container">
        <h2>Ready to start your journey?</h2>
        <a
          href="#contact"
          class="btn btn-lg"
          style="
            background-color: white;
            color: #a8c3a4;
            padding: 15px 40px;
            font-size: 1.2rem;
          "
          >Get Started</a
        >
      </div>
    </section>

    <?php include('footer.php');?>

    <script
      src="https://kit.fontawesome.com/a076d05399.js"
      crossorigin="anonymous"
    ></script>
