// Sidebar toggle for mobile
document.getElementById("sidebarToggle")?.addEventListener("click", () => {
  document.getElementById("sidebar").classList.toggle("show");
});

// Navigation
document.querySelectorAll(".nav-link").forEach((link) => {
  link.addEventListener("click", function (e) {
    if (this.getAttribute("href") !== "../logout.php") {
      e.preventDefault();
      document
        .querySelectorAll(".nav-link")
        .forEach((l) => l.classList.remove("active"));
      this.classList.add("active");
    }
  });
});

// Approval buttons
document.querySelectorAll(".btn-success-custom").forEach((btn) => {
  btn.addEventListener("click", function () {
    if (confirm("Are you sure you want to approve this therapist?")) {
      this.textContent = "Approved";
      this.disabled = true;
      this.classList.remove("btn-success-custom");
      this.classList.add("btn-outline-custom");
    }
  });
});

// Search functionality
document
  .querySelector(".search-box input")
  ?.addEventListener("input", function () {
    // Implement search functionality here
    console.log("Searching for:", this.value);
  });

// Notification click
document.querySelector(".notification-btn")?.addEventListener("click", () => {
  // Show notifications dropdown
  alert("System notifications would appear here");
});

// Auto-refresh data every 30 seconds
setInterval(() => {
  // Refresh dashboard data
  console.log("Refreshing dashboard data...");
}, 30000);

// Initialize tooltips
document.addEventListener("DOMContentLoaded", () => {
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(
    (tooltipTriggerEl) => new window.bootstrap.Tooltip(tooltipTriggerEl)
  );
});

// Form validation
function validateForm(formId) {
  const form = document.getElementById(formId);
  const inputs = form.querySelectorAll(
    "input[required], select[required], textarea[required]"
  );
  let isValid = true;

  inputs.forEach((input) => {
    if (!input.value.trim()) {
      input.classList.add("is-invalid");
      isValid = false;
    } else {
      input.classList.remove("is-invalid");
    }
  });

  return isValid;
}

// AJAX helper function
function makeAjaxRequest(url, method, data, callback) {
  const xhr = new XMLHttpRequest();
  xhr.open(method, url, true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onreadystatechange = () => {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        callback(null, JSON.parse(xhr.responseText));
      } else {
        callback(new Error("Request failed"), null);
      }
    }
  };

  xhr.send(JSON.stringify(data));
}

// Show loading spinner
function showLoading(element) {
  element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
  element.disabled = true;
}

// Hide loading spinner
function hideLoading(element, originalText) {
  element.innerHTML = originalText;
  element.disabled = false;
}

// Show toast notification
function showToast(message, type = "success") {
  const toast = document.createElement("div");
  toast.className = `toast align-items-center text-white bg-${type} border-0`;
  toast.setAttribute("role", "alert");
  toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;

  document.body.appendChild(toast);
  const bsToast = new window.bootstrap.Toast(toast);
  bsToast.show();

  toast.addEventListener("hidden.bs.toast", () => {
    document.body.removeChild(toast);
  });
}
