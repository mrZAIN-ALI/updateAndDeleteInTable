<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

include 'db_connection.php';

// Function to retrieve all students
function getAllStudents() {
    global $conn;
    $sql = "SELECT * FROM Students";
    $result = $conn->query($sql);
    $students = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
    return $students;
}

// Function to update student's bill status
function updateBillStatus($student_id, $bill_status) {
    global $conn;
    $sql = "UPDATE Students SET bill_paid = '$bill_status' WHERE id = '$student_id'";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Check if form is submitted to update bill status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $student_id = $_POST['student_id'];
    $bill_status = $_POST['bill_status'];
    updateBillStatus($student_id, $bill_status);
}
// Function to delete student
function deleteStudent($student_id) {
  global $conn;
  $sql = "DELETE FROM Students WHERE id = '$student_id'";
  if ($conn->query($sql) === TRUE) {
      return true;
  } else {
      return false;
  }
}

// Function to add new student
function addStudent($roll_number, $name, $email, $password, $address, $department, $room_allocated, $bill_paid) {
  global $conn;
  $sql = "INSERT INTO Students (roll_number, name, email, password, address, department, room_allocated, bill_paid) 
          VALUES ('$roll_number', '$name', '$email', '$password', '$address', '$department', '$room_allocated', '$bill_paid')";
  if ($conn->query($sql) === TRUE) {
      return true;
  } else {
      return false;
  }
}

// Function to update student information
function updateStudent($student_id, $roll_number, $name, $email, $address, $department, $room_allocated, $bill_paid) {
  global $conn;
  $sql = "UPDATE Students SET roll_number = '$roll_number', name = '$name', email = '$email', address = '$address', 
          department = '$department', room_allocated = '$room_allocated', bill_paid = '$bill_paid' WHERE id = '$student_id'";
  if ($conn->query($sql) === TRUE) {
      return true;
  } else {
      return false;
  }
}

// Function to search student by roll number
function searchStudent($roll_number) {
  global $conn;
  $sql = "SELECT * FROM Students WHERE roll_number = '$roll_number'";
  $result = $conn->query($sql);
  $student = null;
  if ($result->num_rows > 0) {
      $student = $result->fetch_assoc();
  }
  return $student;
}

// Check if form is submitted for deleting student
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_student'])) {
  $student_id = $_POST['student_id'];
  deleteStudent($student_id);
}
// Check if form is submitted for adding new student
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_student'])) {
  $roll_number = $_POST['roll_number'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password']; // Password should be hashed before storing in database
  $address = $_POST['address'];
  $department = $_POST['department'];
  $room_allocated = $_POST['room_allocated'];
  $bill_paid = $_POST['bill_paid'];
  addStudent($roll_number, $name, $email, $password, $address, $department, $room_allocated, $bill_paid);
}

// Check if form is submitted for updating student information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_student'])) {
  $student_id = $_POST['student_id'];
  $roll_number = $_POST['roll_number'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $department = $_POST['department'];
  $room_allocated = $_POST['room_allocated'];
  $bill_paid = $_POST['bill_paid'];
  updateStudent($student_id, $roll_number, $name, $email, $address, $department, $room_allocated, $bill_paid);
}

// Check if form is submitted for searching student by roll number
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_student'])) {
  $search_roll_number = $_POST['search_roll_number'];
  $searched_student = searchStudent($search_roll_number);
}

// Get all students
$students = getAllStudents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['admin_username']; ?></h1>
        <form method="post" action="login.php">
            <input type="submit" name="signout" value="Sign Out">
        </form>
        <link rel="stylesheet" href="./home.css">
    </header>
    <main>
        <h2>All Students</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Roll Number</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Department</th>
                <th>Room Allocated</th>
                <th>Bill Paid</th>
                <th>Action</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo $student['roll_number']; ?></td>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['email']; ?></td>
                    <td><?php echo $student['address']; ?></td>
                    <td><?php echo $student['department']; ?></td>
                    <td><?php echo $student['room_allocated']; ?></td>
                    <td><?php echo $student['bill_paid'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                            <select name="bill_status">
                                <option value="0" <?php if (!$student['bill_paid']) echo 'selected'; ?>>No</option>
                                <option value="1" <?php if ($student['bill_paid']) echo 'selected'; ?>>Yes</option>
                            </select>
                            <input type="submit" name="update_status" value="Update">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Students who have Paid Bill</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <?php if ($student['bill_paid']): ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>

        <h2>Students who have Not Paid Bill</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <?php if (!$student['bill_paid']): ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>

        <h2>Delete Student</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="delete_student_id">Enter Student ID to Delete:</label><br>
    <input type="text" id="delete_student_id" name="student_id" required><br><br>
    <input type="submit" name="delete_student" value="Delete Student">
</form>

<h2>Add New Student</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="roll_number">Roll Number:</label><br>
    <input type="text" id="roll_number" name="roll_number" required><br>
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>
    <label for="address">Address:</label><br>
    <input type="text" id="address" name="address" required><br>
    <label for="department">Department:</label><br>
    <input type="text" id="department" name="department" required><br>
    <label for="room_allocated">Room Allocated:</label><br>
    <input type="text" id="room_allocated" name="room_allocated" required><br>
    <label for="bill_paid">Bill Paid (0 for No, 1 for Yes):</label><br>
    <input type="number" id="bill_paid" name="bill_paid" min="0" max="1" required><br><br>
    <input type="submit" name="add_student" value="Add Student">
</form>

<h2>Update Student Information</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="update_student_id">Enter Student ID to Update:</label><br>
    <input type="text" id="update_student_id" name="student_id" required><br><br>
    
    <label for="roll_number">Roll Number:</label><br>
    <input type="text" id="roll_number" name="roll_number" required><br>
    
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br>
    
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>
    
    <label for="address">Address:</label><br>
    <input type="text" id="address" name="address" required><br>
    
    <label for="department">Department:</label><br>
    <input type="text" id="department" name="department" required><br>
    
    <label for="room_allocated">Room Allocated:</label><br>
    <input type="text" id="room_allocated" name="room_allocated" required><br>
    
    <label for="bill_paid">Bill Paid (0 for No, 1 for Yes):</label><br>
    <input type="number" id="bill_paid" name="bill_paid" min="0" max="1" required><br><br>
    
    <input type="submit" name="update_student" value="Update Student">
</form>

<h2>Search Student by Roll Number</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="search_roll_number">Enter Roll Number:</label><br>
            <input type="text" id="search_roll_number" name="search_roll_number" required><br><br>
            <input type="submit" name="search_student" value="Search Student">
        </form>

        <!-- Display searched student's information -->
        <?php if(isset($searched_student)): ?>
            <?php if($searched_student): ?>
                <h2>Search Result</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Roll Number</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Department</th>
                        <th>Room Allocated</th>
                        <th>Bill Paid</th>
                    </tr>
                    <tr>
                        <td><?php echo $searched_student['id']; ?></td>
                        <td><?php echo $searched_student['roll_number']; ?></td>
                        <td><?php echo $searched_student['name']; ?></td>
                        <td><?php echo $searched_student['email']; ?></td>
                        <td><?php echo $searched_student['address']; ?></td>
                        <td><?php echo $searched_student['department']; ?></td>
                        <td><?php echo $searched_student['room_allocated']; ?></td>
                        <td><?php echo $searched_student['bill_paid'] ? 'Yes' : 'No'; ?></td>
                    </tr>
                </table>
            <?php else: ?>
                <p>No student found with the provided roll number.</p>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</body>
</html>
