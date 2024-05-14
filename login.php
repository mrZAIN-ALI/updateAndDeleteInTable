
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <style>
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var emailError = document.getElementById("emailError");
            var passwordError = document.getElementById("passwordError");

            // Email validation regex
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Reset error messages
            emailError.innerHTML = "";
            passwordError.innerHTML = "";

            // Check if email is in valid format
            if (!emailRegex.test(email)) {
                emailError.innerHTML = "Please enter a valid email address.";
                return false;
            }

            // Check if password contains at least 5 characters
            if (password.length < 5) {
                passwordError.innerHTML = "Password must contain at least 5 characters.";
                return false;
            }

            return true;
        }
    </script>

</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="./login_process.php" onsubmit="return validateForm()">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <span class="error" id="emailError"></span><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <span class="error" id="passwordError"></span><br>
        <label for="user_type">Login as:</label><br>
        <select id="user_type" name="user_type">
            <option value="admin">Admin</option>
            <option value="student">Student</option>
        </select><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
