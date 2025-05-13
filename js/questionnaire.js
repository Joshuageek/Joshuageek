// Constants
const STORAGE_KEY = "questionnaireProgress";
const FORM_SELECTOR = "#questionnaireForm";
const PAGE_SELECTOR = ".form-page";
const PROGRESS_BAR_SELECTOR = "#progressBar";

// DOM Elements
const form = document.querySelector(FORM_SELECTOR);
const pages = document.querySelectorAll(PAGE_SELECTOR);
const progressBar = document.querySelector(PROGRESS_BAR_SELECTOR);
const currentPageInput = document.querySelector("#current_page");

// State
let currentPage = 0;
let isEmailValid = false;
let isEmailChecking = false;

// Conditional Fields Configuration
const CONDITIONAL_FIELDS_CONFIG = [
  { trigger: "#healthYes", target: "#healthDetails", value: "yes" },
  { trigger: "#triggersYes", target: "#triggerDetails", value: "yes" },
  { trigger: "#reasonOther", target: "#otherReason", value: "other" },
  { trigger: "#goalOther", target: "#otherGoal", value: "other" },
  { trigger: "#qualityOther", target: "#otherQuality", value: "other" },
  { trigger: "#genderOther", target: "#otherTherapistGender", value: "other" },
  { trigger: "#sourceOther", target: "#sourceOtherText", value: "other" },
];

// Initialize the application
function init() {
  loadProgress();
  setupEventListeners();
  initConditionalFields();
  showPage(currentPage);
}

// Load saved progress from localStorage
function loadProgress() {
  const savedProgress = localStorage.getItem(STORAGE_KEY);
  if (!savedProgress) return;

  try {
    const progress = JSON.parse(savedProgress);
    currentPage = progress.currentPage || 0;

    // Restore form data
    if (progress.formData) {
      Object.entries(progress.formData).forEach(([key, value]) => {
        let inputName = key;
        // Only append [] for checkbox arrays
        if (Array.isArray(value)) {
          inputName = key.endsWith("[]") ? key : key + "[]";
        }
        const inputs = form.querySelectorAll(`[name="${inputName}"]`);
        inputs.forEach((input) => {
          if (input.type === "checkbox" || input.type === "radio") {
            input.checked = Array.isArray(value)
              ? value.includes(input.value)
              : input.value === value;
          } else {
            input.value = typeof value === "string" ? value : "";
          }
        });
      });
    }

    updateConditionalFields();
    // Check email validity if on email page
    const emailInput = form.querySelector('input[name="email"]');
    if (emailInput && emailInput.value) {
      checkEmail(emailInput.value);
    }
  } catch (error) {
    console.error("Error loading saved progress:", error);
    localStorage.removeItem(STORAGE_KEY);
  }
}

// Set up event listeners
function setupEventListeners() {
  // Button clicks using event delegation
  document.addEventListener("click", handleButtonClick);

  // Form submission
  form.addEventListener("submit", handleFormSubmit);

  // Save progress on input changes
  form.addEventListener("input", debounce(saveProgress, 300));
  form.addEventListener("change", saveProgress);

  // Email real-time validation
  const emailInput = form.querySelector('input[name="email"]');
  if (emailInput) {
    emailInput.addEventListener(
      "input",
      debounce(() => checkEmail(emailInput.value), 500)
    );
    emailInput.addEventListener("blur", () => checkEmail(emailInput.value));
  }
}

// Handle button clicks
function handleButtonClick(e) {
  if (e.target.classList.contains("btn-next")) {
    e.preventDefault();
    nextPage();
  } else if (e.target.classList.contains("btn-prev")) {
    e.preventDefault();
    prevPage();
  }
}

