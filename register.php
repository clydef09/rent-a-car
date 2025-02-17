<?php
require_once 'connection.php';

if (isset($_POST['check_name'])) { // AJAX request to check name availability
    $name = mysqli_real_escape_string($conn, $_POST['check_name']);
    $sql = "SELECT * FROM users WHERE name = '$name'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<span style='color: red;'>Name already exists.</span>";
    } else {
        echo "<span style='color: green;'>Name is available.</span>";
    }

    mysqli_close($conn);
    exit; // End script here to return only AJAX response
}

if (isset($_POST['regs'])) { // Handle form submission
    require_once('connection.php');
    $name = mysqli_real_escape_string($conn, $_POST['username']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $lic = mysqli_real_escape_string($conn, $_POST['lic']);
    $ph = mysqli_real_escape_string($conn, $_POST['ph']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $cpass = mysqli_real_escape_string($conn, $_POST['cpass']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $Pass = md5($pass);

    if (empty($name) || empty($fname) || empty($lname) || empty($email) || empty($lic) || empty($ph) || empty($pass) || empty($gender)) {
        echo '<script>alert("Please fill in all fields.")</script>';
    } else {
        if ($pass == $cpass) {
            $sql2 = "SELECT * FROM users WHERE EMAIL='$email'";
            $res = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($res) > 0) {
                echo '<script>alert("Email already exists. Please log in.")</script>';
                echo '<script> window.location.href = "index.php";</script>';
            } else {
                $sql = "INSERT INTO users (NAME, FNAME, LNAME, EMAIL, LIC_NUM, PHONE_NUMBER, PASSWORD, GENDER) VALUES ('$name', '$fname', '$lname', '$email', '$lic', '$ph', '$Pass', '$gender')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo '<script>alert("Registration successful. Press OK to log in.")</script>';
                    echo '<script> window.location.href = "index.php";</script>';
                } else {
                    echo '<script>alert("Please check the connection.")</script>';
                }
            }
        } else {
            echo '<script>alert("Passwords do not match.")</script>';
            echo '<script> window.location.href = "register.php";</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>REGISTRATION</title>
    <link rel="stylesheet" href="css/regs.css" type="text/css">
</head>
<body>
    <h1>JOIN OUR FAMILY OF CARS!</h1>
    <div class="main">
        <div class="register">
            <h2>Register Here</h2>
            <form id="register" action="register.php" method="POST" onsubmit="return validatePhoneNumber()">
                <label>Username:</label><br>
                <input type="text" name="username" id="username" placeholder="Enter Username" required>
                <span id="username_status"></span>
                <br><br>

                <label>First Name:</label><br>
                <input type="text" name="fname" placeholder="Enter Your First Name" required>
                <br><br>

                <label>Last Name:</label><br>
                <input type="text" name="lname" placeholder="Enter Your Last Name" required>
                <br><br>

                <label>Email:</label><br>
                <input type="email" name="email" placeholder="Enter Valid Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="ex: example@ex.com">
                <br><br>
                
                <label>License Number:</label><br>
                <input type="text" name="lic" placeholder="Enter Your License Number" required>
                <br><br>

                <label>Phone Number:</label><br>
                <input type="tel" name="ph" id="ph" maxlength="10" onkeypress="return onlyNumberKey(event)" placeholder="Enter Your Phone Number" required>
                <br><br>

                <label>Password:</label><br>
                <input type="password" name="pass" id="psw" placeholder="Enter Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{7,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 7 or more characters">
                <br><br>

                <label>Confirm Password:</label><br>
                <input type="password" name="cpass" placeholder="Re-enter Password" required>
                <br><br>

                <label>Gender:</label><br>
                <input type="radio" name="gender" value="male" required> Male
                <input type="radio" name="gender" value="female" required> Female
                <br><br>

                <input type="submit" value="REGISTER" name="regs" style="background-color: #ff7200; color: white">
            </form>
        </div>
    </div>

    <script>
        document.getElementById('username').addEventListener('input', function() {
            var username = this.value;

            if (username) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'register.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    document.getElementById('username_status').innerHTML = this.responseText;
                };

                xhr.send('check_name=' + encodeURIComponent(username));
            } else {
                document.getElementById('username_status').innerHTML = '';
            }
        });

        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode;
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        function validatePhoneNumber() {
            var phoneInput = document.getElementById('ph').value;
            if (phoneInput.length !== 10) {
                alert("Phone number must be exactly 10 digits.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</body>
</html>