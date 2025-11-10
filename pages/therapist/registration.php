<?php include(__DIR__ . '/../../includes/layouts/header.php');?>
  <link rel="stylesheet" href="css/signthera.css">

  <!-- Main Content -->
  <main>
    
    <div class="container">
      <form action="php/therasign.inc.php" method="POST" enctype="multipart/form-data">
        <div class="page-title">
          <h1>Therapist Sign-Up Form</h1>
          <p>Please complete the form below to join our network of mental health professionals</p>
        </div>

        <!-- Section 1: Personal Information -->
        <section class="form-section">
          <h2>Personal Information</h2>
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
              <input type="tel" id="phone" name="phone" placeholder="+256781202892 or +256 781 202 892" required>
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
                <div class="file-selected" id="id-upload-name">No file selected</div>
              </div>
              <div class="file-format-note">File must be in PDF format, max 5MB</div>
            </div>
        </section>

        <!-- Section 2: Professional Details -->
        <section class="form-section">
          <h2>Professional Details</h2>
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
                <input type="text" id="other-specialization" name="other-specialization" placeholder="Enter other specialization">
              </div>
            </div>

            <div class="form-group">
              <label for="license-upload" class="required">Upload Professional License or Certification</label>
              <div class="file-upload">
                <input type="file" id="license-upload" name="license-upload" accept="application/pdf" required>
                <label for="license-upload" class="file-upload-label">Choose File</label>
                <div class="file-selected" id="license-upload-name">No file selected</div>
              </div>
              <div class="file-format-note">File must be in PDF format, max 5MB</div>
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
                <div class="file-selected" id="cv-upload-name">No file selected</div>
              </div>
              <div class="file-format-note">File must be in PDF format, max 5MB</div>
            </div>
        </section>

        <!-- Section 3: Availability & Language -->
        <section class="form-section">
          <h2>Availability & Language</h2>
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
                <input type="text" id="other-language" name="other-language" placeholder="Enter other language(s)">
              </div>
            </div>
        </section>

        <!-- Section 4: Tech Readiness -->
        <section class="form-section">
          <h2>Tech Readiness</h2>
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
        </section>

        <!-- Section 5: Consent & Final Submission -->
        <section class="form-section">
          <h2>Consent & Final Submission</h2>
          <div class="consent-section">
            <div class="consent-item">
              <input type="checkbox" id="consent-verification" name="consent-verification" required>
              <label for="consent-verification">I consent to SwiftDoc verifying my credentials</label>
            </div>
            <div class="consent-item">
              <input type="checkbox" id="consent-data" name="consent-data" required>
              <label for="consent-data">I understand that my data will be used only for recruitment purposes</label>
            </div>
          </div>
          <button type="submit" class="btn btn-block" id="submit-btn">Submit Application</button>
        </section>
      </form>
    </div>
  </main>

  <script src="js/signthera.js"></script>
  <?php include(__DIR__ . '/../../includes/layouts/footer.php'); ?>

