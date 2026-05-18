<?php
header('Content-Type: application/json');
include 'connect.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        $response['message'] = 'All fields are required.';
        echo json_encode($response); exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email format.';
        echo json_encode($response); exit;
    }

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Message sent successfully!';
    } else {
        $response['message'] = 'Database error. Try again later.';
    }
    $stmt->close(); $conn->close();
} else {
    $response['message'] = 'Invalid request.';
}

echo json_encode($response);
?>