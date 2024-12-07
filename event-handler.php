<?php
// Add these at the top of event-handler.php
date_default_timezone_set('Asia/Manila');
ini_set('date.timezone', 'Asia/Manila');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'services/session.php';
include 'services/session-auth.php';
include 'services/database.php';

header('Content-Type: application/json');

// Ensure user ID is set
if (!isset($id)) {
    http_response_code(401);
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? null;

try {
    switch ($action) {
        case 'create':
            createEvent($conn, $id);
            break;
        case 'update':
            updateEvent($conn, $id);
            break;
        case 'delete':
            deleteEvent($conn, $id);
            break;
        case 'list':
            listEvents($conn, $id);
            break;
        default:
            throw new Exception('Invalid action: ' . ($action ?? 'null'));
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}

function createEvent($conn, $id)
{
    // Sanitize and validate input
    $title = trim(strip_tags($_POST['title']));

    // Validate title
    if (empty($title)) {
        throw new Exception("Event title cannot be empty");
    }

    // Create DateTime objects with explicit timezone
    $manilaTimezone = new DateTimeZone('Asia/Manila');

    // Parse input dates with Manila timezone
    $startDate = new DateTime($_POST['start'], $manilaTimezone);
    $endDate = !empty($_POST['end'])
        ? new DateTime($_POST['end'], $manilaTimezone)
        : clone $startDate;

    $allDay = !empty($_POST['all_day']) ? 1 : 0;

    // For all-day events, set specific time boundaries in Manila timezone
    if ($allDay) {
        $startDate->setTime(0, 0, 0);
        $endDate->setTime(23, 59, 59);
    } else {
        // Ensure minimum event duration
        if ($endDate <= $startDate) {
            $endDate = clone $startDate;
            $endDate->modify('+1 hour');
        }
    }

    // Debug logging with timezone information
    error_log("Creating Event - Start (Manila): " . $startDate->format('Y-m-d H:i:s T'));
    error_log("Creating Event - End (Manila): " . $endDate->format('Y-m-d H:i:s T'));

    // Store in database as UTC for consistency
    $startDateUTC = clone $startDate;
    $startDateUTC->setTimezone(new DateTimeZone('Asia/Manila'));
    $endDateUTC = clone $endDate;
    $endDateUTC->setTimezone(new DateTimeZone('Asia/Manila'));

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO events 
        (user_id, title, start_date, end_date, all_day, category) 
        VALUES (?, ?, ?, ?, ?, ?)");

    // Format dates for database storage in UTC
    $formattedStartDate = $startDateUTC->format('Y-m-d H:i:s');
    $formattedEndDate = $endDateUTC->format('Y-m-d H:i:s');

    // Default category if not provided
    $category = $_POST['category'] ?? 'bg-primary';

    // Bind parameters
    $stmt->bind_param(
        "isssis",
        $id,
        $title,
        $formattedStartDate,
        $formattedEndDate,
        $allDay,
        $category
    );

    // Execute and handle response
    if ($stmt->execute()) {
        $newEventId = $stmt->insert_id;
        echo json_encode([
            'status' => 'success',
            'id' => $newEventId,
            'start' => $formattedStartDate,
            'end' => $formattedEndDate
        ]);
    } else {
        throw new Exception('Failed to create event: ' . $stmt->error);
    }
}

function updateEvent($conn, $id)
{
    // Validate required parameters
    $requiredParams = ['id', 'title', 'start', 'category'];
    foreach ($requiredParams as $param) {
        if (!isset($_POST[$param]) || empty($_POST[$param])) {
            throw new Exception("Missing or empty required parameter: $param");
        }
    }

    $event_id = $_POST['id'];
    $title = $_POST['title'];
    $start = $_POST['start'];

    // Ensure end is not an empty string
    $end = (!empty($_POST['end']) && $_POST['end'] !== 'undefined') ? $_POST['end'] : $start;

    $category = $_POST['category'];
    $all_day = isset($_POST['all_day']) && $_POST['all_day'] == true ? 1 : 0;

    // Validate user ID
    if (!$id) {
        throw new Exception('Invalid user ID');
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("UPDATE events SET title = ?, start_date = ?, end_date = ?, category = ?, all_day = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssssiis", $title, $start, $end, $category, $all_day, $event_id, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        throw new Exception('Failed to update event: ' . $stmt->error);
    }
}

function deleteEvent($conn, $id)
{
    // Ensure an event ID is provided
    if (!isset($_POST['id'])) {
        throw new Exception('Missing event ID');
    }

    $event_id = $_POST['id'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $event_id, $id);

    if ($stmt->execute()) {
        // Check if any rows were actually deleted
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            throw new Exception('Event not found or you do not have permission to delete');
        }
    } else {
        throw new Exception('Failed to delete event');
    }
}

function listEvents($conn, $id)
{
    // Default to fetching all events if no date range is provided
    $start = $_GET['start'] ?? null;
    $end = $_GET['end'] ?? null;

    // Prepare base query
    $query = "SELECT id, title, start_date AS start, end_date AS end, category, all_day FROM events WHERE user_id = ?";
    $params = [$id];
    $types = 'i';

    // Add date range filtering if start and end are provided
    if ($start && $end) {
        $query .= " AND (start_date BETWEEN ? AND ? OR end_date BETWEEN ? AND ?)";
        $params = array_merge($params, [$start, $end, $start, $end]);
        $types .= 'ssss';
    }

    // Prepare and execute statement
    $stmt = $conn->prepare($query);

    // Dynamically bind parameters based on the number of parameters
    if (count($params) > 1) {
        $stmt->bind_param($types, ...$params);
    } else {
        $stmt->bind_param($types, $params[0]);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    $manilaTimeZone = new DateTimeZone('Asia/Manila');
    while ($row = $result->fetch_assoc()) {
        // Create DateTime objects in Manila time zone
        $startDateTime = new DateTime($row['start'], $manilaTimeZone);
        $endDateTime = $row['end'] ? new DateTime($row['end'], $manilaTimeZone) : null;

        // Ensure correct time representation
        $row['start'] = $startDateTime->format('c'); // ISO 8601 format
        $row['end'] = $endDateTime ? $endDateTime->format('c') : null;

        // Debug logging
        error_log("Event Start: " . $startDateTime->format('Y-m-d H:i:s T'));

        // Add className for event color
        $row['className'] = $row['category'] ?? 'bg-primary';

        $events[] = $row;
    }

    echo json_encode($events);
}
