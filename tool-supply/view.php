<?php
    require_once('../dbconfig.php');
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }

    $query=$conn->prepare("SELECT * FROM supplies_tools_tbl WHERE supply_tools_id =:stid");
    $query->execute(array(':stid' => $_GET['stid']));
    $supplies_tools=$query->fetch(PDO::FETCH_ASSOC);

    $get_office = $conn->prepare("SELECT * FROM office_tbl WHERE office_id = :id");
    $get_office->execute(array(':id' => $supplies_tools['unit']));
    $office=$get_office->fetch(PDO::FETCH_ASSOC);

    $count=$query->rowCount();

    if($count <=0){
        //reidrect homepage/ ict inventory module
        header("Location: index.php");
    }

    $query=$conn->prepare("SELECT * FROM employee_tbl WHERE employee_id = :eid");
    $query->execute(array(':eid' => $supplies_tools['employee_id']));
    $employee_list=$query->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory | Tools and Supplies</title>
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css" />
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../styles/inventory.css">
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
                    <button class="btn btn-primary" onclick="location.href='/ict_inventory_system/tool-supply/index.php'">View Tools/Supplies Inventory</button>
                </li>
            </ul>
        </div>
            <form>
                <input type="hidden" class="form-control" id="stidInp" name="stidInp">
                <div class="col">
                    <label for="typeoftoolsuppInp" class="form-label fw-bold">Type of Supplies/Tools</label>
                    <input type="text" class="form-control" id="typeoftoolsuppInp" name="typeoftoolsuppInp" value="<?= $supplies_tools['type_of_supply_tools'] ?>" disabled>
                </div>
                <div class="col">
                    <label for="quantityInp" class="form-label fw-bold">Quantity</label>
                    <input type="text" class="form-control" id="quantityInp" name="quantityInp" value="<?= $supplies_tools['quantity'] ?>" disabled>
                </div>
                <div class="col">
                    <label for="specificationsInp" class="form-label fw-bold">Specifications</label>
                    <input type="text" class="form-control" id="specificationsInp" name="specificationsInp" value="<?= $supplies_tools['specifications_remarks'] ?>" disabled>
                </div>
                
                <div class="col">
                    <label for="unitInp" class="form-label fw-bold">Unit</label>
                    <input type="text" class="form-control" id="unitInp" name="unitInp" value="<?= $office['name'] ?>" disabled>
                </div>
                <div class="col">
                    <label for="ownerInpName" class="form-label fw-bold">Owner</label>
                    <input type="text" class="form-control" id="ownerInpName" name="ownerInpName" value="<?= $employee_list['lname'].', '.$employee_list['fname'] ?>" disabled>
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
                    <h1 class="modal-title fs-5" id="transferModalLabel">Transfer ICT Tools/Supplies</h1>
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
                    <input type="hidden" name="supplies_toolsIdInp" id="supplies_toolsIdInp">
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
                    <input type="text" name="servicesIdEditInp" id="servicesIdEditInp">
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

        const get = async (stid) => {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {supplies_tools_id:stid}
            }).then((res) => {
                res = JSON.parse(res);
                $("#stidInp").val(res.supplies_tools_id);
                $("#macInp").val(res.mac_address);
                $("#typeofsoftwareInp").val(res.type_of_software);
                $('#softwarenameInp').val(res.softwarename);
                $('#manufacturerInp').val(res.manufacturer);
                $('#typeofsubscriptionInp').val(res.serial_number);
                $('#datedevelopedpurchasedInp').val(res.date_developed_purchased);
                $('#warrantyInp').val(res.warranty);
                $('#ownerInp').val(res.employee_id);
                $('#ownerInpName').val(res.owner_name);
                $('#statusInp').val(res.status);
            });
        }

        const getServiceView = async (stid) => {
            $.ajax({
                type: "GET",
                url: "./get_service.php",
                data: {services_id:stid}
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

        const getService = async (stid) => {
            $.ajax({
                type: "GET",
                url: "./get_service.php",
                data: {services_id:stid}
            }).then((res) => {
                res = JSON.parse(res);
                console.log(res);

                $("#servicesIdEditInp").val(res.services_id);
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


        function getTransferEdit(stid) {
            $.ajax({
                type: "GET",
                url: "./get_transfer_edit.php",
                data: {ict_id:stid},
                success: function (res) {
                    res = JSON.parse(res);
                    $("#transferIdInp").val(res.transfer_id);
                    $("#supplies_toolsIdInp").val(stid);
                    $("#dateTransferredEditInp").val(res.date_transferred);
                    $('#newownerEditInp').val(res.new_owner);
                    $('#oldownerEditInp').val(res.old_owner);
                }
            })
        }


        function getTransfer(stid) {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {supplies_tools_id:stid},
                success: function (res) {
                    res = JSON.parse(res);
                    $("#stidInp").val(res.supplies_tools_id);
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
                        ict_id: $("#stidInp").val(),
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
                            // text: "Transferred failed",
                            text: res,
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
            location.href = `../service/encode.php?type=Tool-Supply&ictid=${ictid}`;
        }

        $(document).ready(function () {
            $('#ictnetworksupplies_toolsTbl').DataTable();
            $('#tbl_transfer').DataTable();
        });
    </script>
</html>