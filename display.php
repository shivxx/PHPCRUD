<?php
include 'connect.php';

$records_per_page = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

$total_records_query = "SELECT COUNT(*) FROM `users`";
$total_records_result = mysqli_query($con, $total_records_query);
$total_records = mysqli_fetch_array($total_records_result)[0];

$sql = "SELECT u.id, u.name, u.email, u.mobile, u.gender, e.company, e.years, e.months
        FROM `users` u
        LEFT JOIN `experience` e ON u.id = e.user_id
        ORDER BY u.id DESC
        LIMIT $offset, $records_per_page";

$result = mysqli_query($con, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($con);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD Operation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div style="text-align: center;">
        <h1>PHP CRUD OPERATION WITH MYSQL</h1>
    </div>

    <div class="container">
        <button class="btn btn-primary my-5"><a href="user.php" class="text-light">Add User</a></button>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Sl No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Company</th>
                    <th scope="col">Years</th>
                    <th scope="col">Months</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial_number = ($page - 1) * $records_per_page + 1;

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $name = $row['name'];
                        $email = $row['email'];
                        $mobile = $row['mobile'];
                        $gender = $row['gender'];
                        $company = $row['company'];
                        $years = $row['years'];
                        $months = $row['months'];

                        echo '<tr>
                                <td>' . $serial_number . '</td>
                                <td>' . $name . '</td>
                                <td>' . $email . '</td>
                                <td>' . $mobile . '</td>
                                <td>' . $gender . '</td>
                                <td>' . $company . '</td>
                                <td>' . $years . '</td>
                                <td>' . $months . '</td>
                                <td>
                                    <button class="btn btn-primary"><a href="update.php?updateid=' . $id . '" class="text-light">Update</a></button>
                                    <button class="btn btn-danger"><a href="delete.php?deleteid=' . $id . '" class="text-light">Delete</a></button>
                                </td>
                              </tr>';

                        $serial_number++;
                    }
                }
                ?>
            </tbody>
        </table>

        <nav>
            <ul class="pagination justify-content-center">
                <?php
                $total_pages = ceil($total_records / $records_per_page);
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = ($i == $page) ? 'active' : '';
                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</body>

</html>
