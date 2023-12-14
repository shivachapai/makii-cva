<!-- Include Bootstrap CSS and JS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-Vkoo8+8F0KVI1+phy6tvPz35tf+2TxePeOUEBPGqFMyTN5Vk5UlC6xP7T2Vh0" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<style>
    .bg-light-danger {
        background-color: #ffcccc; /* Light red background color */
    }
</style>

<?php
// Include essentials and perform admin login
require('inc/essentials.php');
adminLogin();

// Database connection details
$hname = 'localhost:3307';
$uname = 'root';
$pass = '';
$db = 'makii';

// Establish a database connection
$con = mysqli_connect($hname, $uname, $pass, $db);
if (!$con) {
    die("Cannot connect to Database " . mysqli_connect_error());
}

// Get the current date
$currentDate = date('Y-m-d');

// Define the range for near expiration (2 days)
$nearExpirationDate = date('Y-m-d', strtotime('+2 days', strtotime($currentDate)));

// Sample query to fetch product details
$bookingQuery = "SELECT * FROM product ORDER BY CASE WHEN ex_date <= '$nearExpirationDate' THEN 0 ELSE 1 END, ex_date";
$bookingResult = mysqli_query($con, $bookingQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel - check</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">CHECK EX_DATE</h3>
                <table class="table">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>IMAGE</th>
            <th>NAME</th>
            <th>EX.DATE</th>
            <th>STATUS</th>
            <th>EDIT</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Display products with "Expiring Soon" status
        while ($bookingRow = mysqli_fetch_assoc($bookingResult)) {
            $statusClass = ($nearExpirationDate >= $bookingRow['ex_date']) ? 'expiring-soon' : 'valid';
            $statusText = ($nearExpirationDate >= $bookingRow['ex_date']) ? '廃棄近い' : 'Valid';
            $rowClass = ($statusText === '廃棄近い') ? 'bg-light-danger' : '';
            echo '<tr class="' . $statusClass . ' ' . $rowClass . '">
                    <td>' . $bookingRow['product_id'] . '</td>
                    <td><img src="' . $bookingRow['image_path'] . '" alt="Image" style="width:100px; height: 80;"></td>
                    <td>' . $bookingRow['product_name'] . '</td>
                    <td>' . $bookingRow['ex_date'] . '</td>
                    <td><span class="text-' . ($statusText === '廃棄近い' ? 'danger' : 'success') . '">' . $statusText . '</span></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal' . $bookingRow['product_id'] . '">Edit</button>
                        <!-- Edit Modal for each product -->
                        <div class="modal fade" id="editModal' . $bookingRow['product_id'] . '" tabindex="-1" role="dialog" aria-labelledby="editModalLabel' . $bookingRow['product_id'] . '" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel' . $bookingRow['product_id'] . '">Edit Expiry Date</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Editable form for updating ex_date -->
                                        <form action="update_ex_date.php" method="post">
                                            <input type="hidden" name="product_id" value="' . $bookingRow['product_id'] . '">
                                            <div class="form-group">
                                                <label for="newExDate">New Expiry Date:</label>
                                                <input type="date" class="form-control" id="newExDate" name="newExDate" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update Expiry Date</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                  </tr>';
        }
        ?>
    </tbody>
</table>

    <?php require('inc/scripts.php'); ?>
</body>
</html>
