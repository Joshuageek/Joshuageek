import React, { useState } from 'react';
import { CSSTransition, TransitionGroup } from 'react-transition-group';
import './Questionnaire.css';

const Questionnaire = () => {
  const [step, setStep] = useState(1);
  const [formData, setFormData] = useState({
    fullName: '',
    age: '',
    gender: '',
    location: '',
    therapyReasons: [],
    therapyReasonsOther: '',
    therapyGoals: [],
    therapyGoalsOther: '',
    attendedTherapy: '',
    previousTherapies: [],
    therapyTypes: [],
    communicationMethod: '',
    sessionFrequency: '',
    convenientTime: '',
    therapistQualities: [],
    therapistQualitiesOther: '',
    therapistGenderPreference: '',
    healthConditions: '',
    healthConditionsDetail: '',
    triggers: '',
    triggersDetail: '',
    copingStrategies: '',
    referralSource: '',
    additionalInfo: '',
  });

  // Handle input changes for text and select inputs
  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value,
    }));
  };

  // Handle checkbox changes (multiple selections)
  const handleCheckboxChange = (e, field) => {
    const { value, checked } = e.target;
    setFormData(prev => {
      const list = prev[field] || [];
      return {
        ...prev,
        [field]: checked ? [...list, value] : list.filter(item => item !== value),
      };
    });
  };

  const handleNext = () => {
    if (step < 7) setStep(prev => prev + 1);
  };

  const handleBack = () => {
    if (step > 1) setStep(prev => prev - 1);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    // Here you could send formData to your backend
    console.log("Form Submitted:", formData);
    alert("Thank you for completing the questionnaire!");
  };

  // Calculate progress percentage based on the step (7 steps)
  const progressPercent = (step / 7) * 100;

  // Helper to render each step content
  const renderStep = () => {
    switch (step) {
      case 1:
        return (
          <div className="step-content">
            <h2>Basic Information</h2>
            <label>
              Full Name:
              <input 
                type="text" 
                name="fullName" 
                value={formData.fullName} 
                onChange={handleChange} 
                required 
              />
            </label>
            <label>
              Age:
              <select name="age" value={formData.age} onChange={handleChange} required>
                <option value="">Select Age</option>
                {[...Array(100)].map((_, i) => (
                  <option key={i+1} value={i+1}>{i+1}</option>
                ))}
              </select>
            </label>
            <label>
              Gender:
              <select name="gender" value={formData.gender} onChange={handleChange} required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Non-binary">Non-binary</option>
                <option value="Prefer not to say">Prefer not to say</option>
              </select>
            </label>
            <label>
              Location (District):
              <input 
                type="text" 
                name="location" 
                value={formData.location} 
                onChange={handleChange} 
                required 
              />
            </label>
          </div>
        );
      case 2:
        return (
          <div className="step-content">
            <h2>Your Mental Health & Therapy Goals</h2>
            <fieldset>
              <legend>Primary reasons for seeking therapy (Select all that apply):</legend>
              {["Anxiety", "Depression", "Stress management", "Relationship issues", "Personal growth & self-improvement", "Trauma recovery", "Life transitions", "Managing a specific mental health condition"].map(option => (
                <label key={option}>
                  <input 
                    type="checkbox" 
                    value={option}
                    onChange={(e) => handleCheckboxChange(e, 'therapyReasons')}
                    checked={formData.therapyReasons.includes(option)}
                  />
                  {option}
                </label>
              ))}
              <label>
                Other:
                <input 
                  type="text" 
                  name="therapyReasonsOther" 
                  value={formData.therapyReasonsOther} 
                  onChange={handleChange} 
                />
              </label>
            </fieldset>
            <fieldset>
              <legend>Therapy goals (Select all that apply):</legend>
              {["Reduce symptoms of anxiety or depression", "Improve relationships", "Gain coping strategies for stress", "Increase self-awareness and personal growth", "Resolve past trauma", "Improve emotional regulation"].map(option => (
                <label key={option}>
                  <input 
                    type="checkbox" 
                    value={option}
                    onChange={(e) => handleCheckboxChange(e, 'therapyGoals')}
                    checked={formData.therapyGoals.includes(option)}
                  />
                  {option}
                </label>
              ))}
              <label>
                Other:
                <input 
                  type="text" 
                  name="therapyGoalsOther" 
                  value={formData.therapyGoalsOther} 
                  onChange={handleChange} 
                />
              </label>
            </fieldset>
          </div>
        );
      case 3:
        return (
          <div className="step-content">
            <h2>Therapy Experience</h2>
            <label>
              Have you ever attended therapy before?
              <div className="radio-group">
                <label>
                  <input 
                    type="radio" 
                    name="attendedTherapy" 
                    value="Yes, currently in therapy" 
                    onChange={handleChange} 
                    required
                  />
                  Yes, currently in therapy
                </label>
                <label>
                  <input 
                    type="radio" 
                    name="attendedTherapy" 
                    value="Yes, in the past" 
                    onChange={handleChange} 
                  />
                  Yes, in the past
                </label>
                <label>
                  <input 
                    type="radio" 
                    name="attendedTherapy" 
                    value="No" 
                    onChange={handleChange} 
                  />
                  No
                </label>
              </div>
            </label>
            {formData.attendedTherapy !== 'No' && (
              <fieldset>
                <legend>If yes, what kind of therapy did you receive? (Select all that apply)</legend>
                {["Individual therapy", "Couples therapy", "Family therapy", "Group therapy"].map(option => (
                  <label key={option}>
                    <input 
                      type="checkbox" 
                      value={option}
                      onChange={(e) => handleCheckboxChange(e, 'previousTherapies')}
                      checked={formData.previousTherapies.includes(option)}
                    />
                    {option}
                  </label>
                ))}
              </fieldset>
            )}
          </div>
        );
      case 4:
        return (
          <div className="step-content">
            <h2>Therapy Preferences</h2>
            <fieldset>
              <legend>What type of therapy are you interested in? (Select all that apply)</legend>
              {["Individual therapy", "Couples therapy", "Family therapy", "Group therapy"].map(option => (
                <label key={option}>
                  <input 
                    type="checkbox" 
                    value={option}
                    onChange={(e) => handleCheckboxChange(e, 'therapyTypes')}
                    checked={formData.therapyTypes.includes(option)}
                  />
                  {option}
                </label>
              ))}
            </fieldset>
            <label>
              Preferred communication method:
              <select name="communicationMethod" value={formData.communicationMethod} onChange={handleChange} required>
                <option value="">Select</option>
                <option value="Video calls">Video calls</option>
                <option value="Audio calls">Audio calls</option>
                <option value="Text/chat-based consultations">Text/chat-based consultations</option>
              </select>
            </label>
            <label>
              Session frequency:
              <select name="sessionFrequency" value={formData.sessionFrequency} onChange={handleChange} required>
                <option value="">Select Frequency</option>
                <option value="Once a week">Once a week</option>
                <option value="Every two weeks">Every two weeks</option>
                <option value="Once a month">Once a month</option>
                <option value="As needed">As needed</option>
              </select>
            </label>
            <label>
              Most convenient time:
              <select name="convenientTime" value={formData.convenientTime} onChange={handleChange} required>
                <option value="">Select Time</option>
                <option value="Morning">Morning (8 AM - 12 PM)</option>
                <option value="Afternoon">Afternoon (12 PM - 4 PM)</option>
                <option value="Evening">Evening (4 PM - 8 PM)</option>
              </select>
            </label>
          </div>
        );
      case 5:
        return (
          <div className="step-content">
            <h2>Therapist Preferences</h2>
            <fieldset>
              <legend>Important qualities in a therapist (Select all that apply):</legend>
              {["Empathy & active listening", "Experience with a specific mental health issue", "A practical, solution-focused approach", "A therapist who is gentle and nurturing", "A therapist who challenges me to grow", "Specialized therapeutic approach"].map(option => (
                <label key={option}>
                  <input 
                    type="checkbox" 
                    value={option}
                    onChange={(e) => handleCheckboxChange(e, 'therapistQualities')}
                    checked={formData.therapistQualities.includes(option)}
                  />
                  {option}
                </label>
              ))}
              <label>
                Other:
                <input 
                  type="text" 
                  name="therapistQualitiesOther" 
                  value={formData.therapistQualitiesOther} 
                  onChange={handleChange} 
                />
              </label>
            </fieldset>
            <label>
              Therapist gender preference:
              <select name="therapistGenderPreference" value={formData.therapistGenderPreference} onChange={handleChange} required>
                <option value="">Select</option>
                <option value="No preference">No preference</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Non-binary">Non-binary</option>
                <option value="Other">Other</option>
              </select>
            </label>
          </div>
        );
      case 6:
        return (
          <div className="step-content">
            <h2>Health Conditions & Coping</h2>
            <label>
              Do you have any specific health conditions affecting your mental health?
              <select name="healthConditions" value={formData.healthConditions} onChange={handleChange} required>
                <option value="">Select</option>
                <option value="Yes">Yes (Please specify below)</option>
                <option value="No">No</option>
              </select>
            </label>
            {formData.healthConditions === "Yes" && (
              <label>
                Please specify:
                <input 
                  type="text" 
                  name="healthConditionsDetail" 
                  value={formData.healthConditionsDetail} 
                  onChange={handleChange} 
                />
              </label>
            )}
            <label>
              Any triggers or sensitivities?
              <select name="triggers" value={formData.triggers} onChange={handleChange} required>
                <option value="">Select</option>
                <option value="Yes">Yes (Please specify below)</option>
                <option value="No">No</option>
              </select>
            </label>
            {formData.triggers === "Yes" && (
              <label>
                Please specify:
                <input 
                  type="text" 
                  name="triggersDetail" 
                  value={formData.triggersDetail} 
                  onChange={handleChange} 
                />
              </label>
            )}
            <label>
              How do you typically cope with stress or difficult emotions?
              <textarea 
                name="copingStrategies" 
                value={formData.copingStrategies} 
                onChange={handleChange} 
                rows="4" 
              />
            </label>
          </div>
        );
      case 7:
        return (
          <div className="step-content">
            <h2>Final Step</h2>
            <label>
              How did you hear about SwiftDoc Health?
              <select name="referralSource" value={formData.referralSource} onChange={handleChange} required>
                <option value="">Select</option>
                <option value="Social media">Social media</option>
                <option value="Referral">Referral (Friend/Family)</option>
                <option value="Internet search">Internet search</option>
                <option value="Other">Other</option>
              </select>
            </label>
            <label>
              Any additional information:
              <textarea 
                name="additionalInfo" 
                value={formData.additionalInfo} 
                onChange={handleChange} 
                rows="4" 
              />
            </label>
          </div>
        );
      default:
        return null;
    }
  };

  return (
    <div className="questionnaire-container">
      <h1>SwiftDoc Health - Teletherapy Welcome Questionnaire</h1>
      {/* Progress Bar */}
      <div className="progress-bar">
        <div className="progress" style={{ width: `${progressPercent}%` }}></div>
      </div>
      <form onSubmit={handleSubmit}>
        <TransitionGroup>
          <CSSTransition
            key={step}
            timeout={500}
            classNames="fade"
          >
            <div className="step">{renderStep()}</div>
          </CSSTransition>
        </TransitionGroup>
        <div className="navigation-buttons">
          {step > 1 && <button type="button" onClick={handleBack}>Back</button>}
          {step < 7 && <button type="button" onClick={handleNext}>Next</button>}
          {step === 7 && <button type="submit">Submit</button>}
        </div>
      </form>
    </div>
  );
};

export default Questionnaire;