// Check email existence via AJAX
async function checkEmail(email) {
  if (!email || isEmailChecking) return;

  const emailInput = form.querySelector('input[name="email"]');
  const group = emailInput.closest(".form-group");
  const errorMessage = group.querySelector(".error-message");
  const nextButton = pages[currentPage].querySelector(".btn-next");

  // Reset previous state
  group.classList.remove("error", "success");
  errorMessage.style.display = "none";
  if (nextButton) nextButton.disabled = false;
  isEmailValid = false;

  if (!isValidEmail(email)) {
    group.classList.add("error");
    errorMessage.textContent = "Please enter a valid email address";
    errorMessage.style.display = "block";
    if (nextButton) nextButton.disabled = true;
    return;
  }

  isEmailChecking = true;

  try {
    const response = await fetch("php/question.inc.php?action=check_email", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: `email=${encodeURIComponent(email)}`,
    });

    const data = await response.json();

    if (data.success && data.exists) {
      group.classList.add("error");
      errorMessage.textContent =
        "This email is already registered. Please use a different email.";
      errorMessage.style.display = "block";
      if (nextButton) nextButton.disabled = true;
      isEmailValid = false;
    } else if (data.success) {
      group.classList.add("success");
      errorMessage.textContent = "Email is available!";
      errorMessage.style.display = "block";
      if (nextButton) nextButton.disabled = false;
      isEmailValid = true;
    } else {
      group.classList.add("error");
      errorMessage.textContent =
        data.message || "Error checking email. Please try again.";
      errorMessage.style.display = "block";
      if (nextButton) nextButton.disabled = true;
      isEmailValid = false;
    }
  } catch (error) {
    console.error("Email check error:", error);
    group.classList.add("error");
    errorMessage.textContent = "Network error. Please try again.";
    errorMessage.style.display = "block";
    if (nextButton) nextButton.disabled = true;
    isEmailValid = false;
  } finally {
    isEmailChecking = false;
  }
}

// Initialize conditional fields
function initConditionalFields() {
  CONDITIONAL_FIELDS_CONFIG.forEach((config) => {
    const { trigger, target, value } = config;
    const triggerEl = document.querySelector(trigger);
    const targetEl = document.querySelector(target);

    if (!triggerEl || !targetEl) {
      console.warn(
        `Conditional field config invalid: trigger=${trigger}, target=${target}`
      );
      return;
    }

    const updateVisibility = () => {
      let shouldShow = false;
      if (triggerEl.type === "radio") {
        const radioGroupName = triggerEl.name;
        const selectedValue = form.querySelector(
          `input[name="${radioGroupName}"]:checked`
        )?.value;
        shouldShow = selectedValue === value;
      } else if (triggerEl.type === "checkbox") {
        shouldShow = triggerEl.checked;
      } else {
        shouldShow = triggerEl.value === value;
      }

      targetEl.classList.toggle("hidden", !shouldShow);
      targetEl.disabled = !shouldShow;
      if (!shouldShow) {
        targetEl.value = "";
      }
    };

    const eventType =
      triggerEl.type === "checkbox" || triggerEl.type === "radio"
        ? "change"
        : "input";

    if (triggerEl.type === "radio") {
      form
        .querySelectorAll(`input[name="${triggerEl.name}"]`)
        .forEach((radio) => {
          radio.addEventListener(eventType, () => {
            updateVisibility();
            saveProgress();
          });
        });
    } else {
      triggerEl.addEventListener(eventType, () => {
        updateVisibility();
        saveProgress();
      });
    }

    updateVisibility();
  });
}

// Update conditional fields visibility
function updateConditionalFields() {
  CONDITIONAL_FIELDS_CONFIG.forEach((config) => {
    const { trigger, target, value } = config;
    const triggerEl = document.querySelector(trigger);
    const targetEl = document.querySelector(target);

    if (!triggerEl || !targetEl) return;

    let shouldShow = false;
    if (triggerEl.type === "radio") {
      const selectedValue = form.querySelector(
        `input[name="${triggerEl.name}"]:checked`
      )?.value;
      shouldShow = selectedValue === value;
    } else if (triggerEl.type === "checkbox") {
      shouldShow = triggerEl.checked;
    } else {
      shouldShow = triggerEl.value === value;
    }

    targetEl.classList.toggle("hidden", !shouldShow);
    targetEl.disabled = !shouldShow;
  });
}

