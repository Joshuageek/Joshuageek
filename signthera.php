<?php include('header.php');?>
  <style>
    
    /* Main Content Styles */
    main {
      padding-top: 100px;
    }
    
    .page-title {
      text-align: center;
      margin-bottom: 40px;
    }
    
    .page-title h1 {
      font-size: 32px;
      color: #2D3436;
      margin-bottom: 10px;
    }
    
    .page-title p {
      color: #636E72;
    }
    
    /* Form Styles */
    .form-section {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      padding: 30px;
      margin-bottom: 30px;
    }
    
    .form-section h2 {
      font-size: 24px;
      color: #2D3436;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #f0f0f0;
    }
    
    .form-group {
      margin-bottom: 25px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
    }
    
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-family: 'Montserrat', sans-serif;
      font-size: 16px;
    }
    
    .form-group textarea {
      resize: vertical;
      min-height: 120px;
    }
    
    .required::after {
      content: " *";
      color: #ff6b6b;
    }
    
    /* File Upload Styles */
    .file-upload {
      position: relative;
      overflow: hidden;
      margin-bottom: 20px;
    }
    
    .file-upload input[type="file"] {
      position: absolute;
      font-size: 100px;
      opacity: 0;
      right: 0;
      top: 0;
      cursor: pointer;
    }
    
    .file-upload-label {
      display: inline-block;
      background-color: #f0f8ff;
      color: #333;
      padding: 12px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    
    .file-upload-label:hover {
      background-color: #e0f0ff;
    }
    
    .file-format-note {
      font-size: 14px;
      color: #888;
      margin-top: 5px;
    }
    
    /* Availability Table Styles */
    .availability-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    
    .availability-table th,
    .availability-table td {
      padding: 10px;
      text-align: center;
      border: 1px solid #eee;
    }
    
    .availability-table th {
      background-color: #f9f9f9;
    }
    
    /* Radio Button Styles */
    .radio-group {
      display: flex;
      gap: 20px;
      margin-top: 10px;
    }
    
    .radio-option {
      display: flex;
      align-items: center;
    }
    
    .radio-option input {
      margin-right: 8px;
    }
    
    /* Consent Section */
    .consent-section {
      margin-bottom: 30px;
    }
    
    .consent-item {
      display: flex;
      align-items: flex-start;
      margin-bottom: 15px;
    }
    
    .consent-item input {
      margin-right: 10px;
      margin-top: 5px;
    }
    
    /* Button Styles */
    .btn {
      display: inline-block;
      padding: 12px 30px;
      background-color: #A8C3A4;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s;
      text-align: center;
    }
    
    .btn:hover {
      background-color: #8bc34a;
    }
    
    .btn-block {
      display: block;
      width: 100%;
    }
  
  </style>

  <!-- Main Content -->
  <main>
    <div class="container">
      <div class="page-title">
        <h1>Therapist Sign-Up Form</h1>
        <p>Please complete the form below to join our network of mental health professionals</p>
      </div>

      <!-- Section 1: Personal Information -->
      <section class="form-section">
        <h2>Personal Information</h2>
        <form id="signup-form">
          <div class="form-group">
            <label for="full-name" class="required">Full Name</label>
            <input type="text" id="full-name" name="full-name" required>
          </div>

          <div class="form-group">
            <label for="email" class="required">Email Address</label>
            <input type="email" id="email" name="email" required>
            <small class="form-text text-muted">Must include a valid email provider (e.g., @gmail.com, @yahoo.com)</small>
          </div>

          <div class="form-group">
            <label for="phone" class="required">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="+256 781 202 892" required>
            <small class="form-text text-muted">Must start with +256 (Uganda country code)</small>
          </div>

          <div class="form-group">
            <label for="location" class="required">Location (District)</label>
            <select id="location" name="location" required>
              <option value="" disabled selected>Select District</option>
              <option value="abim">Abim District</option>
              <option value="adjumani">Adjumani District</option>
              <option value="agago">Agago District</option>
              <option value="alebtong">Alebtong District</option>
              <option value="amolatar">Amolatar District</option>
              <option value="amudat">Amudat District</option>
              <option value="amuria">Amuria District</option>
              <option value="amuru">Amuru District</option>
              <option value="apac">Apac District</option>
              <option value="arua">Arua District</option>
              <option value="budaka">Budaka District</option>
              <option value="bududa">Bududa District</option>
              <option value="bugiri">Bugiri District</option>
              <option value="bugweri">Bugweri District</option>
              <option value="buhweju">Buhweju District</option>
              <option value="buikwe">Buikwe District</option>
              <option value="bukedea">Bukedea District</option>
              <option value="bukomansimbi">Bukomansimbi District</option>
              <option value="bukwo">Bukwo District</option>
              <option value="bulambuli">Bulambuli District</option>
              <option value="buliisa">Buliisa District</option>
              <option value="bundibugyo">Bundibugyo District</option>
              <option value="bunyangabu">Bunyangabu District</option>
              <option value="bushenyi">Bushenyi District</option>
              <option value="busia">Busia District</option>
              <option value="butaleja">Butaleja District</option>
              <option value="butambala">Butambala District</option>
              <option value="butebo">Butebo District</option>
              <option value="buvuma">Buvuma District</option>
              <option value="buyende">Buyende District</option>
              <option value="dokolo">Dokolo District</option>
              <option value="gomba">Gomba District</option>
              <option value="gulu">Gulu District</option>
              <option value="hoima">Hoima District</option>
              <option value="iband">Ibanda District</option>
              <option value="iganga">Iganga District</option>
              <option value="isingiro">Isingiro District</option>
              <option value="jinja">Jinja District</option>
              <option value="kaabong">Kaabong District</option>
              <option value="kabale">Kabale District</option>
              <option value="kabarole">Kabarole District</option>
              <option value="kaberamaido">Kaberamaido District</option>
              <option value="kagadi">Kagadi District</option>
              <option value="kakumiro">Kakumiro District</option>
              <option value="kalaki">Kalaki District</option>
              <option value="kalangala">Kalangala District</option>
              <option value="kaliro">Kaliro District</option>
              <option value="kalungu">Kalungu District</option>
              <option value="kamuli">Kamuli District</option>
              <option value="kamwenge">Kamwenge District</option>
              <option value="kanungu">Kanungu District</option>
              <option value="kapchorwa">Kapchorwa District</option>
              <option value="kapelebyong">Kapelebyong District</option>
              <option value="karenga">Karenga District</option>
              <option value="kasese">Kasese District</option>
              <option value="kassanda">Kassanda District</option>
              <option value="katakwi">Katakwi District</option>
              <option value="kayunga">Kayunga District</option>
              <option value="kazo">Kazo District</option>
              <option value="kibaale">Kibaale District</option>
              <option value="kiboga">Kiboga District</option>
              <option value="kibuku">Kibuku District</option>
              <option value="kigezi">Kigezi District</option>
              <option value="kikuube">Kikuube District</option>
              <option value="kiruhura">Kiruhura District</option>
              <option value="kiryandongo">Kiryandongo District</option>
              <option value="kisoro">Kisoro District</option>
              <option value="kitagwenda">Kitagwenda District</option>
              <option value="kitgum">Kitgum District</option>
              <option value="koboko">Koboko District</option>
              <option value="kole">Kole District</option>
              <option value="kotido">Kotido District</option>
              <option value="kumi">Kumi District</option>
              <option value="kwania">Kwania District</option>
              <option value="kween">Kween District</option>
              <option value="kyankwanzi">Kyankwanzi District</option>
              <option value="kyegegwa">Kyegegwa District</option>
              <option value="kyenjojo">Kyenjojo District</option>
              <option value="kyotera">Kyotera District</option>
              <option value="lamwo">Lamwo District</option>
              <option value="lira">Lira District</option>
              <option value="luuka">Luuka District</option>
              <option value="luweero">Luweero District</option>
              <option value="lwengo">Lwengo District</option>
              <option value="lyantonde">Lyantonde District</option>
              <option value="manafwa">Manafwa District</option>
              <option value="maracha">Maracha District</option>
              <option value="masaka">Masaka District</option>
              <option value="masindi">Masindi District</option>
              <option value="mayuge">Mayuge District</option>
              <option value="mbale">Mbale District</option>
              <option value="mbarara">Mbarara District</option>
              <option value="mitooma">Mitooma District</option>
              <option value="mityana">Mityana District</option>
              <option value="moroto">Moroto District</option>
              <option value="moyo">Moyo District</option>
              <option value="mpigi">Mpigi District</option>
              <option value="mubende">Mubende District</option>
              <option value="mukono">Mukono District</option>
              <option value="nabilatuk">Nabilatuk District</option>
              <option value="nakapiripirit">Nakapiripirit District</option>
              <option value="nakaseke">Nakaseke District</option>
              <option value="nakasongola">Nakasongola District</option>
              <option value="namayingo">Namayingo District</option>
              <option value="namisindwa">Namisindwa District</option>
              <option value="namutumba">Namutumba District</option>
              <option value="napak">Napak District</option>
              <option value="nebbi">Nebbi District</option>
              <option value="ngora">Ngora District</option>
              <option value="ntoroko">Ntoroko District</option>
              <option value="ntungamo">Ntungamo District</option>
              <option value="nwoya">Nwoya District</option>
              <option value="obongi">Obongi District</option>
              <option value="omoro">Omoro District</option>
              <option value="otuke">Otuke District</option>
              <option value="oyam">Oyam District</option>
              <option value="pader">Pader District</option>
              <option value="pakwach">Pakwach District</option>
              <option value="pallisa">Pallisa District</option>
              <option value="rakai">Rakai District</option>
              <option value="rubanda">Rubanda District</option>
              <option value="rubirizi">Rubirizi District</option>
              <option value="rukiga">Rukiga District</option>
              <option value="rukungiri">Rukungiri District</option>
              <option value="rwampara">Rwampara District</option>
              <option value="sembabule">Sembabule District</option>
              <option value="serere">Serere District</option>
              <option value="sheema">Sheema District</option>
              <option value="sironko">Sironko District</option>
              <option value="soroti">Soroti District</option>
              <option value="terego">Terego District</option>
              <option value="tororo">Tororo District</option>
              <option value="wakiso">Wakiso District</option>
              <option value="yumbe">Yumbe District</option>
              <option value="zombo">Zombo District</option>
            </select>
          </div>

          <div class="form-group">
            <label for="id-upload" class="required">Upload copy of National ID or Passport</label>
            <div class="file-upload">
              <input type="file" id="id-upload" name="id-upload" accept="application/pdf" required>
              <label for="id-upload" class="file-upload-label">Choose File</label>
            </div>
            <div class="file-format-note">File must be in PDF format</div>
          </div>
        </form>
      </section>

      <!-- Section 2: Professional Details -->
      <section class="form-section">
        <h2>Professional Details</h2>
        <form id="professional-form">
          <div class="form-group">
            <label for="specialization" class="required">Area of Specialization</label>
            <select id="specialization" name="specialization" class="other-dropdown" required>
              <option value="" disabled selected>Select Specialization</option>
              <option value="depression">Depression</option>
              <option value="anxiety">Anxiety</option>
              <option value="trauma">Trauma</option>
              <option value="youth-counseling">Youth Counseling</option>
              <option value="family-therapy">Family Therapy</option>
              <option value="couples-therapy">Couples Therapy</option>
              <option value="other">Other</option>
            </select>
            <div id="specialization-other" class="other-container" style="display: none; margin-top: 10px;">
              <input type="text" name="other-specialization" placeholder="Enter other specialization">
            </div>
          </div>

          <div class="form-group">
            <label for="license-upload" class="required">Upload Professional License or Certification</label>
            <div class="file-upload">
              <input type="file" id="license-upload" name="license-upload" accept="application/pdf" required>
              <label for="license-upload" class="file-upload-label">Choose File</label>
            </div>
            <div class="file-format-note">File must be in PDF format</div>
          </div>

          <div class="form-group">
            <label for="licensing-body">Licensing Body / Organization</label>
            <input type="text" id="licensing-body" name="licensing-body">
          </div>

          <div class="form-group">
            <label for="cv-upload" class="required">Upload CV</label>
            <div class="file-upload">
              <input type="file" id="cv-upload" name="cv-upload" accept="application/pdf" required>
              <label for="cv-upload" class="file-upload-label">Choose File</label>
            </div>
            <div class="file-format-note">File must be in PDF format</div>
          </div>
        </form>
      </section>

      <!-- Section 3: Availability & Language -->
      <section class="form-section">
        <h2>Availability & Language</h2>
        <form id="availability-form">
          <div class="form-group">
            <label for="languages" class="required">Languages Spoken</label>
            <select id="languages" name="languages" class="other-dropdown" required>
              <option value="english">English</option>
              <option value="luganda">Luganda</option>
              <option value="lusoga">Lusoga</option>
              <option value="runyankore">Runyankore</option>
              <option value="luo">Luo</option>
              <option value="swahili">Swahili</option>
              <option value="other">Other</option>
            </select>
            <div id="languages-other" class="other-container" style="display: none; margin-top: 10px;">
              <input type="text" name="other-language" placeholder="Enter other language(s)">
            </div>
          </div>
        </form>
      </section>

      <!-- Section 4: Tech Readiness -->
      <section class="form-section">
        <h2>Tech Readiness</h2>
        <form id="tech-form">
          <div class="form-group">
            <label class="required">Do you have a stable internet connection?</label>
            <div class="radio-group">
              <div class="radio-option">
                <input type="radio" id="internet-yes" name="internet" value="yes" required>
                <label for="internet-yes">Yes</label>
              </div>
              <div class="radio-option">
                <input type="radio" id="internet-no" name="internet" value="no" required>
                <label for="internet-no">No</label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="required">Are you comfortable using video conferencing platforms?</label>
            <div class="radio-group">
              <div class="radio-option">
                <input type="radio" id="video-yes" name="video" value="yes" required>
                <label for="video-yes">Yes</label>
              </div>
              <div class="radio-option">
                <input type="radio" id="video-no" name="video" value="no" required>
                <label for="video-no">No</label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="required">Have you offered teletherapy before?</label>
            <div class="radio-group">
              <div class="radio-option">
                <input type="radio" id="teletherapy-yes" name="teletherapy" value="yes" required>
                <label for="teletherapy-yes">Yes</label>
              </div>
              <div class="radio-option">
                <input type="radio" id="teletherapy-no" name="teletherapy" value="no" required>
                <label for="teletherapy-no">No</label>
              </div>
            </div>
          </div>
        </form>
      </section>

      <!-- Section 5: Consent & Final Submission -->
      <section class="form-section">
        <h2>Consent & Final Submission</h2>
        <div class="consent-section">
          <div class="consent-item">
            <input type="checkbox" id="consent-verification" name="consent-verification" required>
            <label for="consent-verification">I consent to Luna verifying my credentials</label>
          </div>
          <div class="consent-item">
            <input type="checkbox" id="consent-data" name="consent-data" required>
            <label for="consent-data">I understand that my data will be used only for recruitment purposes</label>
          </div>
        </div>
        <button type="submit" class="btn btn-block">Submit Application</button>
      </section>
    </div>
  </main>

  <?php include('footer.php'); ?>

  <script>
    // Function to handle "Other" option visibility
    function handleOtherOption(selectElement) {
      const otherContainer = selectElement.nextElementSibling;
      const otherInput = otherContainer.querySelector('input');
      
      // Check if "Other" is selected
      const isOtherSelected = Array.from(selectElement.selectedOptions).some(option => option.value === 'other');
      
      if (isOtherSelected) {
        otherContainer.style.display = 'block';
        if (otherInput) otherInput.required = true;
      } else {
        otherContainer.style.display = 'none';
        if (otherInput) otherInput.required = false;
      }
    }

    // Initialize all "Other" option dropdowns
    document.addEventListener('DOMContentLoaded', function() {
      const otherDropdowns = document.querySelectorAll('select.other-dropdown');
      
      otherDropdowns.forEach(dropdown => {
        dropdown.addEventListener('change', function() {
          handleOtherOption(this);
        });
      });
    });

    // Basic form validation
    document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
      e.preventDefault();
      
      // Check if all required fields are filled
      const requiredFields = document.querySelectorAll('input[required], select[required]');
      let isValid = true;
      
      requiredFields.forEach(field => {
        if (!field.value) {
          isValid = false;
          field.style.borderColor = '#ff6b6b';
        } else {
          field.style.borderColor = '#ddd';
        }
      });
      
      // Email validation
      const email = document.getElementById('email');
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email.value)) {
        isValid = false;
        email.style.borderColor = '#ff6b6b';
      } else {
        email.style.borderColor = '#ddd';
      }
      
      // Phone validation
      const phone = document.getElementById('phone');
      const phoneRegex = /^\+256\s\d{3}\s\d{3}\s\d{3}$/;
      if (!phoneRegex.test(phone.value)) {
        isValid = false;
        phone.style.borderColor = '#ff6b6b';
      } else {
        phone.style.borderColor = '#ddd';
      }
      
      if (isValid) {
        alert('Application submitted successfully! We will review your credentials and contact you shortly.');
        document.getElementById('signup-form').reset();
        document.getElementById('professional-form').reset();
        document.getElementById('availability-form').reset();
        document.getElementById('tech-form').reset();
      } else {
        alert('Please fill in all required fields correctly.');
      }
    });
  </script>