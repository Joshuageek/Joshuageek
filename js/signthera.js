document.addEventListener("DOMContentLoaded", function () {
  // Function to handle "Other" option visibility and validation
  function handleOtherOption(selectElement) {
    const otherContainer = selectElement.nextElementSibling;
    const otherInput = otherContainer.querySelector("input");

    // Check if "Other" is selected
    const isOtherSelected = Array.from(selectElement.selectedOptions).some(
      (option) => option.value === "other"
    );

    if (isOtherSelected) {
      otherContainer.style.display = "block";
      if (otherInput) otherInput.required = true;
    } else {
      otherContainer.style.display = "none";
      if (otherInput) {
        otherInput.required = false;
        otherInput.value = ""; // Clear input when hidden
      }
    }
  }

  // Initialize all "Other" option dropdowns
  const otherDropdowns = document.querySelectorAll("select.other-dropdown");
  otherDropdowns.forEach((dropdown) => {
    dropdown.addEventListener("change", function () {
      handleOtherOption(this);
    });
    // Initialize on page load
    handleOtherOption(dropdown);
  });

  // File input change handler to display file name
  const fileInputs = document.querySelectorAll('input[type="file"]');
  fileInputs.forEach((input) => {
    input.addEventListener("change", function () {
      const fileNameDisplay =
        this.parentElement.querySelector(".file-selected");
      if (this.files.length > 0) {
        fileNameDisplay.textContent = this.files[0].name;
      } else {
        fileNameDisplay.textContent = "No file selected";
      }
    });
  });

  // Form validation on submit
  const form = document.querySelector("form");
  const submitBtn = document.getElementById("submit-btn");
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // Reset error styles
    resetErrorStyles();

    // Validate all fields
    const isValid = validateForm();

    if (isValid) {
      // Disable button and show loading state
      submitBtn.disabled = true;
      submitBtn.textContent = "Submitting...";
      this.submit();
    }
  });

  function resetErrorStyles() {
    // Remove error styles from all fields
    const fields = document.querySelectorAll("input, select, textarea");
    fields.forEach((field) => {
      field.style.borderColor = "#ddd";
      const errorMessage = field.nextElementSibling;
      if (errorMessage && errorMessage.classList.contains("error-message")) {
        errorMessage.remove();
      }
    });
    // Clear file upload error messages
    document.querySelectorAll(".file-upload").forEach((upload) => {
      const errorMessage = upload.nextElementSibling;
      if (errorMessage && errorMessage.classList.contains("error-message")) {
        errorMessage.remove();
      }
    });
  }

  function validateForm() {
    let isValid = true;

    // Personal Information Validation
    isValid =
      validateRequiredField("full-name", "Full name is required") && isValid;
    isValid = validateEmail("email") && isValid;
    isValid = validatePhone("phone") && isValid;
    isValid =
      validateRequiredField("location", "Please select your district") &&
      isValid;
    isValid =
      validateFileUpload("id-upload", "Please upload your ID document") &&
      isValid;

    // Professional Details Validation
    isValid =
      validateRequiredField(
        "specialization",
        "Please select your specialization"
      ) && isValid;
    // Validate "Other" specialization if selected
    if (document.getElementById("specialization").value === "other") {
      isValid =
        validateRequiredField(
          "other-specialization",
          "Please specify other specialization"
        ) && isValid;
    }
    isValid =
      validateFileUpload(
        "license-upload",
        "Please upload your professional license"
      ) && isValid;
    isValid =
      validateFileUpload("cv-upload", "Please upload your CV") && isValid;

    // Availability & Language Validation
    isValid =
      validateRequiredField(
        "languages",
        "Please select at least one language"
      ) && isValid;
    // Validate "Other" language if selected
    if (document.getElementById("languages").value === "other") {
      isValid =
        validateRequiredField(
          "other-language",
          "Please specify other language"
        ) && isValid;
    }

    // Tech Readiness Validation
    isValid =
      validateRadioGroup("internet", "Please select internet availability") &&
      isValid;
    isValid =
      validateRadioGroup(
        "video",
        "Please select video conferencing comfort level"
      ) && isValid;
    isValid =
      validateRadioGroup(
        "teletherapy",
        "Please select teletherapy experience"
      ) && isValid;

    // Consent Validation
    isValid =
      validateCheckbox(
        "consent-verification",
        "You must consent to credential verification"
      ) && isValid;
    isValid =
      validateCheckbox(
        "consent-data",
        "You must consent to data usage terms"
      ) && isValid;

    return isValid;
  }

  function validateRequiredField(fieldId, errorMessage) {
    const field = document.getElementById(fieldId);
    if (!field.value.trim()) {
      showError(field, errorMessage);
      return false;
    }
    return true;
  }

  function validateEmail(fieldId) {
    const field = document.getElementById(fieldId);
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!field.value.trim()) {
      showError(field, "Email is required");
      return false;
    }

    if (!emailRegex.test(field.value)) {
      showError(field, "Please enter a valid email address");
      return false;
    }

    return true;
  }

  function validatePhone(fieldId) {
    const field = document.getElementById(fieldId);
    // Flexible Ugandan phone number format: +256 followed by 9 digits, optional spaces
    const phoneRegex = /^\+256\s*\d{3}\s*\d{3}\s*\d{3}$/;

    if (!field.value.trim()) {
      showError(field, "Phone number is required");
      return false;
    }

    if (!phoneRegex.test(field.value)) {
      showError(
        field,
        "Please enter a valid Ugandan phone number (e.g., +256781202892 or +256 781 202 892)"
      );
      return false;
    }

    return true;
  }

  function validateFileUpload(fieldId, errorMessage) {
    const field = document.getElementById(fieldId);
    if (!field.files || field.files.length === 0) {
      showError(field.parentElement, errorMessage);
      return false;
    }

    // Check file type (PDF)
    const file = field.files[0];
    if (file.type !== "application/pdf") {
      showError(field.parentElement, "File must be in PDF format");
      return false;
    }

    // Check file size (max 5MB)
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
    if (file.size > maxSize) {
      showError(field.parentElement, "File size must not exceed 5MB");
      return false;
    }

    return true;
  }

  function validateRadioGroup(name, errorMessage) {
    const radioButtons = document.querySelectorAll(`input[name="${name}"]`);
    let isChecked = false;

    radioButtons.forEach((radio) => {
      if (radio.checked) isChecked = true;
    });

    if (!isChecked) {
      // Show error on the radio group container
      const firstRadio = radioButtons[0];
      showError(firstRadio.parentElement.parentElement, errorMessage);
      return false;
    }

    return true;
  }

  function validateCheckbox(fieldId, errorMessage) {
    const checkbox = document.getElementById(fieldId);
    if (!checkbox.checked) {
      showError(checkbox, errorMessage);
      return false;
    }
    return true;
  }

  function showError(element, message) {
    // Apply error styling to the appropriate element
    if (
      element.tagName === "INPUT" ||
      element.tagName === "SELECT" ||
      element.tagName === "TEXTAREA"
    ) {
      element.style.borderColor = "#ff6b6b";
    }

    // Create or update error message
    let errorMessage = element.nextElementSibling;
    if (!errorMessage || !errorMessage.classList.contains("error-message")) {
      errorMessage = document.createElement("div");
      errorMessage.className = "error-message";
      errorMessage.style.color = "#ff6b6b";
      errorMessage.style.marginTop = "5px";
      errorMessage.style.fontSize = "14px";
      element.parentNode.insertBefore(errorMessage, element.nextSibling);
    }

    errorMessage.textContent = message;
  }
});
