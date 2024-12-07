<?php
include 'services/database.php';
include 'services/session.php';
include 'services/session-auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE id != ?");
    $stmt->execute([$_SESSION['id']]);
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($users);
}