<div class="dashboard-card">
    <div class="card-header bg-primary rounded-top">
        <h2 class="fw-bold text-white">Bookings Management</h2>
        <div class="card-actions">
            <div class="dropdown">
                <ul class="dropdown-menu">  
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Week</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                </ul>
            </div>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#newBookingModal">
                <i class="fas fa-plus-circle"></i> New Booking
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="table-data">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookings)): ?>
                        <?php $i = 1; ?>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($booking['full_name']) ?></td>
                                <td
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-custom-class="custom-tooltip"
                                    data-bs-title="<?= htmlspecialchars($booking['email']) ?>"
                                >
                                    <?= htmlspecialchars(substr($booking['email'], 0, 7)) ?>...
                                </td>
                                <td><?= htmlspecialchars($booking['phone']) ?></td>
                                <td><?= date('M j, Y', strtotime($booking['booking_date'])) ?></td>
                                <td><?= date('g:i A', strtotime($booking['booking_time'])) ?></td>
                                <td>
                                    <?php
                                        $status = ucfirst($booking['status']);
                                        $badgeClass = match ($status) {
                                            'Confirmed' => 'bg-primary',
                                            'Pending' => 'bg-warning',
                                            'Accepted' => 'bg-info',
                                            'Cancelled' => 'bg-danger',
                                            'Completed' => 'bg-success',
                                            default => 'bg-secondary',
                                        };
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal" data-bs-target="#bookingEmailModal"
                                        data-id="<?= $booking['id'] ?>"
                                        data-name="<?= htmlspecialchars($booking['full_name']) ?>"
                                        data-email="<?= htmlspecialchars($booking['email']) ?>"
                                        data-date="<?= date('M j, Y', strtotime($booking['booking_date'])) ?>"
                                        data-time="<?= date('g:i A', strtotime($booking['booking_time'])) ?>">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editBookingModal"
                                        data-id="<?= $booking['id'] ?>"
                                        data-name="<?= htmlspecialchars($booking['full_name']) ?>"
                                        data-email="<?= htmlspecialchars($booking['email']) ?>"
                                        data-phone="<?= htmlspecialchars($booking['phone']) ?>"
                                        data-date="<?= $booking['booking_date'] ?>"
                                        data-time="<?= $booking['booking_time'] ?>"
                                        data-persons="<?= $booking['number_of_people'] ?>"
                                        >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-bookings" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#bookingDeleteModal" 
                                        data-id="<?= $booking['id'] ?>"
                                        data-name="<?= htmlspecialchars($booking['full_name']) ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- new booking modal -->
<div class="modal fade" id="newBookingModal" tabindex="-1" aria-labelledby="newBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form action="php/bookings.inc.php" method="POST">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="newBookingModalLabel">New Booking</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Form fields -->
          <div class="row">
              <div class="mb-3 col-md-6">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
              </div>
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
              </div>
          </div>
          <div class="row">
              <div class="mb-3 col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" placeholder="Phone Number" required>
              </div>
              <div class="mb-3 col-md-6">
                <label for="booking_date" class="form-label">Booking Date</label>
                <input type="date" class="form-control" name="booking_date" required>
              </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-6">
                <label for="no_of_people" class="form-label">Number of People</label>
                <select name="number_of_people" class="form-select" id="no_of_people">
                    <option value="" disabled selected>How many?</option>
                    <option value="1 Person">1 Person</option>
                    <option value="2 People">2 People</option>
                    <option value="3 People">3 People</option>
                    <option value="4 People">4 People</option>
                    <option value="5 People">5 People</option>
                    <option value="6 People">6 People</option>
                    <option value="7 People">7 People</option>
                    <option value="8 People">8 People</option>
                    <option value="9 People">9 People</option>
                    <option value="10 People">10 People</option>
                </select>
              </div>
            <div class="mb-3 col-md-6">
                <label for="booking_time" class="form-label">Booking Time</label>
                <input type="time" class="form-control" name="booking_time" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_booking" class="btn btn-primary btn-sm">Save Booking</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- edit booking modal -->
