<?php 
    require_once('../dbConfig.php');

    if (isset($_POST['addBtn'])) {
        $mac_address = $_POST['macInp'];
        $type_of_hardware = $_POST['typeofhardwareInp'];
        $brand = $_POST['brandInp'];
        $model = $_POST['modelInp'];
        $serial_number = $_POST['serialnumberInp'];
        $date_of_purchase = $_POST['dateofpurchaseInp'];
        $warranty = $_POST['warrantyInp'];
        $employee_id = $_POST['ownerInp'];
        $status = $_POST['statusInp'];

        $sql="INSERT INTO ict_network_hardware_tbl(mac_address, type_of_hardware, brand, model, serial_number, date_of_purchase, warranty, employee_id, status) VALUES(:mac,:toh,:br,:md,:sn,:dop,:wt,:eid,:st)";
        $query = $conn->prepare($sql);

        $query->bindParam(':mac',$mac_address,PDO::PARAM_STR);
        $query->bindParam(':toh',$type_of_hardware,PDO::PARAM_STR);
        $query->bindParam(':br',$brand,PDO::PARAM_STR);
        $query->bindParam(':md',$model,PDO::PARAM_STR);
        $query->bindParam(':sn',$serial_number,PDO::PARAM_STR);
        $query->bindParam(':dop',$date_of_purchase,PDO::PARAM_STR);
        $query->bindParam(':wt',$warranty,PDO::PARAM_STR);
        $query->bindParam(':eid',$employee_id,PDO::PARAM_STR);
        $query->bindParam(':st',$status,PDO::PARAM_STR);

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
    <title>ADD ICT NETWORK HARDWARE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/employee.css">
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div id="nav-placeholder"></div>
        <div class="addDiv" style="width: 50%">
        <button class="btn btn-dark mb-3" onclick="location.href='./manageInventory.php'">Manage Inventory</button>
            <form class="needs-validation" novalidate id="addForm" name="addForm" method="post">
                <h3 class="text-center mt-5 mb-3">ADD ICT NETWORK HARDWARE</h3>
                <div class="mb-3 col form-floating">
                    <input type="text" class="form-control" id="macInp" name="macInp" required>
                    <label for="macInp" class="form-label" id="macLbl">MAC Address</label>
                    <div class="invalid-feedback">
                        Please enter MAC Address
                    </div>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="typeofhardwareInp" name="typeofhardwareInp" required>
                        <option value="" selected disabled>Select Type of Hardware</option>
                        <option>Equipment</option>
                        <option>Tools</option>
                    </select>
                    <label for="typeofhardwareInp" id="typeofhardwareLbl">Type of Hardware</label>
                    <div class="invalid-feedback">
                        Please select Type of Hardware
                    </div>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="brandInp" name="brandInp" required>
                        <option value="" selected disabled>Please select Brand</option>
                        <option>HP</option>
                        <option>ACER</option>
                    </select>
                    <label for="brandInp" id="brandLbl">Brand</label>
                    <div class="invalid-feedback">
                        Please select Brand
                    </div>
                </div>

                <div class="mb-3 col form-floating">
                    <input type="text" class="form-control" id="modelInp" name="modelInp" required>
                    <label for="modelInp" class="form-label" id="modelLbl">Model</label>
                    <div class="invalid-feedback">
                        Please enter Model
                    </div>
                </div>

                <div class="mb-3 col form-floating">
                    <input type="text" class="form-control" id="serialnumberInp" name="serialnumberInp" required>
                    <label for="serialnumberInp" class="form-label" id="serialnumberLbl">Serial Number</label>
                    <div class="invalid-feedback">
                        Please enter Serial Number
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="mb-3 col form-floating">
                        <input type="date" class="form-control" id="dateofpurchaseInp" name="dateofpurchaseInp" required>
                        <label for="dateofpurchaseInp" class="form-label ps-4" id="dateofpurchaseLbl">Date of Purchase</label>
                        <div class="invalid-feedback">
                            Please set Date of Purchase
                        </div>
                    </div>

                    <div class="col form-floating">
                        <input type="date" class="form-control" id="warrantyInp" name="warrantyInp" required>
                        <label for="warrantyInp" class="form-label ps-4" id="warrantyLbl">End of Warranty</label>
                        <div class="invalid-feedback">
                            Please enter End of Warranty
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-floating">
                    <select class="form-select" id="ownerInp" name="ownerInp" required>
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
                    <label for="ownerInp" id="ownerLbl">Owner</label>
                    <div class="invalid-feedback">
                        Please select Owner
                    </div>
                </div>
                <div class="mb-3 form-floating">
                    <select class="form-select" id="statusInp" name="statusInp" required>
                        <option value="" selected disabled>Please select Status</option>
                        <option>Serviceable</option>
                        <option>Non-Serviceable</option>
                    </select>
                    <label for="statusInp" id="statusLbl">Status</label>
                    <div class="invalid-feedback">
                        Please select Status
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success" id="addBtn" name="addBtn">ADD</button>
                </div>
            </form>
        </div>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6952492a89.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        function update() {
            $.ajax({
                type: "POST",
                url: "./update.php",
                data: {
                    mac_address: $("#macInp").val(),
                    type_of_hardware: $("#typeofhardwareInp").val(),
                    brand: $('#brandInp').val(),
                    model: $('#modelInp').val(),
                    serial_number:$('#serialnumberInp').val(),
                    date_of_purchase:$('#dateofpurchaseInp').val(),
                    warranty:$('#warrantyInp').val(),
                    employee_id:$('#ownerInp').val(),
                    status:$('#statusInp').val(),
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
            $("#nav-placeholder").load("../nav.html");
        });

    </script>
</html>