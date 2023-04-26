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
    <title>Management of Accounts</title>
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css" />
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div id="nav-placeholder"></div>
        <h3>Management of Accounts</h3>
        <button class="btn btn-dark mb-3" onclick="location.href='./addEmployee.php'">Add Account</button>
        <table id="accsTbl" class="display table table-light" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Type of Account</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql="SELECT * FROM employee_tbl";
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $result = $query->fetchAll();
                    $count = 1;
                    foreach ($result as $row) {
                ?>
                <tr>
                    <td><?= $count ?></td>
                    <span id="eid" style="display: none"><?= $row['employee_id']?></span>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['type_of_account'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <button id="editBtn" onclick="get('<?= $row['employee_id'] ?>')" type="button" data-id="<?= $row['employee_id'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                        <button class="btn btn-warning">Reset Password</button>
                        <button onclick="change_status('<?= $row['status'] ?>','<?= $row['employee_id'] ?>')" id="btnStatus" class="btn btn-danger"><?= $row['status'] == "Active" ? "Inactivate" : "Activate" ?></button>
                    </td>
                </tr>
                <?php $count++; } ?>
        </table>

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
                            <option value="<?php echo htmlentities($result->name);?>"><?php echo htmlentities($result->name);?></option>
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

                    <div class="mb-3 form-floating">
                        <select class="form-select" id="typeOfAccountInp" name="typeOfAccountInp" required>
                            <option value="" selected disabled>Select Type of Account</option>
                            <option>Admin</option>
                            <option>Ordinary User</option>
                        </select>
                        <label for="typeOfAccountInp" id="typeOfAccounttLbl">Type of Account</label>
                        <div class="invalid-feedback">
                            Please select Type of Account
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
                    $("#passwordInp").val(res.password);
                    $("#sexInp").val(res.sex);
                    $("#officeInp").val(res.unitOffice);
                    $("#positionInp").val(res.position);
                    $("#typeOfEmploymentInp").val(res.type_of_employment);
                    $("#typeOfAccountInp").val(res.type_of_account);
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
                    password: $("#passwordInp").val(),
                    sex: $("#sexInp").val(),
                    unitOffice: $("#officeInp").val(),
                    position: $("#positionInp").val(),
                    type_of_employment: $("#typeOfEmploymentInp").val(),
                    type_of_account: $("#typeOfAccountInp").val()
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

        $(document).ready(function () {
            $('#accsTbl').DataTable();
            $("#nav-placeholder").load("../nav.html");
        });
    </script>
</html>