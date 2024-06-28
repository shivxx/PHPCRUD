<?php
include 'connect.php';

$id = $_GET['updateid'];

$sql_user = "SELECT * FROM `users` WHERE id = $id";
$result_user = mysqli_query($con, $sql_user);
$row_user = mysqli_fetch_assoc($result_user);

$name = $row_user['name'];
$email = $row_user['email'];
$mobile = $row_user['mobile'];
$gender = $row_user['gender'];

$sql_experience = "SELECT * FROM `experience` WHERE user_id = $id";
$result_experience = mysqli_query($con, $sql_experience);
$row_experience = mysqli_fetch_assoc($result_experience);

$company = isset($row_experience['company']) ? $row_experience['company'] : '';
$years = isset($row_experience['years']) ? $row_experience['years'] : '';
$months = isset($row_experience['months']) ? $row_experience['months'] : '';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $gender = $_POST['gender'];

    $sql_update_user = "UPDATE `users` SET name='$name', email='$email', mobile='$mobile', gender='$gender' WHERE id = $id";
    $result_update_user = mysqli_query($con, $sql_update_user);

    $company = $_POST['company'];
    $years = $_POST['years'];
    $months = $_POST['months'];

    if ($row_experience) {
        $sql_update_experience = "UPDATE `experience` SET company='$company', years='$years', months='$months' WHERE user_id = $id";
    } else {
        $sql_update_experience = "INSERT INTO `experience` (user_id, company, years, months) VALUES ($id, '$company', '$years', '$months')";
    }
    $result_update_experience = mysqli_query($con, $sql_update_experience);

    if ($result_update_user && $result_update_experience) {
        header('location: display.php');
        exit();
    } else {
        die(mysqli_error($con));
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update User and Experience</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <form method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Enter Your Name" maxlength="50" name="name" autocomplete="off" value="<?php echo $name; ?>">
            </div>
            <br>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" placeholder="Enter Your Email" maxlength="50" name="email" autocomplete="off" value="<?php echo $email; ?>">
            </div>
            <br>
            <div class="form-group">
                <label>Mobile Number</label>
                <input type="text" class="form-control" placeholder="Enter Your Mobile Number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" pattern="[0-9]*" inputmode="numeric" name="mobile" autocomplete="off" value="<?php echo $mobile; ?>">
            </div>
            <br>
            <div class="form-group">
                <label for="gender">Gender</label><br>
                <select class="form-control" id="gender" name="gender">
                    <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if ($gender == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label>Company</label>
                <input type="text" class="form-control" placeholder="Enter Company Name" maxlength="50" name="company" autocomplete="off" value="<?php echo $company; ?>" required>
            </div>
            <br>
            <div class="form-group">
                <label>Years of Experience</label>
                <input type="number" class="form-control" placeholder="Enter Years" name="years" autocomplete="off" value="<?php echo $years; ?>" required>
            </div>
            <br>
            <div class="form-group">
                <label>Months of Experience</label>
                <input type="number" class="form-control" placeholder="Enter Months" name="months" autocomplete="off" value="<?php echo $months; ?>" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
        </form>
    </div>
</body>

</html>
