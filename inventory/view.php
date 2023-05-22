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
        <div class="tab-div mb-5">
            <ul class="nav d-flex gap-3">
                <li class="nav-item">
                    <button class="btn btn-primary" onclick="location.href='/ict_inventory_system/inventory/manageInventory.php'">View Inventory</button>
                </li>
                <li class="nav-item">
                    <button class="btn btn-success" onclick="encodeService('<?= $_SESSION['selected_mac']; ?>')">Encode Service</button>
                </li>
                <li class="nav-item">
                    <button onclick="getTransfer('<?= $_SESSION['selected_mac']; ?>')" type="button" data-id="<?= $_SESSION['selected_mac']; ?>" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#transferModal">Transfer Ownership</button>
                </li>
            </ul>
        </div>
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
                                        <th>Remarks</th>
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
                                            <td><?= $result->remarks?></td>
                                            <td>
                                                <div class="mb-3">
                                                    <select onchange="changeServiceStatus('<?= $result->ICT_ID ?>',<?= $result->services_id ?>,this.options[this.selectedIndex].text)" class="form-select" id="statusViewInp" name="statusViewInp">
                                                        <?php
                                                            $selected = $result->service_status;
                                                            switch ($selected) {
                                                                case "Finished": {
                                                                    ?>
                                                                    <option selected>Finished</option>
                                                                    <option>On Going</option>
                                                                    <option>Pending</option>
                                                                    <?php
                                                                    break;
                                                                }
                                                                case "On Going": {
                                                                    ?>
                                                                    <option>Finished</option>
                                                                    <option selected>On Going</option>
                                                                    <option>Pending</option>
                                                                    <?php
                                                                    break;
                                                                }
                                                                case "Pending": {
                                                                    ?>
                                                                    <option>Finished</option>
                                                                    <option>On Going</option>
                                                                    <option selected>Pending</option>
                                                                    <?php
                                                                    break;
                                                                }
                                                                default: {
                                                                    ?>
                                                                    <option>Finished</option>
                                                                    <option>On Going</option>
                                                                    <option>Pending</option>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </td>
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
                    mac_address: $("#macInpEdit").val(),
                    type_of_hardware: $("#typeofhardwareInpEdit").val(),
                    brand: $('#brandInpEdit').val(),
                    model: $('#modelInpEdit').val(),
                    serial_number:$('#serialnumberInpEdit').val(),
                    date_of_purchase:$('#dateofpurchaseInpEdit').val(),
                    warranty:$('#warrantyInpEdit').val(),
                    employee_id:$('#ownerInpEdit').val(),
                    status:$('#statusInpEdit').val(),
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

        function changeServiceStatus(ictid, services_id, status) {
            $.ajax({
                type: "POST",
                url: "changeServiceStatus.php",
                data: {
                    ictid,
                    services_id,
                    status,
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
        }

        function encodeService(ictid) {
            location.href = `../service/encode.php?type=Hardware&ictid=${ictid}`;
            
        }

        $(document).ready(function () {
            $('#ictnetworkhardwareTbl').DataTable();
            $('#tbl_transfer').DataTable();

            var mac = window.location.search.substring(1).split("&")[0].split("=")[1];
            console.log(mac);
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {mac_address: mac}
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
        });
    </script>
</html>