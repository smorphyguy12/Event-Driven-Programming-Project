<?php
header('Content-Type: application/json');

include 'services/database.php';
include 'services/session.php';
include 'services/session-auth.php';

try {
    // Ensure user is logged in
    if (!isset($_SESSION['id'])) {
        throw new Exception('Unauthorized');
    }

    $user_id = $_SESSION['id'];
    $status = $_POST['status'] ?? 'online';

    // Validate status
    $validStatuses = ['online', 'away', 'offline'];
    if (!in_array($status, $validStatuses)) {
        $status = 'online';
    }

    // Upsert user status
    $stmt = $conn->prepare("
        INSERT INTO user_status (user_id, last_activity, status) 
        VALUES (?, NOW(), ?) 
        ON DUPLICATE KEY UPDATE 
            last_activity = NOW(), 
            status = ?
    ");
    $stmt->bind_param("iss", $user_id, $status, $status);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => true, 'message' => 'Status updated']);
    exit;

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    exit;
}