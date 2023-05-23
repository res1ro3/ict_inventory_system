<?php
    require_once('../dbconfig.php');
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }

    if (isset($_POST['addBtn'])) {
        $title = $_POST['titleInp'];

        $sql="INSERT INTO positions_tbl(title) VALUES(:tl)";
        $query = $conn->prepare($sql);

        $query->bindParam(':tl',$title,PDO::PARAM_STR);

        $query->execute();

        if($query->rowCount() == 1) {
            echo '<script>alert("Added Successfully")</script>';
        } else {
            echo '<script>alert("An error has occured")</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Positions</title>
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css" />
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../inventory/inventory.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="brands">
        <div id="sidebar-placeholder"><?php include("../sidebar.php") ?></div>
        <div class="brands-container">
            <div class="dashboard-header" style="margin: 2rem 0">
                <h3>Manage Positions</h3>
            </div>
            <div class="brands_add">
                <form class="needs-validation d-flex" novalidate id="addForm" name="addForm" method="post">
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="titleInp" name="titleInp" required>
                        <label for="titleInp" class="form-label" id="titleLbl">Title</label>
                        <div class="invalid-feedback">
                            Please enter Title
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
                            <th>Title</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql="
                            SELECT * FROM positions_tbl
                            ";
                            $query = $conn->prepare($sql);
                            $query->execute();
                            $result = $query->fetchAll();
                            $count = 1;
                            foreach ($result as $row) {
                        ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $row['title'] ?></td>
                            <td>
                                <button id="editBtn" onclick="get('<?= $row['position_id'] ?>')" type="button" data-id="<?= $row['position_id'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
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
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Position</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="needs-validation" novalidate id="updateForm" name="updateForm" method="post">
                    <div class="mb-3 col form-floating">
                        <input type="hidden" class="form-control" id="positionIdInp" name="positionIdInp">
                        <input type="text" class="form-control" id="positionInp" name="positionInp" required>
                        <label for="positionInp" class="form-label" id="positionLbl">Position</label>
                        <div class="invalid-feedback">
                            Please enter Position
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
        function get(position_id) {
            $.ajax({
                type: "POST",
                url: "./position_api.php",
                data: {position_id: position_id, api_type: "get"},
                success: function (res) {
                    console.log(res);
                    res = JSON.parse(res);
                    $("#positionInp").val(res.title);
                    $("#positionIdInp").val(res.position_id);
                }
            });
        }

        function update() {
            $.ajax({
                type: "POST",
                url: "update_brand.php",
                data: {
                    brand_id: $("#brandIdInp").val(),
                    name: $("#brandInp").val(),
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