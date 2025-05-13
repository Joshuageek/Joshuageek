<?php include('header.php');?>

    <style>
        .about-hero-section {
            background-image: url('images/teen1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        @keyframes moveLeft {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        .rev-slidebg {
            animation: moveLeft 20s linear infinite;
        }
    </style>

         <!--begin about-hero-section -->
    <section id="hero-section" class="about-hero-section">

        <!--begin image-overlay -->
        <div class="image-overlay"></div>
        <!--end image-overlay -->

        <!--begin container-->
        <div class="container image-section-inside">

            <!--begin row-->
            <div class="row">

                <!--begin col-md-10-->
                <div class="col-md-10 col-md-offset-1 text-center">

                    <span class="comic-text wow fadeIn" data-wow-delay="0.5s">Book a quick Session </span>

                    <h2 class="section-title white wow bounceIn" data-wow-delay="1s">Swift Doc</h2>

                    <p class="hero-text wow fadeInUp" data-wow-delay="2s">Ditch the queue!</p>

                </div>
                <!--end col-md-10-->

            </div>
            <!--end row-->

        </div>
        <!--end container-->

    </section>
    <!--end about-hero-section -->

    <style>
      /* Define a custom height for the image */
      .custom-height {
        height: 500px; /* Adjust this value as needed */
        object-fit: cover; /* Ensures the image covers the area without distortion */
      }
      
      /* Optional: Responsive adjustment */
      @media (max-width: 768px) {
        .custom-height {
          height: 200px;
        }
      }
    </style>
    
    <section class="section-white small-padding no-padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center register-inner padding-top-30">
                    <img src="images/90 (1).jpg" alt="picture" class="width-100 custom-height">
                </div>
                <div class="col-md-6">
                    <span class="comic-text">Appointment</span>
                    <h2 class="section-title">Online Booking</h2>
                    <p>Whether you’re looking for someone to talk to or need ongoing support, we connect you with professional mental health services from the comfort of your home. No long waits, no high costs, just the help you need, when you need it. Step into a realm of convenience, expertise, and personalized care.</p>
                    <p class="register_success_box" style="display:none;">We received your message and you'll hear from us soon. Thank You!</p>
                    <form id="register-form" class="contact" action="php/register.php" method="post">
                        <div class="col-md-6">
                            <input class="register-input white-input" required name="register_names" placeholder="Full Name" type="text">
                            <input class="register-input white-input" required name="register_phone" placeholder="Phone Number" type="text">
                            <input class="register-input white-input" required name="register_date" type="date">
                        </div>
                        <div class="col-md-6">
                            <input class="register-input white-input" required name="register_email" placeholder="Email Address" type="email">
                            <select class="register-input white-input" required name="register_ticket">
                                <option value="">How Many?</option>
                                <option value="1 Person">1 Person</option>
                                <option value="2 People">2 People</option>
                                <option value="3 People">3 People</option>
                                <option value="4 People">4 People</option>
                                <option value="5 People">5 People</option>
                                <option value="6 People">6 People</option>
                                <option value="7 People">7 People</option>
                                <option value="8 People">8 People</option>
                                <option value="9 People">9 People</option>
                                <option value="10 People">10 People</option>
                            </select>
                            <input class="register-input white-input" required name="register_time" placeholder="Booking Time" type="text">
                        </div>
                        <div class="col-md-12">
                            <input value="Book Your Session" id="submit-button" class="register-submit" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
  <!--end section-white-->

    <?php include('footer.php');?>