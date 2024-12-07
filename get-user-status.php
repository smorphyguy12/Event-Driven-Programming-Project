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

    $user_id = $_GET['user_id'] ?? null;
    if (!$user_id) {
        throw new Exception('User ID required');
    }

    // Get user status with 5-minute inactivity threshold
    $stmt = $conn->prepare("
        SELECT 
            u.id, 
            u.username, 
            COALESCE(us.status, 'offline') as status,
            CASE 
                WHEN us.last_activity > DATE_SUB(NOW(), INTERVAL 5 MINUTE) 
                THEN 'active' 
                ELSE 'inactive' 
            END as activity_status
        FROM users u
        LEFT JOIN user_status us ON u.id = us.user_id
        WHERE u.id = ?
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $userStatus = $result->fetch_assoc();
    $stmt->close();

    echo json_encode($userStatus);
    exit;

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
    exit;
}