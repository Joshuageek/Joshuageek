// Initialize dashboard when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
  // Initialize tooltips
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Tab functionality
  const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
  tabEls.forEach((tabEl) => {
    tabEl.addEventListener("click", function (event) {
      const tabId = this.getAttribute("data-bs-target");
      activateTab(tabId);
    });
  });

  // Initialize charts
  initializeCharts();

  // Search functionality
  document.getElementById("userSearch")?.addEventListener("input", function () {
    filterTable("usersTable", this.value.toLowerCase());
  });

  // Modal handlers
  setupModalHandlers();
});

// Activate a specific tab
function activateTab(tabId) {
  const tabTriggerEl = document.querySelector(
    `button[data-bs-target="${tabId}"]`
  );
  const tabInstance = new bootstrap.Tab(tabTriggerEl);
  tabInstance.show();
}

// Filter table rows based on search input
function filterTable(tableId, searchText) {
  const table = document.getElementById(tableId);
  if (!table) return;

  const rows = table.querySelectorAll("tbody tr");
  rows.forEach((row) => {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(searchText) ? "" : "none";
  });
}

// Initialize all charts
function initializeCharts() {
  // Booking Status Chart (Doughnut)
  const bookingStatusCtx = document
    .getElementById("bookingStatusChart")
    ?.getContext("2d");
  if (bookingStatusCtx) {
    new Chart(bookingStatusCtx, {
      type: "doughnut",
      data: {
        labels: ["Confirmed", "Pending", "Cancelled"],
        datasets: [
          {
            data: [
              bookingData.confirmed,
              bookingData.pending,
              bookingData.cancelled,
            ],
            backgroundColor: ["#1cc88a", "#f6c23e", "#e74a3b"],
            hoverBackgroundColor: ["#17a673", "#dda20a", "#be2617"],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          },
        ],
      },
      options: getDefaultChartOptions("Booking Status Distribution"),
    });
  }

  // More chart initializations would go here...
}

// Get default chart options
function getDefaultChartOptions(title) {
  return {
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
        position: "bottom",
      },
      title: {
        display: !!title,
        text: title,
      },
    },
  };
}

// Setup modal event handlers
function setupModalHandlers() {
  // View booking details
  document.querySelectorAll(".view-booking").forEach((btn) => {
    btn.addEventListener("click", function () {
      const bookingId = this.getAttribute("data-id");
      fetchBookingDetails(bookingId);
    });
  });

  // Similar handlers for other modals...
}

// Fetch booking details via AJAX
function fetchBookingDetails(bookingId) {
  fetch(`ajax/get_booking_details.php?id=${bookingId}`)
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("bookingDetailContent").innerHTML = data.html;
      const modal = new bootstrap.Modal(
        document.getElementById("bookingDetailModal")
      );
      modal.show();
    })
    .catch((error) => {
      toastr.error("Failed to load booking details");
      console.error("Error:", error);
    });
}

// Toastr notifications configuration
toastr.options = {
  closeButton: true,
  debug: false,
  newestOnTop: false,
  progressBar: true,
  positionClass: "toast-top-right",
  preventDuplicates: false,
  onclick: null,
  showDuration: "300",
  hideDuration: "1000",
  timeOut: "5000",
  extendedTimeOut: "1000",
  showEasing: "swing",
  hideEasing: "linear",
  showMethod: "fadeIn",
  hideMethod: "fadeOut",
};
