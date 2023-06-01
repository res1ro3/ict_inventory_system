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
    <title>Inventory | Accessories</title>
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
            <h3>Accessories</h3>
        </div>
            <div>
                <table id="softwareTbl" class="display table table-light" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Generic Name</th>
                            <th>Brand</th>
                            <th>Quantity</th>
                            <th>Specifications</th>
                            <th>Unit</th>
                            <th>Owner</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql="
                            SELECT accessories_id, generic_name, brand, quantity, specifications, unit, accessories_tbl.employee_id, employee_tbl.lname, employee_tbl.fname
                            FROM accessories_tbl
                            INNER JOIN employee_tbl ON accessories_tbl.employee_id=employee_tbl.employee_id;
                            ";
                            $query = $conn->prepare($sql);
                            $query->execute();
                            $result = $query->fetchAll();
                            $count = 1;
                            foreach ($result as $row) {
                        ?>
                        <tr>
                            <td><?= $count ?></td>
                            <td><?= $row['generic_name'] ?></td>
                            <td><?= $row['brand'] ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td><?= $row['specifications'] ?></td>
                            <td><?= $row['unit'] ?></td>
                            <td><?= $row['lname'].', '.$row['fname'] ?></td>
                            <td>
                                <button id="viewBtn" onclick="get('<?= $row['accessories_id'] ?>')" type="button" data-id="<?= $row['accessories_id'] ?>" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal">View</button>
                                <button id="editBtn" onclick="getEdit('<?= $row['accessories_id'] ?>')" type="button" data-id="<?= $row['accessories_id'] ?>" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            </td>
                            
                        </tr>
                        <?php $count++; } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8"><button style="width: 90px;" class="btn btn-success" onclick="location.href='/ict_inventory_system/accessories/add.php'">Add</button></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
    </div>
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Accessory</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="needs-validation" novalidate id="updateForm" name="updateForm" method="post">
                    <input type="text" class="form-control" id="aidInpEdit" name="aidInpEdit">

                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="genericnameInpEdit" name="genericnameInpEdit" required>
                        <label for="genericnameInpEdit" class="form-label">Generic Name</label>
                        <div class="invalid-feedback">
                            Please enter Generic Name
                        </div>
                    </div>

                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="brandInpEdit" name="brandInpEdit" required>
                        <label for="brandInpEdit" class="form-label">Brand</label>
                        <div class="invalid-feedback">
                            Please enter Brand
                        </div>
                    </div>

                    <div class="mb-3 col form-floating">
                        <input type="number" class="form-control" id="quantityInpEdit" name="quantityInpEdit" required>
                        <label for="quantityInpEdit" class="form-label">Quantity</label>
                        <div class="invalid-feedback">
                            Please enter Quantity
                        </div>
                    </div>

                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="specificationsInpEdit" name="specificationsInpEdit" required>
                        <label for="specificationsInpEdit" class="form-label">Specifications</label>
                        <div class="invalid-feedback">
                            Please enter Specifications
                        </div>
                    </div>

                    <div class="mb-3 form-floating">
                        <select class="form-select" id="unitInpEdit" name="unitInpEdit" required>
                            <option value="" selected disabled>Select Unit</option>
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
                        <label for="unitInpEdit" id="officeLbl">Office</label>
                        <div class="invalid-feedback">
                            Please select an Office
                        </div>
                    </div>

                    <div class="mb-3 form-floating">
                        <select class="form-select" id="ownerInpEdit" name="ownerInpEdit" required>
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

        function changeDateFormat(dateString) {
            // Create a new Date object from the date string.
            const date = new Date(dateString);

            // Get the year, month, and day from the Date object.
            const year = date.getFullYear();
            const month = date.getMonth() + 1;
            const day = date.getDate();

            // Format the date in the desired format.
            const formattedDate = `${year}-${month}-${day}`;

            // Return the formatted date.
            return formattedDate;
        }

        
        const get = async (aid) => {
            location.href = "/ict_inventory_system/accessories/view.php?aid=" + aid;
        }

        function getEdit(aid) {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {accessories_id:aid}
            }).then((res) => {
                    res = JSON.parse(res);

                    $("#aidInpEdit").val(res.accessories_id);
                    $("#genericnameInpEdit").val(res.generic_name);
                    $('#brandInpEdit').val(res.brand);
                    $('#quantityInpEdit').val(res.quantity);
                    $('#specificationsInpEdit').val(res.specifications);
                    $('#unitInpEdit').val(res.unit);
                    $('#ownerInpEdit').val(res.employee_id);
                });
        }

        function getTransfer(sid) {
            $.ajax({
                type: "GET",
                url: "./get.php",
                data: {hardware_id:sid},
                success: function (res) {
                    res = JSON.parse(res);
                    $("#sidInp").val(res.hardware_id);
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
                    accessories_id: $("#aidInpEdit").val(),
                    generic_name: $("#genericnameInpEdit").val(),
                    brand: $('#brandInpEdit').val(),
                    quantity:$('#quantityInpEdit').val(),
                    specifications:$('#specificationsInpEdit').val(),
                    unit:$('#unitInpEdit').val(),
                    employee_id:$('#ownerInpEdit').val(),
                }
            }).then((res)=> {
                if (res == 'Updated Successfully') {
                    Swal.fire({
                        title: 'Success!',
                        text: res,
                        icon: 'success',
                        confirmButtonText: 'Okay'
                    }).then(()=>location.reload())
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: res,
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    }).then(()=>location.reload())
                }
            });
        }

        function changeServiceStatus(ictid, status) {
            $.ajax({
                type: "POST",
                url: "changeServiceStatus.php",
                data: {
                    ictid,
                    status
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
                        hardware_id: $("#sidInp").val(),
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
                        console.log(res);
                        // Swal.fire({
                        //     title: 'Error!',
                        //     text: "Transferred failed",
                        //     icon: 'error',
                        //     confirmButtonText: 'Okay'
                        // }).then(()=>location.reload())
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
            $('#softwareTbl').DataTable();
            $('#tbl_transfer').DataTable();
        });
    </script>
</html>