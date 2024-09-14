<?php session_start();

// Check if the user is logged in by checking a session variable
if (isset($_SESSION['user_id'])) {
    echo json_encode(['logged_in' => true]);
} else {
    echo json_encode(['logged_in' => false]);
} ?>