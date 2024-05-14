<?php
session_start(); // Start session

include 'db_connection.php';

// Function to validate admin login
// Function to validate admin login
function adminLogin($email, $password) {
    global $conn;
    $sql = "SELECT * FROM Admin WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['admin_username'] = $row['username']; // Store admin's username in session
            return true;
        }
    }
    return false;
}


// Function to validate student login// Function to validate student login
function studentLogin($email, $password) {
    global $conn;
    $sql = "SELECT * FROM Students WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['student_username'] = $row['name']; // Store student's username in session
            // $_COOKIE['department'] = $row['name']; // Store student's username in session
            return true;

        }
    }
    return false;
}


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    if ($user_type == 'admin') {
        if (adminLogin($email, $password)) {
            header("Location: home.php"); // Redirect to admin dashboard
        } else {
            echo "Invalid email or password for admin";
        }
    } elseif ($user_type == 'student') {
        if (studentLogin($email, $password)) {
            header("Location: student_home.php"); // Redirect to student dashboard
        } else {
            echo "Invalid email or password for student";
        }
    }
}
exit
?>
