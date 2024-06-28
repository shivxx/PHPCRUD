<?php
include 'connect.php';

if (isset($_POST['submit'])) {
    // Retrieve user data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $gender = $_POST['gender'];

    // Ensure to sanitize input to prevent SQL injection
    $name = mysqli_real_escape_string($con, $name);
    $email = mysqli_real_escape_string($con, $email);
    $mobile = mysqli_real_escape_string($con, $mobile);
    $gender = mysqli_real_escape_string($con, $gender);

    // Insert into users table
    $sql_user = "INSERT INTO `users` (name, email, mobile, gender)
                 VALUES ('$name', '$email', '$mobile', '$gender')";

    if (mysqli_query($con, $sql_user)) {
        $user_id = mysqli_insert_id($con); // Get the auto-generated ID of the user

        // Insert into experience table
        $company = $_POST['company'];
        $years = $_POST['years'];
        $months = $_POST['months'];

        // Ensure to sanitize input to prevent SQL injection
        $company = mysqli_real_escape_string($con, $company);
        $years = mysqli_real_escape_string($con, $years);
        $months = mysqli_real_escape_string($con, $months);

        $sql_experience = "INSERT INTO `experience` (user_id, company, years, months)
                           VALUES ('$user_id', '$company', '$years', '$months')";

        if (mysqli_query($con, $sql_experience)) {
            // Data inserted successfully
            header('location: display.php');
            exit();
        } else {
            die('Error: ' . mysqli_error($con));
        }
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User and Experience</title>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <form method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Enter Your Name" maxlength="50" name="name" autocomplete="off" required>
            </div>
            <br>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" placeholder="Enter Your Email" maxlength="50" name="email" autocomplete="off" required>
            </div>
            <br>
            <div class="form-group">
                <label>Mobile Number</label>
                <input type="text" class="form-control" placeholder="Enter Your Mobile Number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" pattern="[0-9]*" inputmode="numeric" name="mobile" autocomplete="off" required>
            </div>
            <br>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <br>
            <!-- Experience Fields -->
            <div class="form-group">
                <label>Company</label>
                <input type="text" class="form-control" placeholder="Enter Company Name" maxlength="50" name="company" autocomplete="off" required>
            </div>
            <br>
            <div class="form-group">
                <label>Years of Experience</label>
                <input type="number" class="form-control" placeholder="Enter Years" name="years" autocomplete="off" required>
            </div>
            <br>
            <div class="form-group">
                <label>Months of Experience</label>
                <input type="number" class="form-control" placeholder="Enter Months" name="months" autocomplete="off" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>
