<?php
include('inc/essentials.php');
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel - USER</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
    <?php require('inc/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">USER</h3>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>USER NAME</th>
                            <th>phone</th>
                            <th>post code</th>
                            <th>address</th>
                            <th>Birth of date</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('inc/db_config.php');
                        $query = "SELECT * FROM register";
                        $result = mysqli_query($con, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $username = $row['name'];
                           
                            $phone = $row['phone'];
                            $postcode = $row['post code'];
                            $address = $row['address'];
                            $Brithofdate = $row['birth_date'];
                            ?>

                            <tr>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $phone; ?></td>
                                <td><?php echo $postcode; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $Brithofdate; ?></td>
                                <td>
                                    <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s-<?php echo $roomId; ?>">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit modal for each row -->
                            <div class="modal fade" id="general-s-<?php echo $roomId; ?>" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form>
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit user</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label"> Name</label>
                                                    <input type="text" name="room-name" id="room_name_<?php echo $roomId; ?>" class="form-control shadow-none" value="<?php echo $roomName; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">email</label>
                                                    <input type="text" name="room-price" id="room_price_<?php echo $roomId; ?>" class="form-control shadow-none" value="<?php echo $price; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">phone</label>
                                                    <input type="text" name="room-quantity" id="room_quantity_<?php echo $roomId; ?>" class="form-control shadow-none" value="<?php echo $quantity; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">post code</label>
                                                    <input type="text" name="room-quantity" id="room_quantity_<?php echo $roomId; ?>" class="form-control shadow-none" value="<?php echo $quantity; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">address</label>
                                                    <input type="text" name="room-quantity" id="room_quantity_<?php echo $roomId; ?>" class="form-control shadow-none" value="<?php echo $quantity; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Birth of date</label>
                                                    <input type="text" name="room-quantity" id="room_quantity_<?php echo $roomId; ?>" class="form-control shadow-none" value="<?php echo $quantity; ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" onclick="updateRoom(<?php echo $roomId; ?>)" class="btn btn-dark text-white shadow-none">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php
                        }
                        // Close the database connection
                        mysqli_close($con);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function updateRoom(roomId) {
            // Retrieve values from the modal fields
            var roomName = document.getElementById('room_name_' + roomId).value;
            var price = document.getElementById('room_price_' + roomId).value;
            var quantity = document.getElementById('room_quantity_' + roomId).value;

            // Prepare data to be sent via AJAX
            var data = {
                room_id: roomId,
                room_name: roomName,
                price: price,
                quantity: quantity
            };

            // Send the updated data to the server using AJAX
            $.ajax({
                type: 'POST',
                url: 'update_room.php', // Replace with your server-side script to handle the update
                data: data,
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    // Handle the response from the server
                    if (response.success) {
                        // Optionally, update the specific row in the table or reload the entire page
                        // For demonstration, we'll reload the page
                        location.reload();
                    } else {
                        alert('Failed to update room. Please try again.');
                    }
                },
                error: function() {
                    alert('Error in the AJAX request');
                }
            });
        }
    </script>
</body>
</html>
