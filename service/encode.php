<?php
    require_once('../dbconfig.php');
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        $_SESSION['accType'] == "Super Admin" ? $showType = "Admin" : $showType = "Ordinary User" ;
    } else {
        header("Location: ../admin/signin.php");
    }

    function getEmployee($ictid, $type) {
        require('../dbConfig.php');

        if ($type == 'Hardware') {
            $sql = "SELECT * FROM ict_network_hardware_tbl WHERE mac_address = :ictid";
            $query = $conn->prepare($sql);
            $query->execute(array(
                'ictid' => $ictid
            ));
    
            $res = $query->fetch(PDO::FETCH_ASSOC);
    
            return $res['owner_name'];
        } 
        else if ($type == 'Software') {
            $sql = "SELECT * FROM software_tbl WHERE software_id = :ictid";
            $query = $conn->prepare($sql);
            $query->execute(array(
                'ictid' => $ictid
            ));
    
            $res = $query->fetch(PDO::FETCH_ASSOC);
    
            return $res['owner_name'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management of Accounts</title>
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css" />
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="service.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="service">
        <div id="sidebar-placeholder"><?php include("../sidebar.php") ?></div>
        <div class="service-container">
            <div class="dashboard-header" style="margin: 2rem 0">
                <h3>Encode Service</h3>
            </div>
            <form onsubmit="e.preventDefault(); handleSubmit()" class="needs-validation" novalidate id="encodeForm" name="encodeForm" method="post">
                <div class="mb-3 form-floating">
                    <select class="form-select" id="typeofictInp" name="typeofictInp" disabled>
                        <option value="" selected disabled>Select Type of ICT</option>
                        <option>Hardware</option>
                        <option>Software</option>
                        <option>Accessories</option>
                    </select>
                    <label for="typeofictInp" id="typeofictInpLbl">Type of ICT</label>
                    <div class="invalid-feedback">
                        Please select Type of Service
                    </div>
                </div>
                <div class="mb-3 col form-floating">
                    <input type="text" class="form-control" id="ictidInp" name="ictidInp" disabled>
                    <label for="ictidInp" class="form-label" id="ictidInpLbl">ICT ID</label>
                    <div class="invalid-feedback">
                        Please enter ICT ID
                    </div>
                </div>
                <div class="mb-3 form-floating">
                    <select class="form-select" id="typeofserviceInp" name="typeofserviceInp" required>
                        <option value="" selected disabled>Select Type of Service</option>
                        <option>Repair</option>
                        <option>Maintenance</option>
                        <option>Installation</option>
                    </select>
                    <label for="typeofserviceInp" id="typeofserviceInpLbl">Type of Service</label>
                    <div class="invalid-feedback">
                        Please select Type of Service
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="mb-3 col form-floating">
                        <input type="date" class="form-control" id="datereceivedInp" name="datereceivedInp" required>
                        <label for="datereceivedInp" class="form-label ps-4" id="datereceivedInpLbl">Date Received</label>
                        <div class="invalid-feedback">
                            Please set Date Received
                        </div>
                    </div>

                    <div class="col form-floating">
                        <input type="date" class="form-control" id="datereturnedInp" name="datereturnedInp" required>
                        <label for="datereturnedInp" class="form-label ps-4" id="datereturnedInpLbl">Date Returned</label>
                        <div class="invalid-feedback">
                            Please set Date Returned
                        </div>
                    </div>
                </div>
                <div class="mb-3 col form-floating">
                    <textarea class="form-control" id="descriptionInp" name="descriptionInp" rows="3" required></textarea>
                    <label for="descriptionInp" class="form-label" id="descriptionInpLbl">Description of service</label>
                    <div class="invalid-feedback">
                        Please enter Description of service
                    </div>
                </div>
                <div class="mb-3 col form-floating">
                    <textarea class="form-control" id="actionDoneInp" name="actionDoneInp" rows="3" required></textarea>
                    <label for="actionDoneInp" class="form-label" id="actionDoneInpLbl">Action Done</label>
                    <div class="invalid-feedback">
                        Please enter Action Done
                    </div>
                </div>
                <div class="mb-3 col form-floating">
                    <textarea class="form-control" id="remarksInp" name="remarksInp" rows="3" required></textarea>
                    <label for="remarksInp" class="form-label" id="actionDoneInpLbl">Remarks</label>
                    <div class="invalid-feedback">
                        Please enter Remarks
                    </div>
                </div>
                <div class="mb-3 col form-floating">
                    <textarea class="form-control" id="recommendationInp" name="recommendationInp" rows="3" required></textarea>
                    <label for="recommendationInp" class="form-label" id="recommendationInpLbl">Recommendation</label>
                    <div class="invalid-feedback">
                        Please enter Recommendation
                    </div>
                </div>
                <div class="mb-3 form-floating">
                    <select class="form-select" id="statusInp" name="statusInp" required>
                        <option value="" selected disabled>Select a Status</option>
                        <option>Pending</option>
                        <option>On Going</option>
                        <option>Finished</option>
                    </select>
                    <label for="statusInp" class="form-label" id="statusLbl">Status</label>
                    <div class="invalid-feedback">
                        Please enter status
                    </div>
                </div>
                <div class="mb-3 col form-floating">
                    <input type="text" class="form-control" id="processedbyInp" name="processedbyInp" required>
                    <label for="processedbyInp" class="form-label" id="processedbyInpLbl">Processed by</label>
                    <div class="invalid-feedback">
                        Please enter a name
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success" id="addBtn" name="addBtn">Submit</button>
                </div>
            </form>
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
        
        $(document).ready(function () {
            $('#service_tbl').DataTable();

            //get url param and populate form fields
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const type = urlParams.get('type');
            const ictid = urlParams.get('ictid');
            
            $('#typeofictInp').val(type);
            $('#ictidInp').val(ictid);
        });
        
        const handleSubmit = async() => {
            $.ajax({
                'url' : 'addService.php',
                'method': 'POST',
                'data': {
                    type_of_services : $('#typeofserviceInp').val(),
                    type_of_ict: $('#typeofictInp').val(),
                    ICT_ID : $('#ictidInp').val(),
                    date_received : $('#datereceivedInp').val(),
                    date_returned : $('#datereturnedInp').val(),
                    description_of_service : $('#descriptionInp').val(),
                    action_done : $('#actionDoneInp').val(),
                    remarks: $('#remarksInp').val(),
                    recommendation : $('#recommendationInp').val(),
                    status: $('#statusInp').val(),
                    processed_by : $('#processedbyInp').val()
                },
                success: function (res) {
                    Swal.fire({
                        title: 'Success!',
                        text: res,
                        icon: 'success',
                        confirmButtonText: 'Okay'
                    }).then(()=>location.href = '../inventory/hardware.php')
                },
                error: function (res) {
                    Swal.fire({
                        title: 'Error!',
                        text: res,
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    }).then(()=>location.reload())
                }
            })
        }
    </script>
</html>