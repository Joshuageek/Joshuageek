
<div class="dashboard-card">
    <div class="card-header bg-primary rounded-top">
        <h2 class="fw-bold text-white">Therapists Management</h2>
        <div class="card-actions">
            <!-- <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#newTherapistModal">
                <i class="fas fa-plus-circle"></i> New Therapist
            </button> -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="table-data">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Age range</th>
                        <th>Location</th>
                        <th>Specialization</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($allTherapists)): ?>
                        <?php $i = 1; ?>
                        <?php foreach ($allTherapists as $therapist): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($therapist['full_name']) ?></td>
                                <td
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-custom-class="custom-tooltip"
                                    data-bs-title="<?= htmlspecialchars($therapist['email']) ?>"
                                >
                                    <?= htmlspecialchars(substr($therapist['email'], 0, 7)) ?>...
                                </td>
                                <td><?= htmlspecialchars($therapist['phone'] ?? 'N/A')  ?></td>
                                <td><?= htmlspecialchars($therapist['gender'] ?? 'N/A')  ?></td>
                                <td><?= htmlspecialchars($therapist['age'] ?? 'N/A')  ?></td>
                                <td><?= htmlspecialchars($therapist['location'] ?? 'N/A')  ?></td>
                                <td><?= htmlspecialchars($therapist['specialization'] ?? 'N/A') ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editTherapistModal"
                                        data-id="<?= $therapist['therapist_id'] ?>"
                                        data-name="<?= htmlspecialchars($therapist['full_name']) ?>"
                                        data-email="<?= htmlspecialchars($therapist['email']) ?>"
                                        data-phone="<?= htmlspecialchars($therapist['phone']) ?>"
                                        data-age="<?= $therapist['age'] ?>"
                                        data-location="<?= $therapist['location'] ?>"
                                        data-gender="<?= $therapist['gender'] ?>"
                                        data-specialization="<?= htmlspecialchars($therapist['specialization']) ?>"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-therapist" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#therapistDeleteModal" 
                                        data-id="<?= $therapist['therapist_id'] ?>"
                                        data-name="<?= htmlspecialchars($therapist['full_name']) ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="text-center">No therapists found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- NEW THERAPIST MODAL -->
<div class="modal fade" id="newTherapistModal" tabindex="-1" aria-labelledby="newTherapistModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form action="php/therapists.inc.php" method="POST">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="newTherapistModalLabel">New Therapist</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="mb-3 col-md-6">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="full_name" required>
              </div>
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
          </div>
          <div class="row">
              <div class="mb-3 col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" required>
              </div>
              <div class="mb-3 col-md-6">
                <label for="gender" class="form-label">Gender</label>
               <select name="gender" class="form-select" required>
                    <option value="" disabled selected>choose your gender</option>
                    <option value="male">male</option>
                    <option value="female">female</option>
                </select>
              </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-6">
                <label for="age-range" class="form-label">Age range</label>
                <select name="age" class="form-select" required>
                    <option value="" disabled selected>Select Age Range</option>
                    <option value="18-24">18-24</option>
                    <option value="25-34">25-34</option>
                    <option value="35-44">35-44</option>
                    <option value="45+">45+</option>
                </select>
              </div>
            <div class="mb-3 col-md-6">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" name="location" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-12">
                <label for="specialization" class="form-label">Specialization</label>
                <input type="text" class="form-control" name="specialization" placeholder="e.g. Depression, Anxiety" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_therapist" class="btn btn-primary btn-sm">Save Therapist</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- EDIT THERAPIST MODAL (fields auto-filled by JS) -->
<div class="modal fade" id="editTherapistModal" tabindex="-1" aria-labelledby="editTherapistModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="php/therapists.inc.php" method="POST">
        <input type="hidden" name="therapist_id" id="editTherapistId">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="editTherapistModalLabel">Edit Therapist</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <div class="row">
              <div class="mb-3 col-md-6">
                <label for="editTherapistFullName" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="editTherapistFullName" name="full_name" required>
              </div>
              <div class="mb-3 col-md-6">
                <label for="editTherapistEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="editTherapistEmail" name="email" required>
              </div>
          </div>
          <div class="row">
              <div class="mb-3 col-md-6">
                <label for="editTherapistPhone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="editTherapistPhone" name="phone" required>
              </div>
              <div class="mb-3 col-md-6">
                <label for="editTherapistGender" class="form-label">Gender</label>
               <select name="gender" class="form-select" id="editTherapistGender" required>
                    <option value="" disabled selected>choose your gender</option>
                    <option value="male">male</option>
                    <option value="female">female</option>
                </select>
              </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-6">
                <label for="editTherapistAge" class="form-label">Age range</label>
                <select name="age" class="form-select" id="editTherapistAge" required>
                    <option value="" disabled selected>Select Age Range</option>
                    <option value="18-24">18-24</option>
                    <option value="25-34">25-34</option>
                    <option value="35-44">35-44</option>
                    <option value="45+">45+</option>
                </select>
              </div>
            <div class="mb-3 col-md-6">
                <label for="editTherapistLocation" class="form-label">Location</label>
                <input type="text" class="form-control" id="editTherapistLocation" name="location" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-12">
                <label for="editTherapistSpecialization" class="form-label">Specialization</label>
                <input type="text" class="form-control" id="editTherapistSpecialization" name="specialization" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm" name="update_therapist">Update</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- DELETE THERAPIST MODAL -->
<div class="modal fade" id="therapistDeleteModal" tabindex="-1" aria-labelledby="therapistDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="php/therapists.inc.php" method="POST">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="therapistDeleteModalLabel">Delete Therapist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="therapist_id" id="deleteTherapistId">
                    <div class="mb-3">
                        <p>
                            Are you sure you want to delete this therapist <span id="deleteTherapistName" class="fw-bold"></span>?
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="delete_therapist" class="btn btn-danger btn-sm" >Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const editModal = document.getElementById('editTherapistModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('editTherapistId').value = button.getAttribute('data-id');
        document.getElementById('editTherapistFullName').value = button.getAttribute('data-name');
        document.getElementById('editTherapistEmail').value = button.getAttribute('data-email');
        document.getElementById('editTherapistPhone').value = button.getAttribute('data-phone');
        document.getElementById('editTherapistGender').value = button.getAttribute('data-gender');
        document.getElementById('editTherapistAge').value = button.getAttribute('data-age');
        document.getElementById('editTherapistLocation').value = button.getAttribute('data-location');
        document.getElementById('editTherapistSpecialization').value = button.getAttribute('data-specialization');
    });

    document.querySelectorAll('.delete-therapist').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('deleteTherapistId').value = this.getAttribute('data-id');
            document.getElementById('deleteTherapistName').innerText = this.getAttribute('data-name');
        });
    });
});
</script>