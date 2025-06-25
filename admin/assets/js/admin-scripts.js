// Professional Luna Therapy System Scripts

class LunaTherapySystem {
  constructor() {
    this.init();
    this.bindEvents();
    this.initializeComponents();
  }

  init() {
    // Initialize system
    this.sidebar = document.getElementById("sidebar");
    this.sidebarToggle = document.getElementById("sidebarToggle");
    this.searchInput = document.getElementById("globalSearch");
    this.loadingBar = document.getElementById("loadingBar");

    // Set initial states
    this.isLoading = false;
    this.searchTimeout = null;

    console.log("Luna Therapy System initialized");
  }

  bindEvents() {
    // Sidebar toggle
    if (this.sidebarToggle) {
      this.sidebarToggle.addEventListener("click", () => this.toggleSidebar());
    }

    // Global search
    if (this.searchInput) {
      this.searchInput.addEventListener("input", (e) =>
        this.handleSearch(e.target.value)
      );
      this.searchInput.addEventListener("focus", () =>
        this.showSearchResults()
      );
      this.searchInput.addEventListener("blur", () => this.hideSearchResults());
    }

    // Navigation links
    this.bindNavigationEvents();

    // Notification events
    this.bindNotificationEvents();

    // Quick action events
    this.bindQuickActionEvents();

    // Keyboard shortcuts
    this.bindKeyboardShortcuts();

    // Window events
    window.addEventListener("resize", () => this.handleResize());
    window.addEventListener("beforeunload", () => this.cleanup());
  }

  initializeComponents() {
    // Initialize tooltips
    this.initTooltips();

    // Initialize dropdowns
    this.initDropdowns();

    // Initialize charts if present
    this.initCharts();

    // Initialize real-time updates
    this.initRealTimeUpdates();

    // Initialize form validation
    this.initFormValidation();
  }

  // Sidebar Management
  toggleSidebar() {
    if (this.sidebar) {
      this.sidebar.classList.toggle("show");

      // Update aria attributes
      const isOpen = this.sidebar.classList.contains("show");
      this.sidebarToggle?.setAttribute("aria-expanded", isOpen);

      // Store preference
      localStorage.setItem("sidebarOpen", isOpen);
    }
  }

  // Search Functionality
  handleSearch(query) {
    clearTimeout(this.searchTimeout);

    if (query.length < 2) {
      this.hideSearchResults();
      return;
    }

    this.searchTimeout = setTimeout(() => {
      this.performSearch(query);
    }, 300);
  }

