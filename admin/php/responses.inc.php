<?php
require_once '../../config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo "<div class='alert alert-danger'>Invalid response ID.</div>";
    exit;
}

$id = (int)$_GET['id'];
$stmt = $conn->prepare("
    SELECT qr.*, u.full_name AS patient_name, u.email AS patient_email
    FROM questionnaire_responses qr
    LEFT JOIN users u ON qr.user_id = u.id
    WHERE qr.id = ?
");
$stmt->execute([$id]);
$response = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$response) {
    echo "<div class='alert alert-warning'>Response not found.</div>";
    exit;
}
?>
<div class="row">
  <div class="col-md-6 mb-2"><strong>Patient:</strong> <?= htmlspecialchars($response['patient_name']) ?></div>
  <div class="col-md-6 mb-2"><strong>Email:</strong> <?= htmlspecialchars($response['patient_email']) ?></div>
</div>
<div class="row">
  <div class="col-md-6 mb-2"><strong>Date Submitted:</strong> <?= $response['submitted_at'] ? date('M d, Y H:i', strtotime($response['submitted_at'])) : 'N/A' ?></div>
  <div class="col-md-6 mb-2"><strong>Therapy Reasons:</strong> <?= htmlspecialchars($response['therapyReasons']) ?></div>
</div>
<div class="row">
  <div class="col-md-6 mb-2"><strong>Therapy Goals:</strong> <?= htmlspecialchars($response['therapyGoals']) ?></div>
  <div class="col-md-6 mb-2"><strong>Therapy History:</strong> <?= htmlspecialchars($response['therapyHistory']) ?></div>
</div>
<div class="row">
  <div class="col-md-6 mb-2"><strong>Therapist Preferences:</strong> <?= htmlspecialchars($response['therapistQualities']) ?></div>
  <div class="col-md-6 mb-2"><strong>Preferred Therapist Gender:</strong> <?= htmlspecialchars($response['therapistGender']) ?></div>
</div>
<div class="row">
  <div class="col-md-6 mb-2"><strong>Health Condition:</strong> <?= htmlspecialchars($response['healthCondition']) ?></div>
  <div class="col-md-6 mb-2"><strong>Triggers:</strong> <?= htmlspecialchars($response['triggers']) ?></div>
</div>
<div class="row">
  <div class="col-md-12 mb-2"><strong>Additional Info:</strong> <?= htmlspecialchars($response['additionalInfo']) ?></div>
</div>