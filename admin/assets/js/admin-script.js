// Simple Luna System - No Flickering, No Conflicts
document.addEventListener("DOMContentLoaded", () => {
  // Simple sidebar toggle
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.getElementById("sidebar");
  const sidebarOverlay = document.getElementById("sidebarOverlay");

  // Enhanced sidebar toggle for both mobile and desktop
  function toggleSidebar() {
    if (sidebar && sidebarOverlay) {
      const isOpen = sidebar.classList.contains("show");
      const mainContent = document.querySelector(".main-content");

      if (window.innerWidth <= 991) {
        // Mobile behavior
        if (isOpen) {
          sidebar.classList.remove("show");
          sidebarOverlay.classList.remove("show");
          document.body.style.overflow = "";
        } else {
          sidebar.classList.add("show");
          sidebarOverlay.classList.add("show");
          document.body.style.overflow = "hidden";
        }
      } else {
        // Desktop behavior
        const isDesktopHidden = sidebar.classList.contains("desktop-hidden");

        if (isDesktopHidden) {
          // Show sidebar
          sidebar.classList.remove("desktop-hidden");
          if (mainContent) {
            mainContent.classList.remove("sidebar-hidden");
          }
        } else {
          // Hide sidebar
          sidebar.classList.add("desktop-hidden");
          if (mainContent) {
            mainContent.classList.add("sidebar-hidden");
          }
        }
      }
    }
  }

  // ENHANCED resize handler to properly clean up states
  function handleResize() {
    const mainContent = document.querySelector(".main-content");

    if (window.innerWidth > 991 && sidebar) {
      // Desktop: Clean up ALL mobile classes and states
      sidebar.classList.remove("show");
      sidebarOverlay.classList.remove("show");
      document.body.style.overflow = "";

      // Reset to default desktop state (sidebar visible)
      sidebar.classList.remove("desktop-hidden");
      if (mainContent) {
        mainContent.classList.remove("sidebar-hidden");
        mainContent.style.marginLeft = ""; // Reset inline styles
      }

      console.log("Switched to desktop mode - sidebar reset");
    } else if (window.innerWidth <= 991 && sidebar) {
      // Mobile: Clean up ALL desktop classes and force mobile state
      sidebar.classList.remove("desktop-hidden");
      sidebar.classList.remove("show"); // Start hidden on mobile
      sidebarOverlay.classList.remove("show");
      document.body.style.overflow = "";

      if (mainContent) {
        mainContent.classList.remove("sidebar-hidden");
        mainContent.style.marginLeft = "0"; // Force mobile margin
      }

      console.log("Switched to mobile mode - sidebar hidden");
    }
  }

  // Bind toggle button
  if (sidebarToggle) {
    sidebarToggle.addEventListener("click", toggleSidebar);
  }

  // Close sidebar when clicking overlay
  if (sidebarOverlay) {
    sidebarOverlay.addEventListener("click", toggleSidebar);
  }

  // Enhanced resize handler with debounce
  let resizeTimeout;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(handleResize, 100); // Debounce resize events
  });

  // Initial setup on page load
  handleResize();

  // Simple search with debounce
  const searchInput = document.getElementById("globalSearch");
  let searchTimeout;

  if (searchInput) {
    searchInput.addEventListener("input", (e) => {
      clearTimeout(searchTimeout);
      const query = e.target.value.trim();

      if (query.length > 2) {
        searchTimeout = setTimeout(() => {
          console.log("Searching for:", query);
          // Add your search logic here
        }, 500);
      }
    });
  }

  // Initialize Bootstrap tooltips
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  const bootstrap = window.bootstrap;
  tooltipTriggerList.map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  // Animate Cards on Scroll
  const cards = document.querySelectorAll(".stat-card, .welcome-card");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = "1";
          entry.target.style.transform = "translateY(0)";
        }
      });
    },
    {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px",
    }
  );

  cards.forEach((card) => {
    card.style.opacity = "0";
    card.style.transform = "translateY(20px)";
    card.style.transition = "all 0.6s ease";
    observer.observe(card);
  });

  // Simple keyboard shortcuts
  document.addEventListener("keydown", (e) => {
    // Escape to close sidebar
    if (e.key === "Escape") {
      if (
        sidebar &&
        (sidebar.classList.contains("show") ||
          !sidebar.classList.contains("desktop-hidden"))
      ) {
        toggleSidebar();
      }
    }

    // Ctrl/Cmd + K for search
    if ((e.ctrlKey || e.metaKey) && e.key === "k") {
      e.preventDefault();
      if (searchInput) {
        searchInput.focus();
        searchInput.select();
      }
    }
  });

  // Simple toast notification function
  window.showToast = (message, type = "info") => {
    // Remove existing toasts
    const existingToasts = document.querySelectorAll(".simple-toast");
    existingToasts.forEach((toast) => toast.remove());

    const toast = document.createElement("div");
    toast.className = `simple-toast toast-${type}`;
    toast.innerHTML = `
            <div class="toast-content">
                <i class="fas ${getToastIcon(type)} me-2"></i>
                ${message}
            </div>
            <button onclick="this.parentElement.remove()" class="toast-close">
                <i class="fas fa-times"></i>
            </button>
        `;

    document.body.appendChild(toast);

    // Show toast
    setTimeout(() => toast.classList.add("show"), 100);

    // Auto remove after 3 seconds
    setTimeout(() => {
      toast.classList.remove("show");
      setTimeout(() => toast.remove(), 300);
    }, 3000);
  };

  function getToastIcon(type) {
    const icons = {
      success: "fa-check-circle",
      error: "fa-exclamation-circle",
      warning: "fa-exclamation-triangle",
      info: "fa-info-circle",
    };
    return icons[type] || "fa-info-circle";
  }

  // Simple Notifications
  const notificationDropdown = document.querySelector(
    '[data-bs-toggle="dropdown"]'
  );
  if (notificationDropdown) {
    notificationDropdown.addEventListener("click", () => {
      setTimeout(() => {
        const badge = document.querySelector(".notification-badge");
        if (badge) {
          badge.style.display = "none";
        }
      }, 1000);
    });
  }

  // Utility Functions
  function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", {
      year: "numeric",
      month: "short",
      day: "numeric",
    });
  }

  function formatTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleTimeString("en-US", {
      hour: "2-digit",
      minute: "2-digit",
    });
  }

  // Add loading state to buttons
  document.addEventListener("click", (e) => {
    if (e.target.matches('.btn[href]:not([href^="#"])')) {
      const btn = e.target;
      const originalText = btn.innerHTML;

      btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
      btn.disabled = true;

      // Reset after 2 seconds if still on page
      setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
      }, 2000);
    }
  });

  console.log("Simple Luna System initialized successfully");
});