  async performSearch(query) {
    try {
      this.showLoading();

      const response = await fetch("api/search.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ query }),
      });

      const results = await response.json();
      this.displaySearchResults(results);
    } catch (error) {
      console.error("Search failed:", error);
      this.showToast("Search failed. Please try again.", "error");
    } finally {
      this.hideLoading();
    }
  }

  displaySearchResults(results) {
    const resultsContainer = document.getElementById("searchResults");
    if (!resultsContainer) return;

    if (results.length === 0) {
      resultsContainer.innerHTML = `
                <div class="search-no-results">
                    <i class="fas fa-search"></i>
                    <p>No results found</p>
                </div>
            `;
    } else {
      resultsContainer.innerHTML = results
        .map(
          (result) => `
                <div class="search-result-item" data-type="${
                  result.type
                }" data-id="${result.id}">
                    <div class="search-result-icon">
                        <i class="fas ${this.getResultIcon(result.type)}"></i>
                    </div>
                    <div class="search-result-content">
                        <h6>${result.title}</h6>
                        <p>${result.description}</p>
                        <span class="search-result-type">${result.type}</span>
                    </div>
                </div>
            `
        )
        .join("");
    }

    resultsContainer.style.display = "block";
    this.bindSearchResultEvents();
  }

  getResultIcon(type) {
    const icons = {
      patient: "fa-user",
      therapist: "fa-user-md",
      appointment: "fa-calendar",
      session: "fa-video",
      note: "fa-sticky-note",
      assessment: "fa-clipboard-check",
    };
    return icons[type] || "fa-file";
  }

  showSearchResults() {
    const resultsContainer = document.getElementById("searchResults");
    if (resultsContainer && resultsContainer.innerHTML.trim()) {
      resultsContainer.style.display = "block";
    }
  }

  hideSearchResults() {
    setTimeout(() => {
      const resultsContainer = document.getElementById("searchResults");
      if (resultsContainer) {
        resultsContainer.style.display = "none";
      }
    }, 200);
  }

  bindSearchResultEvents() {
    document.querySelectorAll(".search-result-item").forEach((item) => {
      item.addEventListener("click", () => {
        const type = item.dataset.type;
        const id = item.dataset.id;
        this.navigateToResult(type, id);
      });
    });
  }

  navigateToResult(type, id) {
    const routes = {
      patient: `sections/patient-detail.php?id=${id}`,
      therapist: `sections/therapist-detail.php?id=${id}`,
      appointment: `sections/appointment-detail.php?id=${id}`,
      session: `sections/session-detail.php?id=${id}`,
      note: `sections/note-detail.php?id=${id}`,
      assessment: `sections/assessment-detail.php?id=${id}`,
    };

    if (routes[type]) {
      window.location.href = routes[type];
    }
  }

  // Navigation Events
  bindNavigationEvents() {
    document.querySelectorAll(".nav-link").forEach((link) => {
      link.addEventListener("click", (e) => {
        if (link.getAttribute("href") !== "../logout.php") {
          this.setActiveNavItem(link);
        }
      });
    });
  }

  setActiveNavItem(activeLink) {
    // Remove active class from all nav links
    document.querySelectorAll(".nav-link").forEach((link) => {
      link.classList.remove("active");
    });

    // Add active class to clicked link
    activeLink.classList.add("active");

    // Store active page
    localStorage.setItem("activePage", activeLink.getAttribute("href"));
  }

  // Notification Events
  bindNotificationEvents() {
    const notificationBtn = document.querySelector(".notification-btn");
    const markAllRead = document.querySelector(".mark-all-read");

    if (notificationBtn) {
      notificationBtn.addEventListener("click", () => {
        this.markNotificationsAsViewed();
      });
    }

    if (markAllRead) {
      markAllRead.addEventListener("click", () => {
        this.markAllNotificationsAsRead();
      });
    }

    // Bind individual notification clicks
    document.querySelectorAll(".notification-item").forEach((item) => {
      item.addEventListener("click", () => {
        this.handleNotificationClick(item);
      });
    });
  }

  async markAllNotificationsAsRead() {
    try {
      const response = await fetch("api/notifications.php", {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ action: "mark_all_read" }),
      });

      if (response.ok) {
        document
          .querySelectorAll(".notification-item.unread")
          .forEach((item) => {
            item.classList.remove("unread");
          });

        const badge = document.querySelector(".notification-badge");
        if (badge) {
          badge.style.display = "none";
        }

        this.showToast("All notifications marked as read", "success");
      }
    } catch (error) {
      console.error("Failed to mark notifications as read:", error);
    }
  }

  handleNotificationClick(item) {
    const notificationId = item.dataset.id;
    const link = item.dataset.link;

    // Mark as read
    item.classList.remove("unread");

    // Navigate if there's a link
    if (link) {
      window.location.href = link;
    }

    // Update server
    this.markNotificationAsRead(notificationId);
  }

  async markNotificationAsRead(id) {
    try {
      await fetch("api/notifications.php", {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ action: "mark_read", id }),
      });
    } catch (error) {
      console.error("Failed to mark notification as read:", error);
    }
  }

  // Quick Action Events
  bindQuickActionEvents() {
    document.querySelectorAll(".quick-action-btn").forEach((btn) => {
      btn.addEventListener("click", () => {
        const action = btn.getAttribute("title");
        this.handleQuickAction(action, btn);
      });
    });
  }

  handleQuickAction(action, button) {
    // Add loading state
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;

    // Simulate action completion
    setTimeout(() => {
      button.innerHTML = originalContent;
      button.disabled = false;
      this.showToast(`${action} completed`, "success");
    }, 1000);
  }

  // Keyboard Shortcuts
  bindKeyboardShortcuts() {
    document.addEventListener("keydown", (e) => {
      // Ctrl/Cmd + K for search
      if ((e.ctrlKey || e.metaKey) && e.key === "k") {
        e.preventDefault();
        this.focusSearch();
      }

      // Escape to close modals/dropdowns
      if (e.key === "Escape") {
        this.closeAllDropdowns();
        this.hideSearchResults();
      }

      // Ctrl/Cmd + / for help
      if ((e.ctrlKey || e.metaKey) && e.key === "/") {
        e.preventDefault();
        this.showKeyboardShortcuts();
      }
    });
  }

  focusSearch() {
    if (this.searchInput) {
      this.searchInput.focus();
      this.searchInput.select();
    }
  }

  closeAllDropdowns() {
    document.querySelectorAll(".dropdown-menu.show").forEach((dropdown) => {
      dropdown.classList.remove("show");
    });
  }

  showKeyboardShortcuts() {
    this.showToast(
      "Keyboard shortcuts: Ctrl+K (Search), Ctrl+/ (Help), Esc (Close)",
      "info"
    );
  }

  // Loading States
  showLoading() {
    this.isLoading = true;
    if (this.loadingBar) {
      this.loadingBar.classList.add("active");
    }
  }

  hideLoading() {
    this.isLoading = false;
    if (this.loadingBar) {
      this.loadingBar.classList.remove("active");
    }
  }

  // Toast Notifications
  showToast(message, type = "info", duration = 3000) {
    const toast = document.createElement("div");
    toast.className = `toast-notification toast-${type}`;
    toast.innerHTML = `
            <div class="toast-content">
                <i class="fas ${this.getToastIcon(type)}"></i>
                <span>${message}</span>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

    // Add to page
    document.body.appendChild(toast);

    // Animate in
    setTimeout(() => toast.classList.add("show"), 100);

    // Auto remove
    setTimeout(() => {
      toast.classList.remove("show");
      setTimeout(() => toast.remove(), 300);
    }, duration);
  }

  getToastIcon(type) {
    const icons = {
      success: "fa-check-circle",
      error: "fa-exclamation-circle",
      warning: "fa-exclamation-triangle",
      info: "fa-info-circle",
    };
    return icons[type] || "fa-info-circle";
  }

  // Component Initialization
  initTooltips() {
    const tooltipTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(
      (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
    );
  }

  initDropdowns() {
    const dropdownElementList = [].slice.call(
      document.querySelectorAll(".dropdown-toggle")
    );
    dropdownElementList.map(
      (dropdownToggleEl) => new bootstrap.Dropdown(dropdownToggleEl)
    );
  }

  initCharts() {
    // Initialize Chart.js charts if present
    const chartElements = document.querySelectorAll('canvas[id$="Chart"]');
    chartElements.forEach((canvas) => {
      this.createChart(canvas);
    });
  }

  createChart(canvas) {
    const ctx = canvas.getContext("2d");
    const chartType = canvas.dataset.type || "line";
    const chartData = JSON.parse(canvas.dataset.data || "{}");

    new Chart(ctx, {
      type: chartType,
      data: chartData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: "top",
          },
        },
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  }

  initRealTimeUpdates() {
    // Update notifications every 30 seconds
    setInterval(() => {
      this.updateNotifications();
    }, 30000);

    // Update system status every 60 seconds
    setInterval(() => {
      this.updateSystemStatus();
    }, 60000);
  }

  async updateNotifications() {
    try {
      const response = await fetch("api/notifications.php");
      const data = await response.json();

      const badge = document.querySelector(".notification-badge");
      if (badge) {
        badge.textContent = data.unread_count;
        badge.style.display = data.unread_count > 0 ? "block" : "none";
      }
    } catch (error) {
      console.error("Failed to update notifications:", error);
    }
  }

  async updateSystemStatus() {
    try {
      const response = await fetch("api/system-status.php");
      const data = await response.json();

      const statusIndicator = document.querySelector(
        ".system-status .status-indicator"
      );
      const statusText = document.querySelector(
        ".system-status span:last-child"
      );

      if (statusIndicator && statusText) {
        statusIndicator.className = `status-indicator ${data.status}`;
        statusText.textContent = data.message;
      }
    } catch (error) {
      console.error("Failed to update system status:", error);
    }
  }

  initFormValidation() {
    const forms = document.querySelectorAll("form[data-validate]");
    forms.forEach((form) => {
      form.addEventListener("submit", (e) => {
        if (!this.validateForm(form)) {
          e.preventDefault();
        }
      });
    });
  }

  validateForm(form) {
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

  // Utility Methods
  handleResize() {
    // Handle responsive behavior
    if (window.innerWidth <= 992) {
      this.sidebar?.classList.remove("show");
    }
  }

  cleanup() {
    // Cleanup before page unload
    clearTimeout(this.searchTimeout);
  }

  // AJAX Helper
  async makeRequest(url, method = "GET", data = null) {
    try {
      const options = {
        method,
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
      };

      if (data) {
        options.body = JSON.stringify(data);
      }

      const response = await fetch(url, options);

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      return await response.json();
    } catch (error) {
      console.error("Request failed:", error);
      throw error;
    }
  }
}

// Initialize the system when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  window.lunaSystem = new LunaTherapySystem();
});

// Additional utility functions
function formatDate(date) {
  return new Intl.DateTimeFormat("en-US", {
    year: "numeric",
    month: "short",
    day: "numeric",
  }).format(new Date(date));
}

function formatTime(date) {
  return new Intl.DateTimeFormat("en-US", {
    hour: "2-digit",
    minute: "2-digit",
  }).format(new Date(date));
}

function formatCurrency(amount) {
  return new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
  }).format(amount);
}

function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

function throttle(func, limit) {
  let inThrottle;
  return function () {
    const args = arguments;
    const context = this;
    if (!inThrottle) {
      func.apply(context, args);
      inThrottle = true;
      setTimeout(() => (inThrottle = false), limit);
    }
  };
}

// Export for module use
if (typeof module !== "undefined" && module.exports) {
  module.exports = LunaTherapySystem;
}