// Show specific page
function showPage(pageIndex) {
  pages.forEach((page, index) => {
    page.classList.toggle("active", index === pageIndex);
  });
  if (currentPageInput) currentPageInput.value = pageIndex;
  window.scrollTo({ top: 0, behavior: "smooth" });
  updateProgressBar();
}

// Update progress bar
function updateProgressBar() {
  if (progressBar) {
    const progressPercentage = (currentPage / (pages.length - 1)) * 100;
    progressBar.style.width = `${progressPercentage}%`;
  }
}

// Save progress to localStorage
function saveProgress() {
  const formDataObj = {};

  // Collect all inputs
  form.querySelectorAll("input, select, textarea").forEach((input) => {
    const name = input.name;
    if (!name) return;

    if (input.type === "checkbox" && name.endsWith("[]")) {
      const baseName = name.replace("[]", "");
      if (!formDataObj[baseName]) formDataObj[baseName] = [];
      if (input.checked) {
        formDataObj[baseName].push(input.value);
      }
    } else if (input.type === "radio" && input.checked) {
      formDataObj[name] = input.value;
    } else if (input.type !== "checkbox" && input.type !== "radio") {
      formDataObj[name] = input.value;
    }
  });

  localStorage.setItem(
    STORAGE_KEY,
    JSON.stringify({
      currentPage,
      formData: formDataObj,
    })
  );
}

// Validate current page
function validateCurrentPage() {
  const currentPageEl = pages[currentPage];
  let isValid = true;

  // Reset errors
  currentPageEl
    .querySelectorAll(".error")
    .forEach((el) => el.classList.remove("error"));
  currentPageEl
    .querySelectorAll(".success")
    .forEach((el) => el.classList.remove("success"));
  currentPageEl.querySelectorAll(".error-message").forEach((el) => {
    el.style.display = "none";
    el.textContent = "";
  });

  // Validate required fields
  currentPageEl.querySelectorAll("[required]").forEach((input) => {
    const group = input.closest(".form-group");
    const errorMessage = group ? group.querySelector(".error-message") : null;

    if (input.closest(".hidden")) return;

    if (input.type === "checkbox" || input.type === "radio") {
      const name = input.name.replace("[]", "");
      const checked =
        currentPageEl.querySelectorAll(
          `[name="${name}"]:checked, [name="${name}[]"]:checked`
        ).length > 0;

      if (!checked) {
        markAsInvalid(group, errorMessage, "Please select at least one option");
        isValid = false;
      }
    } else if (!input.value.trim()) {
      markAsInvalid(group, errorMessage, "This field is required");
      isValid = false;
    } else if (input.type === "email" && !isValidEmail(input.value)) {
      markAsInvalid(group, errorMessage, "Please enter a valid email address");
      isValid = false;
    } else if (input.name === "email" && !isEmailValid) {
      markAsInvalid(group, errorMessage, "This email is already registered");
      isValid = false;
    } else if (
      input.type === "number" &&
      (isNaN(input.value) || input.value < 18 || input.value > 120)
    ) {
      markAsInvalid(group, errorMessage, "Please enter a valid age (18-120)");
      isValid = false;
    }
  });

  // Validate conditional "other" fields
  CONDITIONAL_FIELDS_CONFIG.forEach((config) => {
    const { trigger, target, value } = config;
    const triggerEl = currentPageEl.querySelector(trigger);
    const targetEl = currentPageEl.querySelector(target);

    if (!triggerEl || !targetEl) return;

    let isActive = false;
    if (triggerEl.type === "radio") {
      const selectedValue = form.querySelector(
        `input[name="${triggerEl.name}"]:checked`
      )?.value;
      isActive = selectedValue === value;
    } else if (triggerEl.type === "checkbox") {
      isActive = triggerEl.checked;
    } else {
      isActive = triggerEl.value === value;
    }

    if (
      isActive &&
      !targetEl.value.trim() &&
      targetEl.hasAttribute("required")
    ) {
      const group = targetEl.closest(".form-group");
      const errorMessage = group ? group.querySelector(".error-message") : null;
      markAsInvalid(group, errorMessage, "Please specify this field");
      isValid = false;
    }
  });

  // Validate required checkbox groups
  ["therapyReasons[]", "therapyGoals[]", "therapyInterest[]"].forEach(
    (name) => {
      const checkboxes = currentPageEl.querySelectorAll(`[name="${name}"]`);
      const checked =
        currentPageEl.querySelectorAll(`[name="${name}"]:checked`).length > 0;
      const group = checkboxes[0]?.closest(".form-group");
      const errorMessage = group?.querySelector(".error-message");

      if (!checked && group) {
        markAsInvalid(group, errorMessage, "Please select at least one option");
        isValid = false;
      }
    }
  );

  return isValid;
}

