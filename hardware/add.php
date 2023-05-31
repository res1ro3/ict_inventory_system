<?php 
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }
    
    require_once('../dbConfig.php');

    if (isset($_POST['addBtn'])) {
        $mac_address = $_POST['macInp'];
        $type_of_hardware = $_POST['typeofhardwareInp'];
        $brand = $_POST['brandInp'];
        $model = $_POST['modelInp'];
        $serial_number = $_POST['serialnumberInp'];
        $specifications = $_POST['specificationsInp'];
        $cost = $_POST['costInp'];
        $date_of_purchase = $_POST['dateofpurchaseInp'];
        $warranty = $_POST['warrantyInp'];
        $employee_id = $_POST['ownerInp'];
        // $employee_id = 1;
        $owner_name = $_POST['ownerInp'];
        $status = $_POST['statusInp'];

        $sql="INSERT INTO ict_network_hardware_tbl(mac_address, type_of_hardware, brand, model, serial_number, date_of_purchase, warranty, status, owner_name, employee_id, specifications, cost) 
            VALUES(:mac,:toh,:br,:md,:sn,:dop,:wt,:st,:on,:eid,:specs,:cost)";
        $query = $conn->prepare($sql);

        $query->execute(array(
            'mac' => $mac_address,
            'toh' => $type_of_hardware,
            'br' => $brand,
            'md' => $model,
            'sn' => $serial_number,
            'specs' => $specifications,
            'cost' => $cost,
            'dop' => $date_of_purchase,
            'wt' => $warranty,
            'on' => $owner_name,
            'st' => $status,
            'eid' => $employee_id
        ));

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
    <title>Add Hardware</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="inventory.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="inventory">
        <div id="sidebar-placeholder"><?php include("../sidebar.php") ?></div>
        <div class="addDiv">
            <div class="dashboard-header" style="margin: 2rem 0">
                <h3>ADD HARDWARE</h3>
            </div>
            <!-- <h3 class="text-center mt-5 mb-3">ADD ICT NETWORK HARDWARE</h3> -->
            <form class="needs-validation" novalidate id="addForm" name="addForm" method="post">
                <div class="mb-3 col form-floating">
                    <input type="text" class="form-control" id="macInp" name="macInp" required>
                    <label for="macInp" class="form-label fw-bold" id="macLbl">MAC Address</label>
                    <div class="invalid-feedback">
                        Please enter MAC Address
                    </div>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="typeofhardwareInp" name="typeofhardwareInp" required>
                        <option value="" selected disabled>Please select Type of Hardware</option>
                        <?php
                            $sql="SELECT * FROM `type_of_hardware_tbl`";
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
                    <label class="form-label fw-bold" for="typeofhardwareInp" id="typeofhardwareLbl">Type of Hardware</label>
                    <div class="invalid-feedback">
                        Please select Type of Hardware
                    </div>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="brandInp" name="brandInp" required>
                        <option value="" selected disabled>Please select Brand</option>
                        <?php
                            $sql="SELECT * FROM `brand_tbl`";
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
                    <label class="form-label fw-bold" for="brandInp" id="brandLbl">Brand</label>
                    <div class="invalid-feedback">
                        Please select Brand
                    </div>
                </div>

                <div class="mb-3 col form-floating">
                    <input type="text" class="form-control" id="modelInp" name="modelInp" required>
                    <label for="modelInp" class="form-label fw-bold" id="modelLbl">Model</label>
                    <div class="invalid-feedback">
                        Please enter Model
                    </div>
                </div>

                <div class="mb-3 col form-floating">
                    <input type="text" class="form-control" id="serialnumberInp" name="serialnumberInp" required>
                    <label for="serialnumberInp" class="form-label fw-bold" id="serialnumberLbl">Serial Number</label>
                    <div class="invalid-feedback">
                        Please enter Serial Number
                    </div>
                </div>

                <div class="mb-3 col">
                    <label for="specificationsInp" class="form-label fw-bold ps-2 text-secondary" id="specificationsInpLbl">Specifications</label>
                    <textarea class="form-control" id="specificationsInp" name="specificationsInp" rows="4" cols="50" placeholder="Enter specification here" required></textarea>
                   
                    <div class="invalid-feedback">
                        Please enter Specifications
                    </div>
                </div>

                <div class="mb-3 col form-floating">
                    <input type="number" class="form-control" id="costInp" name="costInp" required>
                    <label for="costInp" class="form-label fw-bold" id="costInpsLbl">Cost (PHP)</label>
                    <div class="invalid-feedback">
                        Please enter Cost in PHP
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="mb-3 col form-floating">
                        <input type="date" class="form-control" id="dateofpurchaseInp" name="dateofpurchaseInp" required>
                        <label for="dateofpurchaseInp" class="form-label ps-4 fw-bold" id="dateofpurchaseLbl">Date of Purchase</label>
                        <div class="invalid-feedback">
                            Please set Date of Purchase
                        </div>
                    </div>

                    <div class="col form-floating">
                        <input type="date" class="form-control" id="warrantyInp" name="warrantyInp" required>
                        <label for="warrantyInp" class="form-label ps-4 fw-bold" id="warrantyLbl">End of Warranty</label>
                        <div class="invalid-feedback">
                            Please enter End of Warranty
                        </div>
                    </div>
                </div>

                <!-- <div class="mb-3 col form-floating">
                    <input type="text" class="form-control" id="ownerInp" name="ownerInp" required>
                    <label for="ownerInp" class="form-label" id="ownerLbl">Owner</label>
                    <div class="invalid-feedback">
                        Please enter Owner
                    </div>
                </div> -->
                
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
                        <option value="<?php echo htmlentities($result->employee_id) ?>"><?php echo htmlentities($result->lname).', '.htmlentities($result->fname);?></option>
                    <?php }} ?>
                    </select>
                    <label class="form-label fw-bold" for="ownerInp" id="ownerLbl">Owner</label>
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
                    <label class="form-label fw-bold" for="statusInp" id="statusLbl">Status</label>
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
    </script>
</html>