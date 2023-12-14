<!-- Include Bootstrap CSS and JS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-Vkoo8+8F0KVI1+phy6tvPz35tf+2TxePeOUEBPGqFMyTN5Vk5UlC6xP7T2Vh0" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- ... (your existing HTML code) ... -->

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

// Function to get total booking count
function getTotalproduct($con)
{
    $stmt = mysqli_prepare($con, "SELECT COUNT(*) AS total_product FROM product");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total_product'];
}

// Fetch data
$totalproduct = getTotalproduct($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel - Dashboard</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">DASHBOARD</h3>

                <!-- Display total product -->
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body ">
                            <h5 class="card-title">Total product</h5>
                            <p class="card-text"><?php echo $totalproduct; ?></p>
                            <a href="#totalBookingsDetails" data-toggle="modal" data-target="#totalBookingsDetails">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         
             <!-- Modal for total bookings details -->
             <div class="modal fade" id="totalBookingsDetails" tabindex="-1" role="dialog" aria-labelledby="totalBookingsDetailsLabel" aria-hidden="true">
             <div class="modal-dialog" role="document">
              <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title"> product Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
             </div>
             <div class="modal-body">
                <!-- Add your database query and data rendering logic here -->
                <?php
                // Sample query to fetch booking details
                $bookingQuery = "SELECT * FROM product";
                $bookingResult = mysqli_query($con, $bookingQuery);

                // Render the data in a table
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>IMAGE</th>
                            <th>NAME</th>
                            <th>EX.DATE</th>
                            <!-- Add more columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($bookingRow = mysqli_fetch_assoc($bookingResult)) : ?>
                            <tr>
                                <td><?php echo $bookingRow['product_id']; ?></td>
                                <td><img src="<?php echo $bookingRow['image_path']; ?>" alt="Image" style="width:100px; height: 100;"></td>
                                <td><?php echo $bookingRow['product_name']; ?></td>
                                <td><?php echo $bookingRow['ex_date']; ?></td>
                                <!-- Add more cells as needed -->
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    <?php require('inc/scripts.php'); ?>

    <!-- Modals for detailed information -->

    <div class="modal fade" id="totalBookingsDetails" tabindex="-1" role="dialog" aria-labelledby="totalBookingsDetailsLabel" aria-hidden="true">
        <!-- Add your modal content for total bookings details here -->
    </div>

    <div class="modal fade" id="totalGuestDetails" tabindex="-1" role="dialog" aria-labelledby="totalGuestDetailsLabel" aria-hidden="true">
        <!-- Add your modal content for total guest details here -->
    </div>

    <div class="modal fade" id="totalAmountDetails" tabindex="-1" role="dialog" aria-labelledby="totalAmountDetailsLabel" aria-hidden="true">
        <!-- Add your modal content for total amount details here -->
    </div>

    <div class="modal fade" id="newBookingsDetails" tabindex="-1" role="dialog" aria-labelledby="newBookingsDetailsLabel" aria-hidden="true">
        <!-- Add your modal content for new bookings details here -->
    </div>
</body>
</html>
