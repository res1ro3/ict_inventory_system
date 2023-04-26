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
    <title>Transfer</title>
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css" />
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div id="nav-placeholder"></div>
        <h3>Transfer</h3>
        <table id="ictnetworkhardwareTbl" class="display table table-light" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Transfer ID</th>
                    <th>New Owner</th>
                    <th>Old Owner</th>
                    <th>Date Transferred</th>
                    <th>Mac Address</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql="
                    SELECT 
                    ";
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $result = $query->fetchAll();
                    $count = 1;
                    foreach ($result as $row) {
                ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $row['transfer_id'] ?></td>
                    <td><?= $row['employee_id_new'] ?></td>
                    <td><?= $row['employee_id_old'] ?></td>
                    <td><?= $row['date_transferred'] ?></td>
                    <td><?= $row['mac_address'] ?></td>
                    
                </tr>
                <?php $count++; } ?>
        </table>

        <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit ICT Network Hardware</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="needs-validation" novalidate id="updateForm" name="updateForm" method="post">
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="macInp" name="macInp" required>
                        <label for="macInp" class="form-label" id="macLbl">MAC Address</label>
                        <div class="invalid-feedback">
                            Please enter MAC Address
                        </div>
                    </div>

                    <div class="mb-3 form-floating">
                        <select class="form-select" id="typeofhardwareInp" name="typeofhardwareInp" required>
                            <option value="" selected disabled>Select Type of Hardware</option>
                            <option>Equipment</option>
                            <option>Tools</option>
                        </select>
                        <label for="typeofhardwareInp" id="typeofhardwareLbl">Type of Hardware</label>
                        <div class="invalid-feedback">
                            Please select Type of Hardware
                        </div>
                    </div>

                    <div class="mb-3 form-floating">
                        <select class="form-select" id="brandInp" name="brandInp" required>
                            <option value="" selected disabled>Please select Brand</option>
                            <option>HP</option>
                            <option>ACER</option>
                        </select>
                        <label for="brandInp" id="brandLbl">Brand</label>
                        <div class="invalid-feedback">
                            Please select Brand
                        </div>
                    </div>

                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="modelInp" name="modelInp" required>
                        <label for="modelInp" class="form-label" id="modelLbl">Model</label>
                        <div class="invalid-feedback">
                            Please enter Model
                        </div>
                    </div>

                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="serialnumberInp" name="serialnumberInp" required>
                        <label for="serialnumberInp" class="form-label" id="serialnumberLbl">Serial Number</label>
                        <div class="invalid-feedback">
                            Please enter Serial Number
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="mb-3 col form-floating">
                            <input type="date" class="form-control" id="dateofpurchaseInp" name="dateofpurchaseInp" required>
                            <label for="dateofpurchaseInp" class="form-label ps-4" id="dateofpurchaseLbl">Date of Purchase</label>
                            <div class="invalid-feedback">
                                Please set Date of Purchase
                            </div>
                        </div>

                        <div class="col form-floating">
                            <input type="date" class="form-control" id="warrantyInp" name="warrantyInp" required>
                            <label for="warrantyInp" class="form-label ps-4" id="warrantyLbl">End of Warranty</label>
                            <div class="invalid-feedback">
                                Please enter End of Warranty
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 form-floating">
                        <select class="form-select" id="ownerInp" name="ownerInp" disabled>
                            <option value="" selected disabled>Select Owner</option>
                        <?php
                            $sql="SELECT employee_id, username, lname, fname FROM `employee_tbl`";
                            $query = $conn->prepare($sql);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            
                            $count=1;
                            if($query->rowCount() > 0) {
                            //In case that the query returned at least one record, we can echo the records within a foreach loop:
                                foreach($results as $result)
                            {
                        ?>
                            <option value="<?php echo htmlentities($result->employee_id);?>"><?php echo htmlentities($result->lname).', '.htmlentities($result->fname);?></option>
                        <?php }} ?>
                        </select>
                        <label for="ownerInp" id="ownerLbl">Owner</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <select class="form-select" id="statusInp" name="statusInp" required>
                            <option value="" selected disabled>Please select Status</option>
                            <option>Serviceable</option>
                            <option>Non-Serviceable</option>
                        </select>
                        <label for="statusInp" id="statusLbl">Status</label>
                        <div class="invalid-feedback">
                            Please select Status
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
        <!-- Transfer Modal -->
        <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="transferModalLabel">Transfer ICT Network Hardware</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="needs-validation" novalidate id="updateForm" name="updateForm" method="post">
                    <div class="mb-3 col form-floating">
                        <select class="form-select" id="currentownerInp" name="currentownerInp" disabled>
                                <option value="" selected disabled>Select Owner</option>
                            <?php
                                $sql="SELECT employee_id, username, lname, fname FROM `employee_tbl`";
                                $query = $conn->prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                
                                $count=1;
                                if($query->rowCount() > 0) {
                                //In case that the query returned at least one record, we can echo the records within a foreach loop:
                                    foreach($results as $result)
                                {
                            ?>
                                <option value="<?php echo htmlentities($result->employee_id);?>"><?php echo htmlentities($result->lname).', '.htmlentities($result->fname);?></option>
                            <?php }} ?>
                        </select>
                        <label for="currentownerInp" class="form-label" id="currentownerLbl">Current Owner</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <select class="form-select" id="newownerInp" name="newownerInp" required>
                            <option value="" selected disabled>Select New Owner</option>
                        <?php
                            $sql="SELECT employee_id, username, lname, fname FROM `employee_tbl`";
                            $query = $conn->prepare($sql);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            
                            $count=1;
                            if($query->rowCount() > 0) {
                            //In case that the query returned at least one record, we can echo the records within a foreach loop:
                                foreach($results as $result)
                            {
                        ?>
                            <option value="<?php echo htmlentities($result->employee_id);?>"><?php echo htmlentities($result->lname).', '.htmlentities($result->fname);?></option>
                        <?php }} ?>
                        </select>
                        <label for="newownerInp" id="newownerLbl">New Owner</label>
                        <div class="invalid-feedback">
                            Please select New Owner
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button onclick="transfer()" type="button" class="btn btn-primary">Save changes</button>
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
        function get(mac) {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {mac_address:mac},
                success: function (res) {
                    res = JSON.parse(res);
                    $("#macInp").val(res.mac_address);
                    $("#typeofhardwareInp").val(res.type_of_hardware);
                    $('#brandInp').val(res.brand);
                    $('#modelInp').val(res.model);
                    $('#serialnumberInp').val(res.serial_number);
                    $('#dateofpurchaseInp').val(res.date_of_purchase);
                    $('#warrantyInp').val(res.warranty);
                    $('#ownerInp').val(res.employee_id);
                    $('#statusInp').val(res.status);
                }
            });
        }

        function getTransfer(mac) {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {mac_address:mac},
                success: function (res) {
                    res = JSON.parse(res);
                    $("#macInp").val(res.mac_address);
                    $('#ownerInp').val(res.employee_id);
                    $('#currentownerInp').val(res.employee_id);
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
            if ($('#newownerInp option:selected').text() == $('#currentownerInp').val()) {
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
                        new_owner: $('#newownerInp option:selected').val(),
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
            $("#nav-placeholder").load("../nav.html");
        });
    </script>
</html>