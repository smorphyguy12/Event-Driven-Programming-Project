<?php
session_start();

if (isset($_SESSION['student'])) {
    $student_id = $_SESSION['student_id'];
    $fullname = $_SESSION['fullname'];
    $course = $_SESSION['course'];
} else {
    $username = $_SESSION['username'];
}
$id = $_SESSION['id'];
$email = $_SESSION['email'];

