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
    <title>Inventory</title>
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
            <h3>Manange Inventory</h3>
        </div>
            <table id="ictnetworkhardwareTbl" class="display table table-light" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>MAC Address</th>
                        <th>Type of Hardware</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Serial Number</th>
                        <th>Date of Purchase</th>
                        <th>Warranty</th>
                        <th>Owner</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql="
                        SELECT mac_address, type_of_hardware, brand, model, serial_number, date_of_purchase, warranty, employee_tbl.lname, employee_tbl.fname, ict_network_hardware_tbl.status, owner_name
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
                        <td><?= $row['mac_address'] ?></td>
                        <td><?= $row['type_of_hardware'] ?></td>
                        <td><?= $row['brand'] ?></td>
                        <td><?= $row['model'] ?></td>
                        <td><?= $row['serial_number'] ?></td>
                        <td><?= $row['date_of_purchase'] ?></td>
                        <td><?= $row['warranty'] ?></td>
                        <td><?= $row['owner_name'] //$row['lname'].', '.$row['fname'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td>
                            <button id="viewBtn" onclick="get('<?= $row['mac_address'] ?>')" type="button" data-id="<?= $row['mac_address'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#viewModal">View</button>
                            <button id="editBtn" onclick="getEdit('<?= $row['mac_address'] ?>')" type="button" data-id="<?= $row['mac_address'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            <button id="editBtn" onclick="getTransfer('<?= $row['mac_address'] ?>')" type="button" data-id="<?= $row['mac_address'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#transferModal">Transfer</button>
                        </td>
                        
                    </tr>
                    <?php $count++; } ?>
            </table>
        </div>
    </div>
    
    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewModalLabel">View Hardware</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form>
                    <div class="col">
                        <label for="macInp" class="form-label">MAC Address</label>
                        <input type="text" class="form-control" id="macInp" name="macInp" disabled>
                    </div>
                    <div class="mb-3 col">
                        <label for="typeofhardwareInp">Type of Hardware</label>
                        <select class="form-select" id="typeofhardwareInp" name="typeofhardwareInp" disabled>
                            <option value="" selected disabled>Select Type of Hardware</option>
                            <option>Equipment</option>
                            <option>Tools</option>
                        </select>
                    </div>
                    <div class="mb-3 col">
                        <label for="brandInp">Brand</label>
                        <select class="form-select" id="brandInp" name="brandInp" disabled>
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
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="modelInp" class="form-label">Model</label>
                            <input type="text" class="form-control" id="modelInp" name="modelInp" disabled>
                        </div>

                        <div class="col">
                            <label for="serialnumberInp" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serialnumberInp" name="serialnumberInp" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="dateofpurchaseInp" class="form-label ps-4">Date of Purchase</label>
                            <input type="date" class="form-control" id="dateofpurchaseInp" name="dateofpurchaseInp" disabled>
                        </div>

                        <div class="col">
                            <label for="warrantyInp" class="form-label ps-4">End of Warranty</label>
                            <input type="date" class="form-control" id="warrantyInp" name="warrantyInp" disabled>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="ownerInpName">Owner</label>
                        <input type="text" class="form-control" id="ownerInpName" name="ownerInpName" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="statusInp">Status</label>
                        <select class="form-select" id="statusInp" name="statusInp" disabled>
                            <option value="" selected disabled>Please select Status</option>
                            <option>Serviceable</option>
                            <option>Non-Serviceable</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ownershipHistoryDiv" aria-expanded="false" aria-controls="ownershipHistoryDiv">
                                    Ownership History
                                </button>
                                </h2>
                                <div id="ownershipHistoryDiv" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <th>Date Transferred</th>
                                            <th>Old Owner</th>
                                            <th>New Owner</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $mac_address =  $_SESSION['selected_mac'];
                                                $sql="SELECT * FROM ict_transfer_tbl WHERE mac_address = :mac";
                                                $query = $conn->prepare($sql);
                                                $query->bindParam(':mac',$mac_address,PDO::PARAM_STR);
                                                $query->execute();
                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                $count=1;
                                                if($query->rowCount() > 0) {
                                                //In case that the query returned at least one record, we can echo the records within a foreach loop:
                                                    foreach($results as $result)
                                                {
                                            ?>
                                            <tr>
                                                <td><?= $result->date_transferred?></td>
                                                <td><?= $result->old_owner?></td>
                                                <td><?= $result->new_owner?></td>
                                            </tr>
                                        </tbody>
                                        <?php }} ?>
                                    </table>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#repairHistoryDiv" aria-expanded="false" aria-controls="repairHistoryDiv">
                                    Repair History
                                </button>
                                </h2>
                                <div id="repairHistoryDiv" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                <table class="table table-striped table-hover">
                                        <thead>
                                            <th>Date Received</th>
                                            <th>Date Returned</th>
                                            <th>Type of Service</th>
                                            <th>Status</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $mac_address =  $_SESSION['selected_mac'];
                                                $type = "Repair";
                                                $sql="SELECT * FROM services_tbl WHERE ICT_ID = :mac AND type_of_services=:type";
                                                $query = $conn->prepare($sql);
                                                $query->execute(array(
                                                    ':mac'	=>$mac_address,
                                                    ':type'	=>$type
                                                ));
                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                $count=1;
                                                if($query->rowCount() > 0) {
                                                //In case that the query returned at least one record, we can echo the records within a foreach loop:
                                                    foreach($results as $result)
                                                {
                                            ?>
                                            <tr>
                                                <td><?= $result->date_received?></td>
                                                <td><?= $result->date_returned?></td>
                                                <td><?= $result->type_of_services?></td>
                                                <td><?= $result->service_status?></td>
                                            </tr>
                                        </tbody>
                                        <?php }} ?>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button onclick="encodeService('<?= $_SESSION['selected_mac']; ?>')" type="button" class="btn btn-primary">Encode Service</button>
                    <button id="editBtn" onclick="getTransfer('<?= $_SESSION['selected_mac']; ?>')" type="button" data-id="<?= $_SESSION['selected_mac']; ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#transferModal">Transfer Ownership</button>
                </div>
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
                            <option>Equipment</option>
                            <option>Tools</option>
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
                    <div class="mb-3">
                        <label class="form-label" for="currentownerInp">Current Owner</label>
                        <input class="form-control" type="text" name="currentownerInp" id="currentownerInp" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="newownerInp">New Owner</label>
                        <input class="form-control" type="text" name="newownerInp" id="newownerInp">
                    </div>
                    <!-- <div class="mb-3 col form-floating">
                        <select class="form-select" id="currentownerInp" name="currentownerInp" disabled>
                                <option value="" selected disabled>Select Owner</option>
                            <?php
                                // $sql="SELECT employee_id, username, lname, fname FROM `employee_tbl`";
                                // $query = $conn->prepare($sql);
                                // $query->execute();
                                // $results=$query->fetchAll(PDO::FETCH_OBJ);
                                
                                // $count=1;
                                // if($query->rowCount() > 0) {
                                //     foreach($results as $result)
                                // {
                            ?>
                                <option value="<?php //echo htmlentities($result->employee_id);?>"><?php //echo htmlentities($result->lname).', '.htmlentities($result->fname);?></option>
                            <?php //}} ?>
                        </select>
                        <label for="currentownerInp" class="form-label" id="currentownerLbl">Current Owner</label>
                    </div> -->
                    <!-- <div class="mb-3 form-floating">
                        <select class="form-select" id="newownerInp" name="newownerInp" required>
                            <option value="" selected disabled>Select New Owner</option>
                        <?php
                            // $sql="SELECT employee_id, username, lname, fname FROM `employee_tbl`";
                            // $query = $conn->prepare($sql);
                            // $query->execute();
                            // $results=$query->fetchAll(PDO::FETCH_OBJ);
                            
                            // $count=1;
                            // if($query->rowCount() > 0) {
                            // //In case that the query returned at least one record, we can echo the records within a foreach loop:
                            //     foreach($results as $result)
                            // {
                        ?>
                            <option value="<?php //echo htmlentities($result->employee_id);?>"><?php //echo htmlentities($result->lname).', '.htmlentities($result->fname);?></option>
                        <?php //}} ?>
                        </select>
                        <label for="newownerInp">New Owner</label>
                        <div class="invalid-feedback">
                            Please select New Owner
                        </div>
                    </div> -->
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
        // $('#viewModal').on('hidden.bs.modal', function () {
        // // refresh current page
        //     location.reload();-                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
        // })
        const get = async (mac) => {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {mac_address:mac}
            }).then((res) => {
                res = JSON.parse(res);
                $("#macInp").val(res.mac_address);
                $("#typeofhardwareInp").val(res.type_of_hardware);
                $('#brandInp').val(res.brand);
                $('#modelInp').val(res.model);
                $('#serialnumberInp').val(res.serial_number);
                $('#dateofpurchaseInp').val(res.date_of_purchase);
                $('#warrantyInp').val(res.warranty);
                $('#ownerInp').val(res.employee_id);
                $('#ownerInpName').val(res.owner_name);
                $('#statusInp').val(res.status);
            });
        }

        function getEdit(mac) {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {mac_address:mac}
            }).then((res) => {
                    res = JSON.parse(res);
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

        function getTransfer(mac) {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {mac_address:mac},
                success: function (res) {
                    res = JSON.parse(res);
                    $("#macInp").val(res.mac_address);
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
                        Swal.fire({
                            title: 'Error!',
                            text: "Transferred failed",
                            icon: 'error',
                            confirmButtonText: 'Okay'
                        }).then(()=>location.reload())
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