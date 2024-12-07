<?php
header('Content-Type: application/json');

include 'services/database.php';
include 'services/session.php';
include 'services/session-auth.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request method');
    }

    $current_user_id = $_SESSION['id'] ?? null;
    $other_user_id = $_GET['id'] ?? null;

    if (!$current_user_id || !$other_user_id) {
        throw new Exception('Missing user IDs');
    }

    // Prepare and execute messages query
    $stmt = $conn->prepare("
        SELECT 
            m.id, 
            m.sender_id, 
            m.receiver_id, 
            m.message, 
            m.timestamp, 
            u.username AS sender_username
        FROM chat_messages m
        JOIN users u ON m.sender_id = u.id
        WHERE 
            (m.sender_id = ? AND m.receiver_id = ?) 
            OR 
            (m.sender_id = ? AND m.receiver_id = ?)
        ORDER BY m.timestamp ASC
    ");

    $stmt->bind_param("iiii", $current_user_id, $other_user_id, $other_user_id, $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    $stmt->close();

    // Prepare and execute user query
    $userStmt = $conn->prepare("SELECT id, username FROM users WHERE id = ?");
    $userStmt->bind_param("i", $other_user_id);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $recipientUser = $userResult->fetch_assoc();
    $userStmt->close();

    // Return messages and recipient user details
    echo json_encode([
        'messages' => $messages,
        'recipient' => $recipientUser
    ]);
    exit;

} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error',
        'details' => $e->getMessage()
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Request error',
        'details' => $e->getMessage()
    ]);
    exit;
}