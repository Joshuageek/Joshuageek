// Fixed Luna System - Sidebar Toggle
document.addEventListener("DOMContentLoaded", () => {
  console.log("Luna System initializing...");

  // Get elements
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebar = document.getElementById("sidebar");
  const sidebarOverlay = document.getElementById("sidebarOverlay");
  const mainContent = document.querySelector(".main-content");

  // Check if elements exist
  if (!sidebarToggle || !sidebar) {
    console.error("Sidebar elements not found!");
    return;
  }

  console.log("Sidebar elements found:", {
    toggle: !!sidebarToggle,
    sidebar: !!sidebar,
    overlay: !!sidebarOverlay,
    mainContent: !!mainContent,
  });

  // Enhanced sidebar toggle function
  function toggleSidebar() {
    console.log("Toggle sidebar called");

    const isMobile = window.innerWidth <= 991;
    console.log("Is mobile:", isMobile);

    if (isMobile) {
      // Mobile behavior
      const isOpen = sidebar.classList.contains("show");
      console.log("Mobile - sidebar is open:", isOpen);

      if (isOpen) {
        // Close sidebar
        sidebar.classList.remove("show");
        if (sidebarOverlay) {
          sidebarOverlay.classList.remove("show");
        }
        document.body.style.overflow = "";
        console.log("Mobile - sidebar closed");
      } else {
        // Open sidebar
        sidebar.classList.add("show");
        if (sidebarOverlay) {
          sidebarOverlay.classList.add("show");
        }
        document.body.style.overflow = "hidden";
        console.log("Mobile - sidebar opened");
      }
    } else {
      // Desktop behavior
      const isHidden = sidebar.classList.contains("desktop-hidden");
      console.log("Desktop - sidebar is hidden:", isHidden);

      if (isHidden) {
        // Show sidebar
        sidebar.classList.remove("desktop-hidden");
        if (mainContent) {
          mainContent.classList.remove("sidebar-hidden");
        }
        console.log("Desktop - sidebar shown");
      } else {
        // Hide sidebar
        sidebar.classList.add("desktop-hidden");
        if (mainContent) {
          mainContent.classList.add("sidebar-hidden");
        }
        console.log("Desktop - sidebar hidden");
      }
    }
  }

  // Bind toggle button click
  sidebarToggle.addEventListener("click", (e) => {
    e.preventDefault();
    console.log("Toggle button clicked");
    toggleSidebar();
  });

  // Close sidebar when clicking overlay (mobile only)
  if (sidebarOverlay) {
    sidebarOverlay.addEventListener("click", () => {
      console.log("Overlay clicked");
      if (window.innerWidth <= 991) {
        toggleSidebar();
      }
    });
  }

  // Handle window resize
  function handleResize() {
    const isMobile = window.innerWidth <= 991;
    console.log("Window resized - is mobile:", isMobile);

    if (isMobile) {
      // Switch to mobile mode
      sidebar.classList.remove("desktop-hidden");
      sidebar.classList.remove("show"); // Start hidden on mobile
      if (sidebarOverlay) {
        sidebarOverlay.classList.remove("show");
      }
      if (mainContent) {
        mainContent.classList.remove("sidebar-hidden");
      }
      document.body.style.overflow = "";
      console.log("Switched to mobile mode");
    } else {
      // Switch to desktop mode
      sidebar.classList.remove("show");
      if (sidebarOverlay) {
        sidebarOverlay.classList.remove("show");
      }
      document.body.style.overflow = "";
      // Keep current desktop state (hidden or visible)
      console.log("Switched to desktop mode");
    }
  }

  // Debounced resize handler
  let resizeTimeout;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(handleResize, 150);
  });

  // Initial setup
  handleResize();

  // Keyboard shortcuts
  document.addEventListener("keydown", (e) => {
    // Escape to close sidebar on mobile
    if (e.key === "Escape" && window.innerWidth <= 991) {
      if (sidebar.classList.contains("show")) {
        toggleSidebar();
      }
    }

    // Ctrl/Cmd + B to toggle sidebar
    if ((e.ctrlKey || e.metaKey) && e.key === "b") {
      e.preventDefault();
      toggleSidebar();
    }

    // Ctrl/Cmd + K for search
    if ((e.ctrlKey || e.metaKey) && e.key === "k") {
      e.preventDefault();
      const searchInput = document.getElementById("globalSearch");
      if (searchInput) {
        searchInput.focus();
        searchInput.select();
      }
    }
  });

  // Search functionality with debounce
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
          window.showToast(`Searching for: ${query}`, "info");
        }, 500);
      }
    });
  }

  // Initialize Bootstrap tooltips
  const bootstrap = window.bootstrap; // Declare bootstrap variable
  if (bootstrap) {
    const tooltipTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(
      (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
    );
  }

  // Animate cards on scroll
  const cards = document.querySelectorAll(".stat-card, .welcome-card");

  if (cards.length > 0) {
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
  }

  // Toast notification function
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

    // Auto remove after 4 seconds
    setTimeout(() => {
      toast.classList.remove("show");
      setTimeout(() => toast.remove(), 300);
    }, 4000);
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

  // Notification badge handler
  const notificationDropdown = document.querySelector(
    '.notification-btn[data-bs-toggle="dropdown"]'
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

  // Add loading state to navigation links
  document.addEventListener("click", (e) => {
    if (
      e.target.matches('.btn[href]:not([href^="#"])') ||
      e.target.matches('.nav-link[href]:not([href^="#"])')
    ) {
      const element = e.target;
      const originalText = element.innerHTML;

      element.innerHTML =
        '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
      element.style.pointerEvents = "none";

      // Reset after 2 seconds if still on page
      setTimeout(() => {
        element.innerHTML = originalText;
        element.style.pointerEvents = "";
      }, 2000);
    }
  });

  console.log("Luna System initialized successfully!");

  // Show initialization toast
  setTimeout(() => {
    window.showToast("Dashboard loaded successfully!", "success");
  }, 500);
});
