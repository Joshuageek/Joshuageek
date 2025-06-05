<div class="dashboard-card">
    <div class="card-header bg-primary rounded-top">
        <h2 class="fw-bold text-white">Patients Management</h2>
        <div class="card-actions">
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#newPatientModal">
                <i class="fas fa-plus-circle"></i> New Patient
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="table-data">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Age range</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($allPatients)): ?>
                        <?php $i = 1; ?>
                        <?php foreach ($allPatients as $patient): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($patient['full_name']) ?></td>
                                <td
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-custom-class="custom-tooltip"
                                    data-bs-title="<?= htmlspecialchars($patient['email']) ?>"
                                >
                                    <?= htmlspecialchars(substr($patient['email'], 0, 7)) ?>...
                                </td>
                                <td><?= htmlspecialchars($patient['phone'] ?? 'N/A')  ?></td>
                                <td><?= htmlspecialchars($patient['gender'] ?? 'N/A')  ?></td>
                                <td><?= htmlspecialchars($patient['age'] ?? 'N/A')  ?></td>
                                <td><?= htmlspecialchars($patient['location'] ?? 'N/A')  ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editPatientModal"
                                        data-id="<?= $patient['id'] ?>"
                                        data-name="<?= htmlspecialchars($patient['full_name']) ?>"
                                        data-email="<?= htmlspecialchars($patient['email']) ?>"
                                        data-phone="<?= htmlspecialchars($patient['phone']) ?>"
                                        data-age="<?= $patient['age'] ?>"
                                        data-location="<?= $patient['location'] ?>"
                                        data-gender="<?= $patient['gender'] ?>"
                                        >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-patient" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#patientDeleteModal" 
                                        data-id="<?= $patient['id'] ?>"
                                        data-name="<?= htmlspecialchars($patient['full_name']) ?>">
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

<!-- new patient modal -->
<div class="modal fade" id="newPatientModal" tabindex="-1" aria-labelledby="newPatientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form action="php/patients.inc.php" method="POST">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="newPatientModalLabel">New Patient</h5>
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
                <label for="gender" class="form-label">Gender</label>
               <select name="gender" class="form-select" id="gender">
                    <option value="" disabled selected>choose your gender</option>
                    <option value="male">male</option>
                    <option value="female">female</option>
                </select>
              </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-6">
                <label for="age-range" class="form-label">Number of People</label>
                <select name="age" class="form-select" id="age-range">
                    <option value="" disabled selected>Select Age Range</option>
                    <option value="18-24">18-24</option>
                    <option value="25-34">25-34</option>
                    <option value="35-44">35-44</option>
                    <option value="45+">45+</option>
                </select>
              </div>
            <div class="mb-3 col-md-6">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" name="location" placeholder="Provide location" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_patient" class="btn btn-primary btn-sm">Save Booking</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- edit patients modal -->
<div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="php/patients.inc.php" method="POST">
        <input type="hidden" name="patient_id" id="editPatientId">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="editPatientModalLabel">Edit Patient</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <div class="row">
              <div class="mb-3 col-md-6">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="editPatientFullName" name="full_name" placeholder="Full Name" required>
              </div>
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="editPatientEmail" name="email" placeholder="Your Email" required>
              </div>
          </div>
          <div class="row">
              <div class="mb-3 col-md-6">
                <label for="editPatientPhone" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" id="editPatientPhone" placeholder="Phone Number" required>
              </div>
              <div class="mb-3 col-md-6">
                <label for="gender" class="form-label">Gender</label>
               <select name="gender" class="form-select" id="editGender">
                    <option value="" disabled selected>choose your gender</option>
                    <option value="male">male</option>
                    <option value="female">female</option>
                </select>
              </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-6">
                <label for="age-range" class="form-label">Age range</label>
                <select name="age" class="form-select" id="editAge">
                    <option value="" disabled selected>Select Age Range</option>
                    <option value="18-24">18-24</option>
                    <option value="25-34">25-34</option>
                    <option value="35-44">35-44</option>
                    <option value="45+">45+</option>
                </select>
              </div>
            <div class="mb-3 col-md-6">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="editLocation" name="location" placeholder="Provide Location" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm" name="update_patient">Update</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- delete modal -->
<div class="modal fade" id="patientDeleteModal" tabindex="-1" aria-labelledby="patientDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="php/patients.inc.php" method="POST">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="patientDeleteModalLabel">Delete Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="patient_id" id="deletePatientId">
                    <div class="mb-3">
                        <p>
                            Are you sure you want to delete this patient <span id="deletePatientName" class="fw-bold"></span>?
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="delete_patient" class="btn btn-danger btn-sm" >Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const editModal = document.getElementById('editPatientModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('editPatientId').value = button.getAttribute('data-id');
        document.getElementById('editPatientFullName').value = button.getAttribute('data-name');
        document.getElementById('editPatientEmail').value = button.getAttribute('data-email');
        document.getElementById('editPatientPhone').value = button.getAttribute('data-phone');
        document.getElementById('editGender').value = button.getAttribute('data-gender');
        document.getElementById('editAge').value = button.getAttribute('data-age');
        document.getElementById('editLocation').value = button.getAttribute('data-location');
    });

    document.querySelectorAll('.delete-patient').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('deletePatientId').value = this.getAttribute('data-id');
            document.getElementById('deletePatientName').innerText = this.getAttribute('data-name');
        });
    });
});
</script>