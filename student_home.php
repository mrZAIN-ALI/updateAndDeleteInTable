<?php
session_start();

// Check if student is logged in
if (!isset($_SESSION['student_username'])) {
    header("Location: login.php"); // Redirect to student login page if not logged in
    exit();
}

// Get student's name from session
$student_name = $_SESSION['student_username'];

// Set department cookie
if (isset($_COOKIE['department'])) {
    $department = $_COOKIE['department'];
} else {
    $department = "Unknown";
}

// Function to display all student information
function displayStudentInfo()
{
    // You should retrieve the student's information from the database
    // For demonstration, let's assume we have a student array with information
    $student = array(
        'Roll Number' => 'ST12345',
        'Name' => 'John Doe',
        'Email' => 'john@example.com',
        'Address' => '123 Main Street, City',
        'Department' => 'Computer Science',
        'Room Allocated' => 'A101',
        'Bill Paid' => 'Yes' // Assuming it's Yes for this example
    );

    // Display student information in a table
    echo '<table>';
    foreach ($student as $key => $value) {
        echo '<tr>';
        echo '<td>' . $key . '</td>';
        echo '<td>' . $value . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        main {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        @media screen and (max-width: 768px) {
            header {
                padding: 15px;
            }

            .container {
                width: 90%;
            }

            main {
                padding: 10px;
            }

            table {
                font-size: 14px;
            }

            input[type="submit"] {
                padding: 8px 16px;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Welcome, <?php echo $student_name; ?></h1>
        <p>Department: <?php echo $department; ?></p>
        <form method="post" action="login.php">
            <input type="submit" name="signout" value="Sign Out">
        </form>
    </header>
    <main>
        <h2>Student Information</h2>
        <?php displayStudentInfo(); ?>
    </main>
</body>

</html>