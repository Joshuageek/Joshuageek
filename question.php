<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Luna Health - Teletherapy Questionnaire</title>
    <link rel="shortcut icon" href="images/favicon.ico">
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap"
      rel="stylesheet"
    />

  <link href="css/questionnaire.css" rel="stylesheet" />
   
  </head>
  <body>
   
  <!-- main content -->
    <div class="questionnaire-container">
      <div class="progress-bar" id="progressBar"></div>
      <div class="form-header">
        <h2>Luna Health - Teletherapy Questionnaire</h2>
      </div>
      <form id="questionnaireForm" action="php/question.inc.php" method="POST">
        <input type="hidden" id="current_page" name="current_page" value="0">
        <div class="form-content">
          <div class="form-page active" id="page1">
            <div class="form-group">
              <label for="fullName">Full Name</label>
              <input type="text" id="fullName" name="fullName" required />
              <div class="error-message">Please enter your full name</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page2">
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" id="email" name="email" required />
              <div class="error-message">Please enter a valid email address</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page3">
            <div class="form-group">
              <label for="age">Age:</label>
              <select id="age" name="age" required>
                <option value="">Select Age</option>
                <option value="18-24">18-24</option>
                <option value="25-34">25-34</option>
                <option value="35-44">35-44</option>
                <option value="45+">45+</option>
              </select>
              <div class="error-message">Please select your age range</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page4">
            <div class="form-group">
              <label for="gender">Gender:</label>
              <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="non-binary">Non-binary</option>
                <option value="prefer-not">Prefer not to say</option>
              </select>
              <div class="error-message">Please select your gender</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page5">
            <div class="form-group">
              <label for="location">Location (District):</label>
              <input type="text" id="location" name="location" required />
              <div class="error-message">Please enter your location</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page6">
            <div class="form-group">
              <label>What are the primary reasons you're seeking therapy? (Select all that apply)</label>
              <div class="option-group">
                <input type="checkbox" id="reason1" name="therapyReasons[]" value="anxiety" />
                <label for="reason1">Anxiety</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="reason2" name="therapyReasons[]" value="depression" />
                <label for="reason2">Depression</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="reason3" name="therapyReasons[]" value="stress" />
                <label for="reason3">Stress management</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="reason4" name="therapyReasons[]" value="relationship" />
                <label for="reason4">Relationship issues</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="reasonOther" name="therapyReasons[]" value="other" />
                <label for="reasonOther">Other: </label>
                <input type="text" id="otherReason" name="otherReason" placeholder="Please specify" class="other-input" />
              </div>
              <div class="error-message">Please select at least one reason or specify other</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page7">
            <div class="form-group">
              <label>What do you hope to achieve from therapy? (Select all that apply)</label>
              <div class="option-group">
                <input type="checkbox" id="goal1" name="therapyGoals[]" value="reduce-symptoms" />
                <label for="goal1">Reduce symptoms of anxiety or depression</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="goal2" name="therapyGoals[]" value="improve-relationships" />
                <label for="goal2">Improve relationships</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="goal3" name="therapyGoals[]" value="coping-strategies" />
                <label for="goal3">Gain coping strategies for stress</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="goalOther" name="therapyGoals[]" value="other" />
                <label for="goalOther">Other: </label>
                <input type="text" id="otherGoal" name="otherGoal" placeholder="Please specify" class="other-input" />
              </div>
              <div class="error-message">Please select at least one goal or specify other</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page8">
            <div class="form-group">
              <label>Have you ever attended therapy before?</label>
              <div class="option-group">
                <input type="radio" id="therapyCurrent" name="therapyHistory" value="current" required />
                <label for="therapyCurrent">Yes, currently in therapy</label>
              </div>
              <div class="option-group">
                <input type="radio" id="therapyPast" name="therapyHistory" value="past" />
                <label for="therapyPast">Yes, in the past</label>
              </div>
              <div class="option-group">
                <input type="radio" id="therapyNever" name="therapyHistory" value="no" />
                <label for="therapyNever">No</label>
              </div>
              <div class="error-message">Please select an option</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page9">
            <div class="form-group">
              <label>If you have attended therapy before, what kind of therapy did you receive? (Select all that apply)</label>
              <div class="option-group">
                <input type="checkbox" id="receivedIndividual" name="receivedTherapy[]" value="individual" />
                <label for="receivedIndividual">Individual therapy</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="receivedCouples" name="receivedTherapy[]" value="couples" />
                <label for="receivedCouples">Couples therapy</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="receivedFamily" name="receivedTherapy[]" value="family" />
                <label for="receivedFamily">Family therapy</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="receivedGroup" name="receivedTherapy[]" value="group" />
                <label for="receivedGroup">Group therapy</label>
              </div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page10">
            <div class="form-group">
              <label>What type of therapy are you interested in? (Select all that apply)</label>
              <div class="option-group">
                <input type="checkbox" id="interestIndividual" name="therapyInterest[]" value="individual" />
                <label for="interestIndividual">Individual therapy</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="interestCouples" name="therapyInterest[]" value="couples" />
                <label for="interestCouples">Couples therapy</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="interestFamily" name="therapyInterest[]" value="family" />
                <label for="interestFamily">Family therapy</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="interestGroup" name="therapyInterest[]" value="group" />
                <label for="interestGroup">Group therapy</label>
              </div>
              <div class="error-message">Please select at least one therapy type</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page11">
            <div class="form-group">
              <label>What communication method do you prefer for therapy sessions?</label>
              <div class="option-group">
                <input type="radio" id="commVideo" name="communicationMethod" value="video" required />
                <label for="commVideo">Video calls</label>
              </div>
              <div class="option-group">
                <input type="radio" id="commAudio" name="communicationMethod" value="audio" />
                <label for="commAudio">Audio calls</label>
              </div>
              <div class="option-group">
                <input type="radio" id="commText" name="communicationMethod" value="text" />
                <label for="commText">Text/chat-based consultations</label>
              </div>
              <div class="error-message">Please select a communication method</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page12">
            <div class="form-group">
              <label>How often would you like to have therapy sessions?</label>
              <div class="option-group">
                <input type="radio" id="frequencyWeekly" name="sessionFrequency" value="weekly" required />
                <label for="frequencyWeekly">Once a week</label>
              </div>
              <div class="option-group">
                <input type="radio" id="frequencyBiweekly" name="sessionFrequency" value="biweekly" />
                <label for="frequencyBiweekly">Every two weeks</label>
              </div>
              <div class="option-group">
                <input type="radio" id="frequencyMonthly" name="sessionFrequency" value="monthly" />
                <label for="frequencyMonthly">Once a month</label>
              </div>
              <div class="option-group">
                <input type="radio" id="frequencyAsNeeded" name="sessionFrequency" value="as-needed" />
                <label for="frequencyAsNeeded">As needed</label>
              </div>
              <div class="error-message">Please select a session frequency</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page13">
            <div class="form-group">
              <label>What times are most convenient for you to schedule therapy sessions?</label>
              <div class="option-group">
                <input type="radio" id="timeMorning" name="sessionTime" value="morning" required />
                <label for="timeMorning">Morning (8 AM - 12 PM)</label>
              </div>
              <div class="option-group">
                <input type="radio" id="timeAfternoon" name="sessionTime" value="afternoon" />
                <label for="timeAfternoon">Afternoon (12 PM - 4 PM)</label>
              </div>
              <div class="option-group">
                <input type="radio" id="timeEvening" name="sessionTime" value="evening" />
                <label for="timeEvening">Evening (4 PM - 8 PM)</label>
              </div>
              <div class="error-message">Please select a preferred time</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page14">
            <div class="form-group">
              <label>What qualities or approaches are most important to you in a therapist? (Select all that apply)</label>
              <div class="option-group">
                <input type="checkbox" id="qualityEmpathy" name="therapistQualities[]" value="empathy" />
                <label for="qualityEmpathy">Empathy & active listening</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="qualityExperience" name="therapistQualities[]" value="experience" />
                <label for="qualityExperience">Experience with a specific mental health issue</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="qualitySolution" name="therapistQualities[]" value="solution" />
                <label for="qualitySolution">A practical, solution-focused approach</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="qualityNurturing" name="therapistQualities[]" value="nurturing" />
                <label for="qualityNurturing">A therapist who is gentle and nurturing</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="qualityChallenging" name="therapistQualities[]" value="challenging" />
                <label for="qualityChallenging">A therapist who challenges me to grow</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="qualitySpecialized" name="therapistQualities[]" value="specialized" />
                <label for="qualitySpecialized">Specializes in a particular therapeutic approach (e.g., CBT, DBT)</label>
              </div>
              <div class="option-group">
                <input type="checkbox" id="qualityOther" name="therapistQualities[]" value="other" />
                <label for="qualityOther">Other: </label>
                <input type="text" id="otherQuality" name="otherQuality" placeholder="Please specify" class="other-input" />
              </div>
              <div class="error-message">Please select at least one quality or specify other</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page15">
            <div class="form-group">
              <label>Are you looking for a therapist of a specific gender?</label>
              <div class="option-group">
                <input type="radio" id="genderNoPreference" name="therapistGender" value="no-preference" required />
                <label for="genderNoPreference">No preference</label>
              </div>
              <div class="option-group">
                <input type="radio" id="genderMale" name="therapistGender" value="male" />
                <label for="genderMale">Male</label>
              </div>
              <div class="option-group">
                <input type="radio" id="genderFemale" name="therapistGender" value="female" />
                <label for="genderFemale">Female</label>
              </div>
              <div class="option-group">
                <input type="radio" id="genderNonBinary" name="therapistGender" value="non-binary" />
                <label for="genderNonBinary">Non-binary</label>
              </div>
              <div class="option-group">
                <input type="radio" id="genderOther" name="therapistGender" value="other" />
                <label for="genderOther">Other: </label>
                <input type="text" id="otherTherapistGender" name="otherTherapistGender" placeholder="Please specify" class="other-input" />
              </div>
              <div class="error-message">Please select a gender preference or specify other</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page16">
            <div class="form-group">
              <label>Do you have any specific health conditions or challenges that impact your mental health?</label>
              <div class="option-group">
                <input type="radio" id="healthYes" name="healthCondition" value="yes" required />
                <label for="healthYes">Yes (Please specify below):</label>
              </div>
              <div class="option-group">
                <input type="radio" id="healthNo" name="healthCondition" value="no" />
                <label for="healthNo">No</label>
              </div>
              <input type="text" id="healthDetails" name="healthDetails" placeholder="If yes, please specify" class="other-input hidden" />
              <div class="error-message">Please select an option and specify details if yes</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page17">
            <div class="form-group">
              <label>Are there any triggers or sensitivities that you would like your therapist to be aware of?</label>
              <div class="option-group">
                <input type="radio" id="triggersYes" name="triggers" value="yes" required />
                <label for="triggersYes">Yes (Please specify below):</label>
              </div>
              <div class="option-group">
                <input type="radio" id="triggersNo" name="triggers" value="no" />
                <label for="triggersNo">No</label>
              </div>
              <input type="text" id="triggerDetails" name="triggerDetails" placeholder="If yes, please specify" class="other-input hidden" />
              <div class="error-message">Please select an option and specify details if yes</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page18" >
            <div class="form-group">
              <label>How do you typically cope with stress or difficult emotions?</label>
              <textarea id="coping" name="coping" rows="4" placeholder="Share your coping strategies"></textarea>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page19">
            <div class="form-group">
              <label>How did you hear about Luna Health?</label>
              <div class="option-group">
                <input type="radio" id="sourceSocial" name="source" value="social-media" required />
                <label for="sourceSocial">Social media</label>
              </div>
              <div class="option-group">
                <input type="radio" id="sourceReferral" name="source" value="referral" />
                <label for="sourceReferral">Referral (Friend/Family)</label>
              </div>
              <div class="option-group">
                <input type="radio" id="sourceInternet" name="source" value="internet" />
                <label for="sourceInternet">Internet search</label>
              </div>
              <div class="option-group">
                <input type="radio" id="sourceOther" name="source" value="other" />
                <label for="sourceOther">Other: </label>
                <input type="text" id="sourceOtherText" name="sourceOtherText" placeholder="Please specify" class="other-input" />
              </div>
              <div class="error-message">Please select a source or specify other</div>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="button" class="btn btn-next">Next</button>
            </div>
          </div>

          <div class="form-page" id="page20">
            <div class="form-group">
              <label>Is there anything else you would like us to know to help match you with the right therapist?</label>
              <textarea id="additionalInfo" name="additionalInfo" rows="4" placeholder="Your comments..."></textarea>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-prev">Previous</button>
              <button type="submit" class="btn btn-submit">Submit</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <script src="js/questionnaire.js" type="module"></script>
  </body>
</html>