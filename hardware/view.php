<?php
    require_once('../dbconfig.php');
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }

    $query=$conn->prepare("SELECT * FROM ict_network_hardware_tbl WHERE hardware_id =:hid");
    $query->execute(array(':hid' => $_GET['hid']));
    $hardware=$query->fetch(PDO::FETCH_ASSOC);

    $count=$query->rowCount();

    if($count <=0){
        //reidrect homepage/ ict inventory module
        header("Location: hardware.php");
    }

    $query=$conn->prepare("SELECT * FROM employee_tbl WHERE employee_id = :eid");
    $query->execute(array(':eid' => $hardware['employee_id']));
    $employee_list=$query->fetch(PDO::FETCH_ASSOC);

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
            <h3>Manange Inventory</h3>
        </div>
        <div class="tab-div mb-5">
            <ul class="nav d-flex gap-3">
                <li class="nav-item">
                    <button class="btn btn-primary" onclick="location.href='/ict_inventory_system/hardware/index.php'">View Inventory</button>
                </li>
                <li class="nav-item">
                    <?php if ($hardware['status'] == "Serviceable") { ?>
                    <button class="btn btn-success" onclick="encodeService('<?= $_GET['hid']; ?>')">Encode Service</button>
                    <?php 
                        } else {
                            echo '<button class="btn btn-success" disabled>Encode Service</button>';
                        } 
                    ?>
                </li>
                <li class="nav-item">
                    <button onclick="getTransfer('<?= $_GET['hid']; ?>')" type="button" data-id="<?= $_GET['hid']; ?>" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#transferModal">Transfer Ownership</button>
                </li>
            </ul>
        </div>
            <form>
                <input type="hidden" class="form-control" id="hidInp" name="hidInp">
                <div class="col">
                    <label for="macInp" class="form-label fw-bold">MAC Address</label>
                    <input type="text" class="form-control" id="macInp" name="macInp" value="<?= $hardware['mac_address'] ?>" disabled>
                </div>
                <div class="col">
                    <label for="macInp" class="form-label fw-bold">Type of Hardware</label>
                    <input type="text" class="form-control" id="typeofhardwareInp" name="typeofhardwareInp" value="<?= $hardware['type_of_hardware'] ?>" disabled>
                </div>
                <div class="col">
                    <label for="macInp" class="form-label fw-bold">Brand</label>
                    <input type="text" class="form-control" id="brandInp" name="brandInp" value="<?= $hardware['brand'] ?>" disabled>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="modelInp" class="form-label fw-bold">Model</label>
                        <input type="text" class="form-control" id="modelInp" name="modelInp" value="<?= $hardware['model'] ?>" disabled>
                    </div>

                    <div class="col">
                        <label for="serialnumberInp" class="form-label fw-bold">Serial Number</label>
                        <input type="text" class="form-control" id="serialnumberInp" name="serialnumberInp" value="<?= $hardware['serial_number'] ?>" disabled>
                    </div>
                </div>

                <div class="mb-3 col">
                    <label for="specificationsInp" class="form-label fw-bold" id="specificationsInpLbl">Specifications</label>
                    <textarea class="form-control" id="specificationsInp" name="specificationsInp" rows="4" cols="50" disabled><?= $hardware['specifications'] ?></textarea>
                </div>

                <div class="mb-3 col">
                    <label for="costInp" class="form-label fw-bold" id="costInpsLbl">Cost (PHP)</label>
                    <input type="number" class="form-control" id="costInp" name="costInp" value="<?= $hardware['cost'] ?>" disabled>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="dateofpurchaseInp" class="form-label fw-bold">Date of Purchase</label>
                        <input type="date" class="form-control" id="dateofpurchaseInp" name="dateofpurchaseInp" value="<?= $hardware['date_of_purchase'] ?>" disabled>
                    </div>

                    <div class="col">
                        <label for="warrantyInp" class="form-label fw-bold">End of Warranty</label>
                        <input type="date" class="form-control" id="warrantyInp" name="warrantyInp" value="<?= $hardware['warranty'] ?>" disabled>
                    </div>
                </div>
                <div class="col">
                    <label for="ownerInpName" class="form-label fw-bold">Owner</label>
                    <input type="text" class="form-control" id="ownerInpName" name="ownerInpName" value="<?= $employee_list['lname'].', '.$employee_list['fname'] ?>" disabled>
                </div>
                <div class="col">
                    <label for="macInp" class="form-label fw-bold">Status</label>
                    <input type="text" class="form-control" id="statusInp" name="statusInp" value="<?= $hardware['status'] ?>" disabled>
                </div>

                <div class="my-3">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ownershipHistoryDiv" aria-expanded="true" aria-controls="ownershipHistoryDiv">
                                Ownership History
                            </button>
                            </h2>
                            <div id="ownershipHistoryDiv" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th>Date Transferred</th>
                                        <th>Old Owner</th>
                                        <th>New Owner</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $hardware_id =  $_GET['hid'];
                                            $sql="SELECT * FROM ict_transfer_tbl WHERE ict_id = :hid";
                                            $query = $conn->prepare($sql);
                                            $query->bindParam(':hid',$hardware_id,PDO::PARAM_STR);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $count=1;
                                            $rowCount = $query->rowCount();

                                            if ($rowCount > 0) {
                                            //In case that the query returned at least one record, we can echo the records within a foreach loop:
                                                foreach($results as $result)
                                            {
                                                $get_old_owner = $conn->prepare("SELECT * FROM `employee_tbl` WHERE employee_id = :id");
                                                $get_old_owner->execute(array(':id' => $result->employee_id_old));
                                                $old_owner=$get_old_owner->fetch(PDO::FETCH_ASSOC);

                                                $get_new_owner = $conn->prepare("SELECT * FROM `employee_tbl` WHERE employee_id = :id");
                                                $get_new_owner->execute(array(':id' => $result->employee_id_new));
                                                $new_owner=$get_new_owner->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <tr>
                                            <td><?= $result->date_transferred?></td>
                                            <td><?= $old_owner['lname'] .', '. $old_owner['fname']?></td>
                                            <td><?= $new_owner['lname'] .', '. $new_owner['fname']?></td>
                                            <?php 
                                                if ($count == $rowCount) {
                                            ?>
                                            <td><button onclick="getTransferEdit(<?= $result->ict_id ?>)" type="button" data-id="<?= $result->ict_id ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editTransferHistoryModal">Edit</button></td>
                                            <?php 
                                                } 
                                                else {
                                                    echo "<td></td>";
                                                }
                                            ?>
                                        </tr>
                                    </tbody>
                                    <?php $count++; }} ?>
                                </table>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#repairHistoryDiv" aria-expanded="true" aria-controls="repairHistoryDiv">
                                Service History
                            </button>
                            </h2>
                            <div id="repairHistoryDiv" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                            <table class="table table-striped table-hover">
                                    <thead>
                                        <th>Date Received</th>
                                        <th>Date Returned</th>
                                        <th>Type of Service</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $hardware_id =  $_GET['hid'];
                                            $type = "Hardware";
                                            $sql="SELECT * FROM services_tbl WHERE ICT_ID = :hid AND type_of_ict = :icttype";
                                            $query = $conn->prepare($sql);
                                            $query->execute(array(
                                                ':hid'	=>$hardware_id,
                                                ':icttype' => $type
                                            ));
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $count=1;
                                            if($query->rowCount() > 0) {
                                            //In case that the query returned at least one record, we can echo the records within a foreach loop:
                                                foreach($results as $result)
                                            {
                                        ?>
                                        <tr>
                                            <input type="hidden" name="serviceIdInp" id="serviceIdInp" value="<?= $result->services_id ?>">
                                            <td><?= $result->date_received?></td>
                                            <td><?= $result->date_returned?></td>
                                            <td><?= $result->type_of_services?></td>
                                            <td><?= $result->remarks?></td>
                                            <td>
                                                <div class="mb-3">
                                                    <select onchange="changeServiceStatus('<?= $result->ICT_ID ?>',<?= $result->services_id ?>,this.options[this.selectedIndex].text)" class="form-select" id="statusViewInp<?= $result->services_id ?>" name="statusViewInp">
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
                                            <td>
                                                <button onclick="getServiceView('<?= $result->services_id ?>')" type="button" data-id="<?= $result->services_id ?>" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal">View</button>
                                                <button onclick="getService(<?= $result->services_id ?>)" type="button" data-id="<?= $result->services_id ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                                                <button onclick="" type="button" class="btn btn-warning">Generate Report</button>
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
                    <h1 class="modal-title fs-5" id="transferModalLabel">Transfer ICT Hardware</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="needs-validation" novalidate id="updateForm" name="updateForm" method="post">
                    <!-- <div class="mb-3">
                        <label class="form-label" for="currentownerInp">Current Owner</label>
                        <input class="form-control" type="text" name="currentownerInp" id="currentownerInp" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="newownerInp">New Owner</label>
                        <input class="form-control" type="text" name="newownerInp" id="newownerInp">
                    </div> -->
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
                        <label for="newownerInp">New Owner</label>
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
        <!-- View Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewModalLabel">View Service Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="update_service.php" class="needs-validation" novalidate id="viewServiceForm" name="viewServiceForm" method="post">
                    <input type="hidden" name="servicesIdInp" id="servicesIdInp">
                    <div class="mb-3 form-floating">
                        <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="typeofictViewInp" name="typeofictViewInp" readonly>
                        <label for="typeofictViewInp" class="form-label" id="typeofictViewInpLbl">Type of ICT</label>
                    </div>
                    </div>
                    
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="ictidViewInp" name="ictidViewInp" readonly>
                        <label for="ictidViewInp" class="form-label" id="ictidViewInpLbl">ICT ID</label>
                        <div class="invalid-feedback">
                            Please enter ICT ID
                        </div>
                    </div>

                    <div class="mb-3 form-floating">
                        <select class="form-select" id="typeofserviceViewInp" name="typeofserviceViewInp" readonly>
                            <option value="" selected disabled>Select Type of Service</option>
                            <option disabled>Repair</option>
                            <option disabled>Maintenance</option>
                            <option disabled>Installation</option>
                        </select>
                        <label for="typeofserviceViewInp" id="typeofserviceViewInpLbl">Type of Service</label>
                        <div class="invalid-feedback">
                            Please select Type of Service
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="mb-3 col form-floating">
                            <input type="date" class="form-control" id="datereceivedViewInp" name="datereceivedViewInp" readonly>
                            <label for="datereceivedViewInp" class="form-label ps-4" id="datereceivedViewInpLbl">Date Received</label>
                            <div class="invalid-feedback">
                                Please set Date Received
                            </div>
                        </div>

                        <div class="col form-floating">
                            <input type="date" class="form-control" id="datereturnedViewInp" name="datereturnedViewInp" readonly>
                            <label for="datereturnedViewInp" class="form-label ps-4" id="ddatereturnedViewInpLbl">Date Returned</label>
                            <div class="invalid-feedback">
                                Please set Date Returned
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <textarea class="form-control" id="descriptionViewInp" name="descriptionViewInp" rows="3" readonly></textarea>
                        <label for="descriptionViewInp" class="form-label" id="descriptionViewInpLbl">Description of service</label>
                        <div class="invalid-feedback">
                            Please enter Description of service
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <textarea class="form-control" id="actionDoneViewInp" name="actionDoneViewInp" rows="3" readonly></textarea>
                        <label for="actionDoneViewInp" class="form-label" id="actionDoneViewInpLbl">Action Done</label>
                        <div class="invalid-feedback">
                            Please enter Action Done
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <textarea class="form-control" id="remarksViewInp" name="remarksViewInp" rows="3" readonly></textarea>
                        <label for="remarksViewInp" class="form-label" id="remarksViewInpLbl">Remarks</label>
                        <div class="invalid-feedback">
                            Please enter Remarks
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <textarea class="form-control" id="recommendationViewInp" name="recommendationViewInp" rows="3" readonly></textarea>
                        <label for="recommendationViewInp" class="form-label" id="recommendationViewInpLbl">Recommendation</label>
                        <div class="invalid-feedback">
                            Please enter Recommendation
                        </div>
                    </div>
                    <div class="mb-3 form-floating">
                        <select class="form-select" id="statusViewInp" name="statusViewInp" readonly>
                            <option value="" selected disabled>Select a Status</option>
                            <option disabled>Pending</option>
                            <option disabled>On Going</option>
                            <option disabled>Finished</option>
                        </select>
                        <label for="statusViewInp" class="form-label" id="statusViewInpLbl">Status</label>
                        <div class="invalid-feedback">
                            Please enter status
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="processedbyViewInp" name="processedbyViewInp" readonly>
                        <label for="processedbyViewInp" class="form-label" id="processedbyViewInpLbl">Processed by</label>
                        <div class="invalid-feedback">
                            Please enter a name
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
                </div>
                </div>
            </div>
        </div>
        <!-- Edit Transfer History Modal -->
        <div class="modal fade" id="editTransferHistoryModal" tabindex="-1" aria-labelledby="editTransferHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTransferHistoryModalLabel">Edit Ownership History</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="update_transfer.php" class="needs-validation" novalidate id="updateTransferForm" name="updateTransferForm" method="post">
                    <input type="hidden" name="transferIdInp" id="transferIdInp">
                    <input type="hidden" name="hardwareIdInp" id="hardwareIdInp">
                    <div class="mb-3 col form-floating">
                        <input type="date" class="form-control" id="dateTransferredEditInp" name="dateTransferredEditInp" required>
                        <label for="dateTransferredEditInp" class="form-label" id="dateTransferredEditInpLbl">Date Transferred</label>
                        <div class="invalid-feedback">
                            Please set Date Transferred
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <select class="form-select" id="oldownerEditInp" name="oldownerEditInp" readonly>
                                <option value="" selected disabled>Select Owner</option>
                            <?php
                                $sql="SELECT employee_id, username, lname, fname FROM `employee_tbl`";
                                $query = $conn->prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                
                                $count=1;
                                if($query->rowCount() > 0) {
                                    foreach($results as $result)
                                {
                            ?>
                                <option value="<?php echo htmlentities($result->employee_id);?>"><?php echo htmlentities($result->lname).', '.htmlentities($result->fname);?></option>
                            <?php }} ?>
                        </select>
                        <label for="oldownerEditInp" class="form-label fw-bold" id="oldownerEditInpLbl">Old Owner</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <select class="form-select" id="newownerEditInp" name="newownerEditInp" required>
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
                        <label for="newownerEditInp" class="form-label fw-bold">New Owner</label>
                        <div class="invalid-feedback">
                            Please select New Owner
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
                </div>
                </div>
            </div>
        </div>
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Service Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="update_service.php" class="needs-validation" novalidate id="updateServiceForm" name="updateServiceForm" method="post">
                    <input type="hidden" name="editServicesIdInp" id="editServicesIdInp">
                    <div class="mb-3 form-floating">
                        <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="typeofictEditInp" name="typeofictEditInp" readonly>
                        <label for="typeofictEditInp" class="form-label" id="typeofictEditInpLbl">Type of ICT</label>
                    </div>
                    </div>
                    
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="ictidEditInp" name="ictidEditInp" readonly>
                        <label for="ictidEditInp" class="form-label" id="ictidEditInpLbl">ICT ID</label>
                        <div class="invalid-feedback">
                            Please enter ICT ID
                        </div>
                    </div>

                    <div class="mb-3 form-floating">
                        <select class="form-select" id="typeofserviceEditInp" name="typeofserviceEditInp" required>
                            <option value="" selected disabled>Select Type of Service</option>
                            <option>Repair</option>
                            <option>Maintenance</option>
                            <option>Installation</option>
                        </select>
                        <label for="typeofserviceEditInp" id="typeofserviceEditInpLbl">Type of Service</label>
                        <div class="invalid-feedback">
                            Please select Type of Service
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="mb-3 col form-floating">
                            <input type="date" class="form-control" id="datereceivedEditInp" name="datereceivedEditInp" required>
                            <label for="datereceivedEditInp" class="form-label ps-4" id="datereceivedEditInpLbl">Date Received</label>
                            <div class="invalid-feedback">
                                Please set Date Received
                            </div>
                        </div>

                        <div class="col form-floating">
                            <input type="date" class="form-control" id="datereturnedEditInp" name="datereturnedEditInp">
                            <label for="datereturnedEditInp" class="form-label ps-4" id="ddatereturnedEditInpLbl">Date Returned</label>
                            <div class="invalid-feedback">
                                Please set Date Returned
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <textarea class="form-control" id="descriptionEditInp" name="descriptionEditInp" rows="3" required></textarea>
                        <label for="descriptionEditInp" class="form-label" id="descriptionEditInpLbl">Description of service</label>
                        <div class="invalid-feedback">
                            Please enter Description of service
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <textarea class="form-control" id="actionDoneEditInp" name="actionDoneEditInp" rows="3" required></textarea>
                        <label for="actionDoneEditInp" class="form-label" id="actionDoneEditInpLbl">Action Done</label>
                        <div class="invalid-feedback">
                            Please enter Action Done
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <textarea class="form-control" id="remarksEditInp" name="remarksEditInp" rows="3" ></textarea>
                        <label for="remarksEditInp" class="form-label" id="remarksEditInpLbl">Remarks</label>
                        <div class="invalid-feedback">
                            Please enter Remarks
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <textarea class="form-control" id="recommendationEditInp" name="recommendationEditInp" rows="3" ></textarea>
                        <label for="recommendationEditInp" class="form-label" id="recommendationEditInpLbl">Recommendation</label>
                        <div class="invalid-feedback">
                            Please enter Recommendation
                        </div>
                    </div>
                    <div class="mb-3 form-floating">
                        <select class="form-select" id="statusEditInp" name="statusEditInp" required>
                            <option value="" selected disabled>Select a Status</option>
                            <option>Pending</option>
                            <option>On Going</option>
                            <option>Finished</option>
                        </select>
                        <label for="statusEditInp" class="form-label" id="statusEditInpLbl">Status</label>
                        <div class="invalid-feedback">
                            Please enter status
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="processedbyEditInp" name="processedbyEditInp" required>
                        <label for="processedbyEditInp" class="form-label" id="processedbyEditInpLbl">Processed by</label>
                        <div class="invalid-feedback">
                            Please enter a name
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
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
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
            }, false)
        })
        })();

        const get = async (hid) => {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {hardware_id:hid}
            }).then((res) => {
                res = JSON.parse(res);
                $("#hidInp").val(res.hardware_id);
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

        const getServiceView = async (sid) => {
            $.ajax({
                type: "GET",
                url: "./get_service.php",
                data: {services_id:sid}
            }).then((res) => {
                res = JSON.parse(res);
                $("#servicesIdInp").val(res.services_id);
                $("#typeofictViewInp").val(res.type_of_ict);
                $("#ictidViewInp").val(res.ICT_ID);
                $("#typeofserviceViewInp").val(res.type_of_services);
                $("#datereceivedViewInp").val(res.date_received);
                $("#datereturnedViewInp").val(res.date_returned);
                $("#descriptionViewInp").val(res.description_of_service);
                $("#actionDoneViewInp").val(res.action_done);
                $("#remarksViewInp").val(res.remarks);
                $("#recommendationViewInp").val(res.recommendation);
                $("#statusViewInp").val(res.service_status);
                $("#processedbyViewInp").val(res.processed_by);
            });
        }

        const getService = async (sid) => {
            $.ajax({
                type: "GET",
                url: "./get_service.php",
                data: {services_id:sid}
            }).then((res) => {
                res = JSON.parse(res);
                $("#editServicesIdInp").val(res.services_id);
                $("#typeofictEditInp").val(res.type_of_ict);
                $("#ictidEditInp").val(res.ICT_ID);
                $("#typeofserviceEditInp").val(res.type_of_services);
                $("#datereceivedEditInp").val(res.date_received);
                $("#datereturnedEditInp").val(res.date_returned);
                $("#descriptionEditInp").val(res.description_of_service);
                $("#actionDoneEditInp").val(res.action_done);
                $("#remarksEditInp").val(res.remarks);
                $("#recommendationEditInp").val(res.recommendation);
                $("#statusEditInp").val(res.service_status);
                $("#processedbyEditInp").val(res.processed_by);
            });
        }


        function getTransferEdit(ictid) {
            $.ajax({
                type: "GET",
                url: "./get_transfer_edit.php",
                data: {ict_id:ictid},
                success: function (res) {
                    res = JSON.parse(res);
                    $("#transferIdInp").val(res.transfer_id);
                    $("#hardwareIdInp").val(ictid);
                    $("#dateTransferredEditInp").val(res.date_transferred);
                    $('#newownerEditInp').val(res.new_owner);
                    $('#oldownerEditInp').val(res.old_owner);
                }
            })
        }


        function getTransfer(hid) {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {ict_id:hid},
                success: function (res) {
                    res = JSON.parse(res);
                    $("#hidInp").val(res.ict_id);
                    $("#macInp").val(res.mac_address);
                    $('#ownerInp').val(res.employee_id);
                    $('#currentownerInp').val(res.employee_id);
                }
            })
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
                        ict_id: $("#hidInp").val(),
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

        function updateService() {
            document.getElementById("updateServiceForm").submit();
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