<div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="php/bookings.inc.php" method="POST">
        <input type="hidden" name="booking_id" id="editBookingId">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="editBookingModalLabel">Edit Booking</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="mb-3 col-md-6">
                <label for="editFullName" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="full_name" id="editFullName" required>
              </div>
              <div class="mb-3 col-md-6">
                <label for="editEmail" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="editEmail" required>
              </div>
          </div>
          <div class="row">
              <div class="mb-3 col-md-6">
                <label for="editPhone" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" id="editPhone" required>
              </div>
              <div class="mb-3 col-md-6">
                <label for="editDate" class="form-label">Booking Date</label>
                <input type="date" class="form-control" name="booking_date" id="editDate" required>
              </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-6">
                <label for="editPersons" class="form-label">Number of People</label>
                <select name="number_of_people" class="form-select" id="editPersons">
                    <option value="" disabled selected>How many?</option>
                    <option value="1 Person">1 Person</option>
                    <option value="2 People">2 People</option>
                    <option value="3 People">3 People</option>
                    <option value="4 People">4 People</option>
                    <option value="5 People">5 People</option>
                    <option value="6 People">6 People</option>
                    <option value="7 People">7 People</option>
                    <option value="8 People">8 People</option>
                    <option value="9 People">9 People</option>
                    <option value="10 People">10 People</option>
                </select>
              </div>
            <div class="mb-3 col-md-6">
                <label for="booking_time" class="form-label">Booking Time</label>
                <input type="time" class="form-control" name="booking_time" id="editTime" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm" name="update_booking">Update</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- delete modal -->
<div class="modal fade" id="bookingDeleteModal" tabindex="-1" aria-labelledby="bookingDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="php/bookings.inc.php" method="POST">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="bookingDeleteModalLabel">Delete Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="deleteBookingId">
                    <div class="mb-3">
                        <p>
                            Are you sure you want to delete this booking for <span id="deleteBookingName" class="fw-bold"></span>?
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="delete_booking" class="btn btn-danger btn-sm" >Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- email modal -->
<div class="modal fade" id="bookingEmailModal" tabindex="-1" aria-labelledby="bookingEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="php/send_email.php" method="POST" id="emailForm">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="bookingEmailModalLabel">Send Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetEmailForm()"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="emailBookingId">
                    <input type="hidden" name="user_id">
                    <input type="hidden" name="message" id="emailMessage">

                    <!-- Recipient Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="patientEmail" class="form-label fw-bold">Patient Email</label>
                                <input type="email" class="form-control" id="patientEmail" name="patient_email" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="therapistEmail" class="form-label fw-bold">Therapist Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="therapistEmail" name="therapist_email" required placeholder="Enter Therapist Email">
                            </div>
                        </div>
                    </div>

                    <!-- Email Content Section -->
                    <div class="mb-4">
                        <label for="emailSubject" class="form-label fw-bold">Subject</label>
                        <input type="text" class="form-control" id="emailSubject" name="subject" value="Booking Confirmation Request" required>
                    </div>

                    <!-- Pre-filled Email Template -->
                    <div class="alert alert-info mb-4" role="alert">
                        <p class="mb-1"><strong>Default Template:</strong></p>
                        <p>Dear [Patient Name],</p>
                        <p>A booking request has been scheduled for you on [Date] at [Time]. Please review and respond to this email to confirm or decline.</p>
                        <p>Therapist: [Therapist Email]</p>
                        <p>Best regards,<br>Luna Team</p>
                        <p><small>Click "Accept" to add to your calendar, or "Reject" to cancel.</small></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Send Email</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" onclick="resetEmailForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const editModal = document.getElementById('editBookingModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('editBookingId').value = button.getAttribute('data-id');
        document.getElementById('editFullName').value = button.getAttribute('data-name');
        document.getElementById('editEmail').value = button.getAttribute('data-email');
        document.getElementById('editPhone').value = button.getAttribute('data-phone');
        document.getElementById('editDate').value = button.getAttribute('data-date');
        document.getElementById('editTime').value = button.getAttribute('data-time');
        document.getElementById('editPersons').value = button.getAttribute('data-persons');
    });

    // Handle Send Email Modal
    const emailModal = document.getElementById('bookingEmailModal');
    emailModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const bookingId = button.getAttribute('data-id');
        const patientName = button.getAttribute('data-name');
        const patientEmail = button.getAttribute('data-email');
        const bookingDate = button.getAttribute('data-date');
        const bookingTime = button.getAttribute('data-time');

        document.getElementById('emailBookingId').value = bookingId;
        document.getElementById('patientEmail').value = patientEmail;
        document.getElementById('emailMessage').value = `Dear ${patientName},\n\nA booking request has been scheduled for you on ${bookingDate} at ${bookingTime}. Please review and respond to this email to confirm or decline.\n\nTherapist: [Therapist Email]\n\nBest regards,\nLuna Team\n\n[Click "Accept" to add to your calendar, or "Reject" to cancel.]`;
    });

     document.querySelectorAll('.delete-bookings').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('deleteBookingId').value = this.getAttribute('data-id');
            const patientName = document.getElementById('deleteBookingName').innerText = this.getAttribute('data-name');
        });
    });

    // Reset form function
    window.resetEmailForm = function () {
        document.getElementById('emailForm').reset();
        document.getElementById('emailBookingId').value = '';
        document.getElementById('patientEmail').value = '';
        document.getElementById('therapistEmail').value = '';
        document.getElementById('emailSubject').value = 'Booking Confirmation Request';
        document.getElementById('emailMessage').value = '';
    };
});
</script>