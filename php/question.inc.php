<?php
session_start();
ob_start();

// Enable detailed error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$dbPath = __DIR__ . '/../connection/db.php';
if (!file_exists($dbPath)) {
    error_log("Database configuration not found at: $dbPath");
    header('Content-Type: application/json');
    echo json_encode([
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
    header('Content-Type: application/json');
    echo json_encode([
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

// Handle AJAX email check
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'check_email') {
    try {
        $email = sanitizeInput($_POST['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            sendJsonResponse([
                'success' => false,
                'message' => 'Invalid email format'
            ], 400);
        }

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        sendJsonResponse([
            'success' => true,
            'exists' => !!$existingUser,
            'user_id' => $existingUser ? $existingUser['id'] : null
        ]);

    } catch (PDOException $e) {
        error_log("Email check error: " . $e->getMessage());
        sendJsonResponse([
            'success' => false,
            'message' => 'Database error occurred'
        ], 500);
    } catch (Exception $e) {
        error_log("Unexpected error: " . $e->getMessage());
        sendJsonResponse([
            'success' => false,
            'message' => 'An unexpected error occurred'
        ], 500);
    }
}

// Main form submission handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['action'])) {
    try {
        // Log raw POST data
        error_log("Raw POST data: " . print_r($_POST, true));

        // Sanitize all input data
        $postData = sanitizeInput($_POST);
        error_log("Sanitized POST data: " . print_r($postData, true));

        // Verify this is the final submission (page 19)
        if (!isset($postData['current_page']) || (int)$postData['current_page'] !== 19) {
            sendJsonResponse(['success' => true]);
        }

        // Validate required fields
        $requiredFields = [
            'fullName', 'email', 'age', 
            'gender', 'location'
        ];
        
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

        // Validate email format
        if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format');
        }

        // Start transaction
        $conn->beginTransaction();

        // Check if user exists (redundant with real-time check, but kept for safety)
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$postData['email']]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $conn->rollBack();
            sendJsonResponse([
                'success' => false,
                'message' => 'This email is already registered',
                'user_id' => $existingUser['id']
            ], 409);
        }

        // Insert user data
        $stmt = $conn->prepare(
            "INSERT INTO users (full_name, email, age, gender, location, created_on)
             VALUES (?, ?, ?, ?, ?, NOW())"
        );
        $stmt->execute([
            $postData['fullName'],
            $postData['email'],
            $postData['age'],
            $postData['gender'],
            $postData['location']
        ]);
        $userId = $conn->lastInsertId();

        // Process checkbox arrays
        $therapyReasons = $postData['therapyReasons'] ?? [];
        error_log("therapyReasons raw: " . print_r($therapyReasons, true));
        if (in_array('other', $therapyReasons)) {
            if (!empty($postData['otherReason'])) {
                $therapyReasons[array_search('other', $therapyReasons)] = $postData['otherReason'];
            } else {
                $therapyReasons = array_filter($therapyReasons, fn($value) => $value !== 'other');
            }
        }
        $therapyReasonsString = implode(', ', $therapyReasons);
        error_log("therapyReasons processed: " . $therapyReasonsString);

        $therapyGoals = $postData['therapyGoals'] ?? [];
        error_log("therapyGoals raw: " . print_r($therapyGoals, true));
        if (in_array('other', $therapyGoals)) {
            if (!empty($postData['otherGoal'])) {
                $therapyGoals[array_search('other', $therapyGoals)] = $postData['otherGoal'];
            } else {
                $therapyGoals = array_filter($therapyGoals, fn($value) => $value !== 'other');
            }
        }
        $therapyGoalsString = implode(', ', $therapyGoals);
        error_log("therapyGoals processed: " . $therapyGoalsString);

        $receivedTherapy = $postData['receivedTherapy'] ?? [];
        error_log("receivedTherapy raw: " . print_r($receivedTherapy, true));
        $receivedTherapyString = implode(', ', $receivedTherapy);
        error_log("receivedTherapy processed: " . $receivedTherapyString);

        $therapyInterest = $postData['therapyInterest'] ?? [];
        error_log("therapyInterest raw: " . print_r($therapyInterest, true));
        $therapyInterestString = implode(', ', $therapyInterest);
        error_log("therapyInterest processed: " . $therapyInterestString);

        $therapistQualities = $postData['therapistQualities'] ?? [];
        error_log("therapistQualities raw: " . print_r($therapistQualities, true));
        if (in_array('other', $therapistQualities)) {
            if (!empty($postData['otherQuality'])) {
                $therapistQualities[array_search('other', $therapistQualities)] = $postData['otherQuality'];
            } else {
                $therapistQualities = array_filter($therapistQualities, fn($value) => $value !== 'other');
            }
        }
        $therapistQualitiesString = implode(', ', $therapistQualities);
        error_log("therapistQualities processed: " . $therapistQualitiesString);

        // Process other special fields
        $therapistGender = $postData['therapistGender'] ?? 'no-preference';
        if ($therapistGender === 'other' && !empty($postData['otherTherapistGender'])) {
            $therapistGender = $postData['otherTherapistGender'];
        } elseif ($therapistGender === 'other') {
            $therapistGender = 'no-preference';
        }
        error_log("therapistGender: " . $therapistGender);

        $source = $postData['source'] ?? 'unknown';
        if ($source === 'other' && !empty($postData['sourceOtherText'])) {
            $source = $postData['sourceOtherText'];
        } elseif ($source === 'other') {
            $source = 'unknown';
        }
        error_log("source: " . $source);

        // Insert questionnaire data
        $params = [
            $userId,
            $therapyReasonsString,
            $therapyGoalsString,
            $postData['therapyHistory'] ?? 'not specified',
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
        error_log("SQL Params: " . print_r($params, true));

        $query = "INSERT INTO questionnaire_responses (
            user_id, therapyReasons, therapyGoals, therapyHistory,
            receivedTherapy, therapyInterest, communicationMethod,
            sessionFrequency, sessionTime, therapistQualities,
            therapistGender, healthCondition, triggers,
            coping, source, additionalInfo, submitted_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        error_log("SQL Query: " . $query);

        $stmt = $conn->prepare($query);
        $success = $stmt->execute($params);
        error_log("SQL Execution success: " . ($success ? 'true' : 'false'));

        // Commit transaction
        $conn->commit();

        // Set session and respond
        $_SESSION['user_id'] = $userId;
        sendJsonResponse([
            'success' => true,
            'redirect' => 'new-pwd.php',
            'user_id' => $userId
        ]);

    } catch (PDOException $e) {
        if (isset($conn) && $conn->inTransaction()) {
            $conn->rollBack();
        }
        error_log("Database error: " . $e->getMessage());
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