<?php
// require_once '../../config/db.php';

// Fetch the most important data from questionnaire_responses, including patient name
$stmt = $conn->prepare("
    SELECT 
        qr.id,
        u.full_name AS patient_name,
        qr.submitted_at
    FROM questionnaire_responses qr
    LEFT JOIN users u ON qr.user_id = u.id
    ORDER BY qr.submitted_at DESC
");
$stmt->execute();
$responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="dashboard-card">
    <div class="card-header">
        <h2>Responses Management</h2>
        <div class="card-actions">
            <div class="response-filters">
                <button class="filter-btn active">All</button>
                <button class="filter-btn">Completed</button>
                <button class="filter-btn">Pending</button>
                <button class="filter-btn">Cancelled</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Therapist</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($responses)): ?>
                        <?php foreach ($responses as $response): ?>
                            <tr>
                                <td><?= 'R' . str_pad($response['id'], 2, '0', STR_PAD_LEFT) ?></td>
                                <td><?= htmlspecialchars($response['patient_name'] ?? 'Unknown') ?></td>
                                <td>N/A</td>
                                <td><?= $response['submitted_at'] ? date('M d, Y', strtotime($response['submitted_at'])) : 'N/A' ?></td>
                                <td>
                                  <?php
                                    $status = $response['submitted_at'] ? 'Completed' : 'Pending';
                                    $badge = $response['submitted_at'] ? 'bg-success' : 'bg-warning';
                                  ?>
                                  <span class="badge <?= $badge ?>"><?= $status ?></span>
                                </td>
                                <td>
                                  <button 
                                    type="button"
                                    class="btn btn-sm btn-outline-primary view-response-btn"
                                    data-id="<?= $response['id'] ?>"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#viewResponseModal"
                                    title="View"
                                  >
                                    <i class="fas fa-eye"></i>
                                  </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No responses found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- View Response Modal -->
<div class="modal fade" id="viewResponseModal" tabindex="-1" aria-labelledby="viewResponseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="viewResponseModalLabel">Response Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="response-details-loader" style="display: none;">Loading...</div>
        <div id="response-details-content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.view-response-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var responseId = this.getAttribute('data-id');
      var contentDiv = document.getElementById('response-details-content');
      var loaderDiv = document.getElementById('response-details-loader');
      contentDiv.innerHTML = '';
      loaderDiv.style.display = 'block';
      fetch('php/responses.inc.php?id=' + encodeURIComponent(responseId))
        .then(res => res.text())
        .then(html => {
          loaderDiv.style.display = 'none';
          contentDiv.innerHTML = html;
        })
        .catch(err => {
          loaderDiv.style.display = 'none';
          contentDiv.innerHTML = "<div class='alert alert-danger'>Failed to load response.</div>";
        });
    });
  });
});
</script>