// Mark field as invalid
function markAsInvalid(group, errorMessage, message) {
  if (group) group.classList.add("error");
  if (errorMessage) {
    errorMessage.textContent = message;
    errorMessage.style.display = "block";
  }
}

// Email validation helper
function isValidEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// Debounce helper function
function debounce(func, wait) {
  let timeout;
  return function (...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(this, args), wait);
  };
}

// Navigation functions
function nextPage() {
  if (currentPage < pages.length - 1 && validateCurrentPage()) {
    currentPage++;
    showPage(currentPage);
    saveProgress();
  }
}

function prevPage() {
  if (currentPage > 0) {
    currentPage--;
    showPage(currentPage);
    saveProgress();
  }
}

// Form submission handler
async function handleFormSubmit(e) {
  e.preventDefault();
  if (!validateCurrentPage()) {
    console.log("Validation failed on current page");
    return;
  }

  try {
    const formData = new FormData(form);
    console.log("FormData contents:");
    for (const [key, value] of formData.entries()) {
      console.log(`${key}: ${value}`);
    }
    console.log("Checkbox inputs:");
    form.querySelectorAll('input[type="checkbox"]').forEach((input) => {
      console.log(
        `${input.name}: ${input.checked ? input.value : "unchecked"}`
      );
    });

    const response = await fetch(form.action, {
      method: "POST",
      body: formData,
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    });

    const responseText = await response.text();
    let data;
    try {
      data = JSON.parse(responseText);
      console.log("Server response:", data);
    } catch {
      throw new Error(`Invalid server response: ${responseText}`);
    }

    if (!response.ok) {
      const errorMessage = data.error_details
        ? `${data.message}: ${data.error_details}`
        : data.message || `HTTP error! status: ${response.status}`;
      throw new Error(errorMessage);
    }

    if (data.success) {
      console.log("Form submitted successfully, clearing localStorage");
      localStorage.removeItem(STORAGE_KEY);
      window.location.href = data.redirect || "paywall/paywall.php";
    } else {
      showError(data.message || "Failed to submit form. Please try again.");
    }
  } catch (error) {
    console.error("Submission error:", error);
    showError(`Submission failed: ${error.message}`);
  }
}

// Show error message
function showError(message) {
  const existingError = document.querySelector(".global-error");
  if (existingError) existingError.remove();

  const errorContainer = document.createElement("div");
  errorContainer.className = "global-error";
  errorContainer.style.position = "fixed";
  errorContainer.style.top = "20px";
  errorContainer.style.left = "50%";
  errorContainer.style.transform = "translateX(-50%)";
  errorContainer.style.backgroundColor = "#ff6b6b";
  errorContainer.style.color = "white";
  errorContainer.style.padding = "15px 25px";
  errorContainer.style.borderRadius = "8px";
  errorContainer.style.zIndex = "1000";
  errorContainer.textContent = message;

  document.body.appendChild(errorContainer);
  setTimeout(() => errorContainer.remove(), 5000);
}

// Initialize the app when DOM is loaded
document.addEventListener("DOMContentLoaded", init);
