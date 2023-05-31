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
    <title>Inventory | Hardware</title>
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css" />
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="inventory.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="inventory">
    <div id="sidebar-placeholder"><?php include("../sidebar.php") ?></div>
    <div class="inventory-container">
    <div class="tbl_manage_inventory">
        <div class="dashboard-header" style="margin: 2rem 0">
            <h3>Hardware</h3>
        </div>
            <div>
                <table id="ictnetworkhardwareTbl" class="display table table-light" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type of Hardware</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Owner</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql="
                            SELECT hardware_id, type_of_hardware, brand, model, serial_number, date_of_purchase, warranty, employee_tbl.lname, employee_tbl.fname, ict_network_hardware_tbl.status, owner_name
                            FROM ict_network_hardware_tbl
                            INNER JOIN employee_tbl ON ict_network_hardware_tbl.employee_id=employee_tbl.employee_id;
                            ";
                            $query = $conn->prepare($sql);
                            $query->execute();
                            $result = $query->fetchAll();
                            $count = 1;
                            foreach ($result as $row) {
                        ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $row['type_of_hardware'] ?></td>
                            <td><?= $row['brand'] ?></td>
                            <td><?= $row['model'] ?></td>
                            <td><?= $row['lname'].', '.$row['fname'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td>
                                <button id="viewBtn" onclick="get('<?= $row['hardware_id'] ?>')" type="button" data-id="<?= $row['hardware_id'] ?>" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal">View</button>
                                <button id="editBtn" onclick="getEdit('<?= $row['hardware_id'] ?>')" type="button" data-id="<?= $row['hardware_id'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            </td>
                            
                        </tr>
                        <?php $count++; } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7"><button style="width: 90px;" class="btn btn-success" onclick="location.href='/ict_inventory_system/hardware/add.php'">Add</button></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
    </div>
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
                    <input type="hidden" class="form-control" id="hidInpEdit" name="hidInpEdit">
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="macInpEdit" name="macInpEdit" required>
                        <label for="macInpEdit" class="form-label">MAC Address</label>
                        <div class="invalid-feedback">
                            Please enter MAC Address
                        </div>
                    </div>

                    <div class="mb-3 form-floating">
                        <select class="form-select" id="typeofhardwareInpEdit" name="typeofhardwareInpEdit" required>
                            <option value="" selected disabled>Select Type of Hardware</option>
                            <?php
                            $sql="SELECT * FROM `type_of_hardware_tbl`";
                            $query = $conn->prepare($sql);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            
                            $count=1;
                            if($query->rowCount() > 0) {
                            //In case that the query returned at least one record, we can echo the records within a foreach loop:
                                foreach($results as $result)
                            {
                            ?>
                                <option value="<?php echo htmlentities($result->name);?>"><?php echo htmlentities($result->name);?></option>
                            <?php }} ?>
                        </select>
                        <label for="typeofhardwareInpEdit">Type of Hardware</label>
                        <div class="invalid-feedback">
                            Please select Type of Hardware
                        </div>
                    </div>
                    <div class="mb-3 form-floating">
                        <select class="form-select" id="brandInpEdit" name="brandInpEdit" required>
                            <option value="" selected disabled>Please select Brand</option>
                            <?php
                            $sql="SELECT * FROM `brand_tbl`";
                            $query = $conn->prepare($sql);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            
                            $count=1;
                            if($query->rowCount() > 0) {
                            //In case that the query returned at least one record, we can echo the records within a foreach loop:
                                foreach($results as $result)
                            {
                        ?>
                            <option value="<?php echo htmlentities($result->name);?>"><?php echo htmlentities($result->name);?></option>
                        <?php }} ?>
                        </select>
                        <label for="brandInpEdit">Brand</label>
                        <div class="invalid-feedback">
                            Please select Brand
                        </div>
                    </div>

                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="modelInpEdit" name="modelInpEdit" required>
                        <label for="modelInpEdit" class="form-label">Model</label>
                        <div class="invalid-feedback">
                            Please enter Model
                        </div>
                    </div>

                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="serialnumberInpEdit" name="serialnumberInpEdit" required>
                        <label for="serialnumberInpEdit" class="form-label">Serial Number</label>
                        <div class="invalid-feedback">
                            Please enter Serial Number
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="mb-3 col form-floating">
                            <input type="date" class="form-control" id="dateofpurchaseInpEdit" name="dateofpurchaseInpEdit" required>
                            <label for="dateofpurchaseInpEdit" class="form-label ps-4">Date of Purchase</label>
                            <div class="invalid-feedback">
                                Please set Date of Purchase
                            </div>
                        </div>

                        <div class="col form-floating">
                            <input type="date" class="form-control" id="warrantyInpEdit" name="warrantyInpEdit" required>
                            <label for="warrantyInpEdit" class="form-label ps-4">End of Warranty</label>
                            <div class="invalid-feedback">
                                Please enter End of Warranty
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 form-floating">
                        <select class="form-select" id="ownerInpEdit" name="ownerInpEdit" disabled>
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
                        <label for="ownerInpEdit">Owner</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <select class="form-select" id="statusInpEdit" name="statusInpEdit" required>
                            <option value="" selected disabled>Please select Status</option>
                            <option>Serviceable</option>
                            <option>Non-Serviceable</option>
                        </select>
                        <label for="statusInpEdit">Status</label>
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
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6952492a89.js" crossorigin="anonymous"></script>
    <script>
        
        const get = async (hid) => {
            location.href = "/ict_inventory_system/hardware/view.php?hid=" + hid;
        }

        function getEdit(hid) {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {hardware_id:hid}
            }).then((res) => {
                    res = JSON.parse(res);
                    $("#hidInpEdit").val(res.hardware_id);
                    $("#macInpEdit").val(res.mac_address);
                    $("#typeofhardwareInpEdit").val(res.type_of_hardware);
                    $('#brandInpEdit').val(res.brand);
                    $('#modelInpEdit').val(res.model);
                    $('#serialnumberInpEdit').val(res.serial_number);
                    $('#dateofpurchaseInpEdit').val(res.date_of_purchase);
                    $('#warrantyInpEdit').val(res.warranty);
                    $('#ownerInpEdit').val(res.employee_id);
                    $('#ownerInpNameEdit').val(res.owner_name);
                    $('#statusInpEdit').val(res.status);
                });
        }

        function getTransfer(hid) {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {hardware_id:hid},
                success: function (res) {
                    res = JSON.parse(res);
                    $("#hidInp").val(res.hardware_id);
                    // $('#ownerInp').val(res.employee_id);
                    $('#currentownerInp').val(res.owner_name);
                }
            })
        }

        function update() {
            $.ajax({
                type: "POST",
                url: "./update.php",
                data: {
                    hardware_id: $("#hidInpEdit").val(),
                    mac_address: $("#macInpEdit").val(),
                    type_of_hardware: $("#typeofhardwareInpEdit").val(),
                    brand: $('#brandInpEdit').val(),
                    model: $('#modelInpEdit').val(),
                    serial_number:$('#serialnumberInpEdit').val(),
                    date_of_purchase:$('#dateofpurchaseInpEdit').val(),
                    warranty:$('#warrantyInpEdit').val(),
                    employee_id:$('#ownerInpEdit').val(),
                    status:$('#statusInpEdit').val(),
                }
            }).then((res)=> {
                if (res == 'Updated Successfully') {
                    Swal.fire({
                        title: 'Success!',
                        text: res,
                        icon: 'success',
                        confirmButtonText: 'Okay'
                    }).then(()=>location.reload())
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: res,
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    }).then(()=>location.reload())
                }
            });
        }

        function changeServiceStatus(ictid, status) {
            $.ajax({
                type: "POST",
                url: "changeServiceStatus.php",
                data: {
                    ictid,
                    status
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
                        hardware_id: $("#hidInp").val(),
                        current_owner: $('#currentownerInp').val(),
                        new_owner: $('#newownerInp').val(),
                    }
                })
                .then((res) => {
                    if (res > 0) {
                        Swal.fire({
                            title: 'Success!',
                            text: "Transferred successfully",
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        }).then(()=>location.reload())
                    } else {
                        console.log(res);
                        // Swal.fire({
                        //     title: 'Error!',
                        //     text: "Transferred failed",
                        //     icon: 'error',
                        //     confirmButtonText: 'Okay'
                        // }).then(()=>location.reload())
                    }
                });
            }
            // if ($('#newownerInp option:selected').text() == $('#currentownerInp').val()) {
            //     Swal.fire({
            //             title: 'Error!',
            //             text: "Current Owner cannot be the New Owner",
            //             icon: 'error',
            //             confirmButtonText: 'Okay'
            //         })
            // } else {
            //     $.ajax({
            //         type: "POST",
            //         url: "./transfer.php",
            //         data: {
            //             mac_address: $("#macInp").val(),
            //             current_owner: $('#currentownerInp').val(),
            //             new_owner: $('#newownerInp option:selected').val(),
            //         }
            //     }).then((res) => {
            //         if (res > 0) {
            //             Swal.fire({
            //                 title: 'Success!',
            //                 text: "Transferred successfully",
            //                 icon: 'success',
            //                 confirmButtonText: 'Okay'
            //             }).then(()=>location.reload())
            //         } else {
            //             Swal.fire({
            //                 title: 'Error!',
            //                 text: "Transferred failed",
            //                 icon: 'error',
            //                 confirmButtonText: 'Okay'
            //             }).then(()=>location.reload())
            //         }
            //     });
            // }
        }

        function encodeService(ictid) {
            location.href = `../service/encode.php?type=Hardware&ictid=${ictid}`;
            
        }

        $(document).ready(function () {
            $('#ictnetworkhardwareTbl').DataTable();
            $('#tbl_transfer').DataTable();
        });
    </script>
</html>