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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve product information from the form
    $productName = $_POST['product_name'];
    $productImagePath = $_POST['image_path'];
    $productExDate = $_POST['ex_date'];

    // Insert the new product into the database
    $insertQuery = "INSERT INTO product (product_name, image_path, ex_date) VALUES ('$productName', '$productImagePath', '$productExDate')";
    $insertResult = mysqli_query($con, $insertQuery);

    // Check if the insertion was successful
    if ($insertResult) {
        echo '<div class="alert alert-success" role="alert">Product added successfully!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error adding product: ' . mysqli_error($con) . '</div>';
    }
}

// Sample query to fetch product details
$bookingQuery = "SELECT * FROM product";
$bookingResult = mysqli_query($con, $bookingQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel - product</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">PRODUCT</h3>
                
                <!-- Form to add a new product -->
                <form method="post">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="image_path">Image Path</label>
                            <input type="text" class="form-control" id="image_path" name="image_path" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="ex_date">Expiry Date</label>
                            <input type="date" class="form-control " id="ex_date" name="ex_date" required>
                        </div>
                        <div class="form-group col-md-3">
                            <button type="submit" class="btn btn-primary  mt-4">Add Product</button>
                        </div>
                    </div>
                </form>
                
                <?php
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
                                <td><img src="<?php echo $bookingRow['image_path']; ?>" alt="Image" style="width:100px; height: 80;"></td>
                                <td><?php echo $bookingRow['product_name']; ?></td>
                                <td><?php echo $bookingRow['ex_date']; ?></td>
                                <!-- Add more cells as needed -->
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>

    <!-- Modals for detailed information -->
    <!-- ... (your existing modal code) ... -->
</body>
</html>
