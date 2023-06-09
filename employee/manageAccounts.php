<?php
    require_once('../dbconfig.php');
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        $_SESSION['accType'] == "Super Admin" ? $showType = "Admin" : $showType = "Ordinary User" ;
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
    <title>Management of Accounts</title>
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css" />
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="styles/employee.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="accounts">
        <div id="sidebar-placeholder"><?php include("../sidebar.php") ?></div>
        <div class="accounts-container">
            <div class="dashboard-header" style="margin: 2rem 0">
                <h3>Manange Accounts</h3>
            </div>
            <table id="accsTbl" class="display table table-light" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee Name</th>
                        <th>Type of Account</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql="SELECT * FROM employee_tbl WHERE type_of_account = '".$showType."'";
                        $query = $conn->prepare($sql);
                        $query->execute();
                        $result = $query->fetchAll();
                        $count = 1;
                        foreach ($result as $row) {
                            $get_office = $conn->prepare("SELECT * FROM office_tbl WHERE office_id = :id");
                            $get_office->execute(array(':id' => $row['unitOffice']));
                            $office=$get_office->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <tr>
                        <td><?= $count ?></td>
                        <span id="eid" style="display: none"><?= $row['employee_id']?></span>
                        <td><?= $row['lname'].', '.$row['fname'] ?></td>
                        <td><?= $row['type_of_account'] ?></td>
                        <td><?= $office['name'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td>
                            <button id="editBtn" onclick="get('<?= $row['employee_id'] ?>')" type="button" data-id="<?= $row['employee_id'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            <button class="btn btn-warning" onClick="res_pass('<?= $row['employee_id'] ?>')">Reset Password</button>
                            <button onclick="change_status('<?= $row['status'] ?>','<?= $row['employee_id'] ?>')" id="btnStatus" class="btn btn-danger"><?= $row['status'] == "Active" ? "Disable" : "Enable" ?></button>
                        </td>
                    </tr>
                    <?php $count++; } ?>
            </table>
        </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Account</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form class="needs-validation" novalidate id="updateAccForm" name="updateAccForm" method="post">
                        <input type="hidden" id="employeeId" name="employeeId"></input>
                        <div class="mb-3 row">
                            <div class="mb-3 col form-floating">
                                <input type="text" class="form-control addAccInp" id="lnameInp" name="lnameInp" required>
                                <label for="lnameInp" class="form-label ps-4" id="lnameLbl">Last Name</label>
                                <div class="invalid-feedback">
                                    Please enter Last Name
                                </div>
                            </div>
                            <div class="mb-3 col form-floating">
                                <input type="text" class="form-control addAccInp" id="fnameInp" name="fnameInp" required>
                                <label for="fnameInp" class="form-label ps-4" id="fnameLbl">First Name</label>
                                <div class="invalid-feedback">
                                    Please enter First Name
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control addAccInp" id="usernameInp" name="usernameInp" required>
                            <label for="usernameInp" class="form-label" id="usernameLbl">Username</label>
                            <div class="invalid-feedback">
                                Please enter Username
                            </div>
                            <span id="usernameInp-message"></span>
                        </div>
                            
                        <div class="mb-3 form-floating">
                            <select class="form-select" id="sexInp" name="sexInp" required>
                                <option value="" selected disabled>Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <label for="sexInp" id="sexLbl">Sex</label>
                            <div class="invalid-feedback">
                                Please select sex
                            </div>
                        </div>

                        <div class="mb-3 form-floating">
                            <select class="form-select" id="officeInp" name="officeInp" required>
                                <option value="" selected disabled>Select Office</option>
                            <?php
                                $sql="SELECT * FROM office_tbl";
                                $query = $conn->prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                
                                $count=1;
                                if($query->rowCount() > 0) {
                                //In case that the query returned at least one record, we can echo the records within a foreach loop:
                                    foreach($results as $result)
                                {
                            ?>
                                <option value="<?php echo htmlentities($result->office_id);?>"><?php echo htmlentities($result->name);?></option>
                            <?php }} ?>
                            </select>
                            <label for="officeInp" id="officeLbl">Office</label>
                            <div class="invalid-feedback">
                                Please select an Office
                            </div>
                        </div>

                        <div class="mb-3 form-floating">
                            <select class="form-select" id="positionInp" name="positionInp" required>
                                <option value="" selected disabled>Select Position</option>
                                <option>Position 1</option>
                                <option>Position 2</option>
                                <option>Position 3</option>
                            </select>
                            <label for="positionInp" id="positionLbl">Position</label>
                            <div class="invalid-feedback">
                                Please select a Position
                            </div>
                        </div>

                        <div class="mb-3 form-floating">
                            <select class="form-select" id="typeOfEmploymentInp" name="typeOfEmploymentInp" required>
                                <option value="" selected disabled>Select Type of Employment</option>
                                <option>COS</option>
                                <option>Regular</option>
                            </select>
                            <label for="typeOfEmploymentInp" id="typeOfEmploymentLbl">Type of Employment</label>
                            <div class="invalid-feedback">
                                Please select Type of Employment
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
        function get(eid) {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {eid:eid},
                success: function (res) {
                    res = JSON.parse(res);
                    console.log(res.employee_id);
                    $("#employeeId").val(res.employee_id);
                    $("#lnameInp").val(res.lname);
                    $("#fnameInp").val(res.fname);
                    $("#usernameInp").val(res.username);
                    $("#sexInp").val(res.sex);
                    $("#officeInp").val(res.unitOffice);
                    $("#positionInp").val(res.position);
                    $("#typeOfEmploymentInp").val(res.type_of_employment);
                }
            });
        }

        function update() {
            $.ajax({
                type: "POST",
                url: "./update.php",
                data: {
                    employee_id: $("#employeeId").val(),
                    lname: $("#lnameInp").val(),
                    fname: $("#fnameInp").val(),
                    username: $("#usernameInp").val(),
                    sex: $("#sexInp").val(),
                    unitOffice: $("#officeInp").val(),
                    position: $("#positionInp").val(),
                    type_of_employment: $("#typeOfEmploymentInp").val()
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

        function res_pass(eid) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "./resetpass.php",
                        data: {
                            employee_id: eid,
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
            })
            
        }

        $(document).ready(function () {
            $('#accsTbl').DataTable();
            // $('#sidebar-placeholder').load('../sidebar.html');
        });
    </script>
</html>