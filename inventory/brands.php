<?php
    require_once('../dbconfig.php');
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands</title>
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css" />
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
    <div style="position: absolute; left: 0; top: 0;" id="sidebar-placeholder"><?php include("../sidebar.php") ?></div>
        <h3>Brands</h3>
        <table id="ictnetworkhardwareTbl" class="display table table-light" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Brand Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql="
                    SELECT * FROM brands_tbl
                    ";
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $result = $query->fetchAll();
                    $count = 1;
                    foreach ($result as $row) {
                ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $row['name'] ?></td>
                    <td>
                        <button id="editBtn" onclick="get('<?= $row['brand_id'] ?>')" type="button" data-id="<?= $row['brand_id'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                    </td>
                    
                </tr>
                <?php $count++; } ?>
        </table>

        <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Brand</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="needs-validation" novalidate id="updateForm" name="updateForm" method="post">
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="brandInp" name="brandInp" required>
                        <label for="brandInp" class="form-label" id="brandLbl">Brand Name</label>
                        <div class="invalid-feedback">
                            Please enter Brand Name
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button onclick="update()" type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>
        
        </div>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6952492a89.js" crossorigin="anonymous"></script>
    <script>
        function get(brand_id) {
            $.ajax({
                type: "GET",
                url: "./get_brand.php",
                data: {brand_id: brand_id},
                success: function (res) {
                    console.log(res);
                    // res = JSON.parse(res);
                    // $("#brandInp").val(res.brand_name);
                }
            });
        }

        function update() {
            $.ajax({
                type: "POST",
                url: "./update.php",
                data: {
                    mac_address: $("#macInp").val(),
                    type_of_hardware: $("#typeofhardwareInp").val(),
                    brand: $('#brandInp').val(),
                    model: $('#modelInp').val(),
                    serial_number:$('#serialnumberInp').val(),
                    date_of_purchase:$('#dateofpurchaseInp').val(),
                    warranty:$('#warrantyInp').val(),
                    employee_id:$('#ownerInp').val(),
                    status:$('#statusInp').val(),
                },
                success: function (res) {
                    Swal.fire({
                        title: 'Success!',
                        text: res,
                        icon: 'success',
                        confirmButtonText: 'Okay'
                    }).then(()=>location.reload())
                },
                error: function (res) {
                    Swal.fire({
                        title: 'Error!',
                        text: res,
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    }).then(()=>location.reload())
                }
            });
        }

        function change_status(userStatus, eid) {
            $.ajax({
                type: "POST",
                url: "./changeStatus.php",
                data: {
                    employee_id: eid,
                    status: userStatus,
                },
                success: function (res) {
                    Swal.fire({
                        title: 'Success!',
                        text: res,
                        icon: 'success',
                        confirmButtonText: 'Okay'
                    }).then(()=>location.reload())
                },
                error: function (res) {
                    Swal.fire({
                        title: 'Error!',
                        text: res,
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    }).then(()=>location.reload())
                }
            });
        }

        function transfer() {
            if ($('#newownerInp').val() == $('#currentownerInp').val()) {
                Swal.fire({
                        title: 'Error!',
                        text: "Current Owner cannot be the New Owner",
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    })
            } else {
                $.ajax({
                    type: "POST",
                    url: "./transfer.php",
                    data: {
                        mac_address: $("#macInp").val(),
                        current_owner: $('#currentownerInp').val(),
                        new_owner: $('#newownerInp').val(),
                    }
                }).then((res) => {
                    if (res > 0) {
                        Swal.fire({
                            title: 'Success!',
                            text: "Transferred successfully",
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        }).then(()=>location.reload())
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: "Transferred failed",
                            icon: 'error',
                            confirmButtonText: 'Okay'
                        }).then(()=>location.reload())
                    }
                });
            }
        }

        $(document).ready(function () {
            $('#ictnetworkhardwareTbl').DataTable();
        });
    </script>
</html>