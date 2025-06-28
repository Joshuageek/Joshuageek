<?php
session_start();
require_once '../includes/auth.php';

// Check if user is authenticated
if (!isLoggedIn()) {
    header('Location: ../../login.php');
    exit();
}

$user_role = getUserRole();
$user_id = $_SESSION['user_id'];

// Get questionnaire responses based on user role
$questionnaires = getQuestionnaireResponses($user_role, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../templates/header.php'; ?>
<body>
    <?php include '../templates/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include '../templates/toolbar.php'; ?>

        <div class="dashboard-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <?php if ($user_role === 'admin'): ?>
                        All Questionnaire Responses
                    <?php elseif ($user_role === 'therapist'): ?>
                        Patient Questionnaires
                    <?php else: ?>
                        My Questionnaire Responses
                    <?php endif; ?>
                </h2>
            </div>

            <div class="row">
                <?php if (empty($questionnaires)): ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                <h5>No questionnaire responses found</h5>
                                <p class="text-muted">
                                    <?php if ($user_role === 'patient'): ?>
                                        You haven't completed any questionnaires yet.
                                    <?php else: ?>
                                        No questionnaire responses are available.
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($questionnaires as $questionnaire): ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h6 class="card-title mb-0">
                                        <?php if ($user_role !== 'patient'): ?>
                                            <?php echo htmlspecialchars($questionnaire['full_name'] ?? 'Unknown Patient'); ?>
                                        <?php else: ?>
                                            Questionnaire Response
                                        <?php endif; ?>
                                    </h6>
                                    <small class="text-muted">
                                        <?php echo date('M j, Y', strtotime($questionnaire['submitted_at'])); ?>
                                    </small>
                                </div>
                                
                                <div class="questionnaire-details">
                                    <div class="row">
                                        <div class="col-sm-6 mb-2">
                                            <strong>Therapy Reasons:</strong>
                                            <p class="small text-muted mb-1"><?php echo htmlspecialchars($questionnaire['therapyReasons'] ?? 'Not specified'); ?></p>
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <strong>Goals:</strong>
                                            <p class="small text-muted mb-1"><?php echo htmlspecialchars($questionnaire['therapyGoals'] ?? 'Not specified'); ?></p>
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <strong>Communication Method:</strong>
                                            <p class="small text-muted mb-1"><?php echo htmlspecialchars($questionnaire['communicationMethod'] ?? 'Not specified'); ?></p>
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <strong>Session Frequency:</strong>
                                            <p class="small text-muted mb-1"><?php echo htmlspecialchars($questionnaire['sessionFrequency'] ?? 'Not specified'); ?></p>
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <strong>Preferred Time:</strong>
                                            <p class="small text-muted mb-1"><?php echo htmlspecialchars($questionnaire['sessionTime'] ?? 'Not specified'); ?></p>
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <strong>Therapist Gender:</strong>
                                            <p class="small text-muted mb-1"><?php echo htmlspecialchars($questionnaire['therapistGender'] ?? 'No preference'); ?></p>
                                        </div>
                                    </div>
                                    
                                    <?php if (!empty($questionnaire['additionalInfo'])): ?>
                                    <div class="mt-3">
                                        <strong>Additional Information:</strong>
                                        <p class="small text-muted"><?php echo htmlspecialchars($questionnaire['additionalInfo']); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-outline-primary" onclick="viewFullQuestionnaire(<?php echo $questionnaire['id']; ?>)">
                                        View Full Details
                                    </button>
                                    <?php if ($user_role === 'therapist'): ?>
                                        <button class="btn btn-sm btn-primary-custom ms-2" onclick="contactPatient('<?php echo htmlspecialchars($questionnaire['email']); ?>')">
                                            Contact Patient
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function viewFullQuestionnaire(id) {
            // Implement full questionnaire view modal
            alert('View full questionnaire details for ID: ' + id);
        }
        
        function contactPatient(email) {
            window.location.href = 'mailto:' + email;
        }
    </script>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
