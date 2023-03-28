<?php
    require_once('../dbconfig.php');
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
</head>
<body>
    <div class="container">
        <h3>Management of Accounts</h3>
        <button class="btn btn-dark mb-3" onclick="location.href='./addEmployee.php'">Add Account</button>
        <table id="example" class="display table table-light" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Type of Account</th>
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
                    <span style="display: block"><?= $row['id']?></span>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['type_of_account'] ?></td>
                    <td>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                        <button class="btn btn-warning">Reset Password</button>
                        <button class="btn btn-danger">Archive</button>
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
                    <p>...</p>
                <?php
                    // $id = $row['id'];
                    // $sql="SELECT * FROM employee_tbl WHERE id=:uid";
                    // $query = $conn->prepare($sql);
                    // $query->bindParam(':uid',$id,PDO::PARAM_STR);
                    // $query->execute();
                    // $editquery = $query->fetch();
                    // print_r($editquery);
                ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
</html>