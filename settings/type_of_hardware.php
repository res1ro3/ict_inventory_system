<?php
    require_once('../dbconfig.php');
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }

    if (isset($_POST['addBtn'])) {
        
        $name = $_POST['typeInp'];

        $sql="SELECT * FROM `type_of_hardware_tbl` WHERE `name` LIKE :nm";
        $query = $conn->prepare($sql);
        $query->bindParam(':nm',$name,PDO::PARAM_STR);
        $query->execute();
        
            if($query->rowCount() == 1) {
                
                $sql="INSERT INTO type_of_hardware_tbl(name) VALUES(:nm)";
                $query = $conn->prepare($sql);

                $query->bindParam(':nm',$name,PDO::PARAM_STR);

                $query->execute();

                if($query->rowCount() == 1) {
                    echo '<script>alert("Added Successfully")</script>';
                } else {
                    echo '<script>alert("An error has occured")</script>';
                }
            } else {
                echo '<script>alert("Type of hardware already exist")</script>';
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Types of Hardware</title>
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css" />
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../styles/inventory.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="brands">
        <div id="sidebar-placeholder"><?php include("../sidebar.php") ?></div>
        <div class="brands-container">
            <div class="dashboard-header" style="margin: 2rem 0">
                <h3>Manage Types of Hardware</h3>
            </div>
            <div class="brands_add">
                <form class="needs-validation d-flex" novalidate id="addForm" name="addForm" method="post">
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="typeInp" name="typeInp" required>
                        <label for="typeInp" class="form-label" id="typeLbl">Type of Hardware</label>
                        <div class="invalid-feedback">
                            Please enter Type of Hardware
                        </div>
                    </div>
                    <div class="mb-3 col">
                        <button name="addBtn" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
            <div class="brands_tbl">
                <table id="ictnetworkhardwareTbl" class="display table table-light" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type of Hardware</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql="
                            SELECT * FROM type_of_hardware_tbl
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
                                <button id="editBtn" onclick="get('<?= $row['type_of_hardware_id'] ?>')" type="button" data-id="<?= $row['type_of_hardware_id'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            </td>
                        </tr>
                        <?php $count++; } ?>
                </table>
            </div>
        </div>
        

        <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Type of Hardware</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="needs-validation" novalidate id="updateForm" name="updateForm" method="post">
                    <div class="mb-3 col form-floating">
                        <input type="hidden" class="form-control" id="typeofhardwareIdInp" name="typeofhardwareIdInp">
                        <input type="text" class="form-control" id="typeofhardwareInp" name="typeofhardwareInp" required>
                        <label for="typeofhardwareInp" class="form-label" id="typeofhardwareInpLbl">Type of Hardware</label>
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
        function get(thid) {
            $.ajax({
                type: "POST",
                url: "./get_type.php",
                data: {type_of_hardware_id: thid},
                success: function (res) {
                    res = JSON.parse(res);
                    $("#typeofhardwareInp").val(res.name);
                    $("#typeofhardwareIdInp").val(res.type_of_hardware_id);
                }
            });
        }

        function update() {
            $.ajax({
                type: "POST",
                url: "update_type.php",
                data: {
                    type_of_hardware_id: $("#typeofhardwareIdInp").val(),
                    name: $("#typeofhardwareInp").val(),
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
            })
        }

        $(document).ready(function () {
            $('#ictnetworkhardwareTbl').DataTable();
        });
    </script>
</html>