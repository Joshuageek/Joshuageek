<?php
session_start();
ob_start();

// Enable detailed error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$dbPath = __DIR__ . '/../config/db.php';
if (!file_exists($dbPath)) {
    error_log("Database configuration not found at: $dbPath");
    sendJsonResponse([
        'success' => false,
        'message' => 'Server configuration error',
        'details' => 'Database configuration file missing'
    ]);
    exit();
}

require_once $dbPath;

// Verify database connection
if (!isset($conn) || !($conn instanceof PDO)) {
    error_log("Database connection not properly initialized");
    sendJsonResponse([
        'success' => false,
        'message' => 'Server configuration error',
        'details' => 'Database connection failed'
    ]);
    exit();
}

/**
 * Send consistent JSON responses
 */
function sendJsonResponse(array $data, int $statusCode = 200): void {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

/**
 * Validate and sanitize input data
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Main form submission handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Log raw POST data
        error_log("Raw POST data: " . print_r($_POST, true));

        // Sanitize all input data
        $postData = sanitizeInput($_POST);
        error_log("Sanitized POST data: " . print_r($postData, true));

        // Verify session user_id
        if (!isset($_SESSION['user_id'])) {
            throw new InvalidArgumentException('User not authenticated');
        }
        $user_id = $_SESSION['user_id'];
        error_log("Session user_id: $user_id");

        // Verify this is the final submission (19 pages, 0-based index, final page is 18)
        if (!isset($postData['current_page']) || (int)$postData['current_page'] !== 18) {
            sendJsonResponse(['success' => true]);
        }

        // Validate required fields
        $requiredFields = ['fullName', 'age', 'gender', 'location'];
        $missingFields = [];
        foreach ($requiredFields as $field) {
            if (empty($postData[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            throw new InvalidArgumentException(
                'Missing required fields: ' . implode(', ', $missingFields)
            );
        }

        // Start transaction
        $conn->beginTransaction();

        // Update user data
        $stmt = $conn->prepare(
            "UPDATE users SET full_name = ?, age = ?, gender = ?, location = ?, created_on = NOW()
             WHERE id = ?"
        );
        $success = $stmt->execute([
            $postData['fullName'],
            $postData['age'],
            $postData['gender'],
            $postData['location'],
            $user_id
        ]);
        error_log("Users table update success: " . ($success ? 'true' : 'false'));

        // Process checkbox arrays
        $therapyReasons = $postData['therapyReasons'] ?? [];
        if (in_array('other', $therapyReasons)) {
            if (!empty($postData['otherReason'])) {
                $therapyReasons[array_search('other', $therapyReasons)] = $postData['otherReason'];
            } else {
                $therapyReasons = array_filter($therapyReasons, fn($value) => $value !== 'other');
            }
        }
        $therapyReasonsString = implode(', ', $therapyReasons) ?: 'none selected';

        $therapyGoals = $postData['therapyGoals'] ?? [];
        if (in_array('other', $therapyGoals)) {
            if (!empty($postData['otherGoal'])) {
                $therapyGoals[array_search('other', $therapyGoals)] = $postData['otherGoal'];
            } else {
                $therapyGoals = array_filter($therapyGoals, fn($value) => $value !== 'other');
            }
        }
        $therapyGoalsString = implode(', ', $therapyGoals) ?: 'none selected';

        $receivedTherapy = $postData['receivedTherapy'] ?? [];
        $receivedTherapyString = implode(', ', $receivedTherapy) ?: 'none';

        $therapyInterest = $postData['therapyInterest'] ?? [];
        $therapyInterestString = implode(', ', $therapyInterest) ?: 'none selected';

        $therapistQualities = $postData['therapistQualities'] ?? [];
        if (in_array('other', $therapistQualities)) {
            if (!empty($postData['otherQuality'])) {
                $therapistQualities[array_search('other', $therapistQualities)] = $postData['otherQuality'];
            } else {
                $therapistQualities = array_filter($therapistQualities, fn($value) => $value !== 'other');
            }
        }
        $therapistQualitiesString = implode(', ', $therapistQualities) ?: 'none selected';

        // Process other special fields
        $therapistGender = $postData['therapistGender'] ?? 'no-preference';
        if ($therapistGender === 'other' && !empty($postData['otherTherapistGender'])) {
            $therapistGender = $postData['otherTherapistGender'];
        } elseif ($therapistGender === 'other') {
            $therapistGender = 'no-preference';
        }

        $source = $postData['source'] ?? 'unknown';
        if ($source === 'other' && !empty($postData['sourceOtherText'])) {
            $source = $postData['sourceOtherText'];
        } elseif ($source === 'other') {
            $source = 'unknown';
        }

        // Truncate therapyHistory to fit VARCHAR(20)
        $therapyHistory = $postData['therapyHistory'] ?? 'not specified';
        if (strlen($therapyHistory) > 20) {
            $therapyHistory = substr($therapyHistory, 0, 20);
            error_log("Truncated therapyHistory to: $therapyHistory");
        }

        // Insert questionnaire data
        $params = [
            $user_id,
            $therapyReasonsString,
            $therapyGoalsString,
            $therapyHistory,
            $receivedTherapyString,
            $therapyInterestString,
            $postData['communicationMethod'] ?? 'not specified',
            $postData['sessionFrequency'] ?? 'not specified',
            $postData['sessionTime'] ?? 'not specified',
            $therapistQualitiesString,
            $therapistGender,
            ($postData['healthCondition'] === 'yes' && !empty($postData['healthDetails']))
                ? $postData['healthDetails']
                : 'none reported',
            ($postData['triggers'] === 'yes' && !empty($postData['triggerDetails']))
                ? $postData['triggerDetails']
                : 'none reported',
            $postData['coping'] ?? 'not specified',
            $source,
            $postData['additionalInfo'] ?? 'none'
        ];

        $query = "INSERT INTO questionnaire_responses (
            user_id, therapyReasons, therapyGoals, therapyHistory,
            receivedTherapy, therapyInterest, communicationMethod,
            sessionFrequency, sessionTime, therapistQualities,
            therapistGender, healthCondition, triggers,
            coping, source, additionalInfo, submitted_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $conn->prepare($query);
        $success = $stmt->execute($params);
        error_log("SQL Query: $query");
        error_log("SQL Params: " . print_r($params, true));
        error_log("Questionnaire responses insert success: " . ($success ? 'true' : 'false'));

        // Commit transaction
        $conn->commit();

        sendJsonResponse([
            'success' => true,
            'redirect' => './paywall.php',
            'user_id' => $user_id
        ]);

    } catch (PDOException $e) {
        if (isset($conn) && $conn->inTransaction()) {
            $conn->rollBack();
        }
        error_log("Database error: " . $e->getMessage() . " | Query: " . ($query ?? 'N/A') . " | Params: " . print_r($params ?? [], true));
        sendJsonResponse([
            'success' => false,
            'message' => 'Database error occurred',
            'error_details' => $e->getMessage()
        ], 500);
    } catch (InvalidArgumentException $e) {
        if (isset($conn) && $conn->inTransaction()) {
            $conn->rollBack();
        }
        sendJsonResponse([
            'success' => false,
            'message' => $e->getMessage()
        ], 400);
    } catch (Exception $e) {
        if (isset($conn) && $conn->inTransaction()) {
            $conn->rollBack();
        }
        error_log("Unexpected error: " . $e->getMessage());
        sendJsonResponse([
            'success' => false,
            'message' => 'An unexpected error occurred',
            'error_details' => $e->getMessage()
        ], 500);
    }
} else {
    sendJsonResponse([
        'success' => false,
        'message' => 'Invalid request method'
    ], 405);
}
?>