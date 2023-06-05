<?php 
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }
    
    require_once('../dbConfig.php');

    if (isset($_POST['addBtn'])) {
        $generic_name = $_POST['genericnameInp'];
        $brand = $_POST['brandInp'];
        $quantity = $_POST['quantityInp'];
        $specifications = $_POST['specificationsInp'];
        $unit = $_POST['unitInp'];
        $employee_id = $_POST['ownerInp'];

        $sql="INSERT INTO accessories_tbl(generic_name, brand, quantity, specifications, unit, employee_id) 
            VALUES(:gn, :brand, :qty, :specs, :unit, :eid)";
        $query = $conn->prepare($sql);

        $query->execute(array(
            'gn' => $generic_name,
            'brand' => $brand,
            'qty' => $quantity,
            'specs' => $specifications,
            'unit' => $unit,
            'eid' => $employee_id
        ));

        if($query->rowCount() == 1) {
            echo '<script>alert("Added Successfully"); location.href="index.php"</script>';
        } else {
            echo '<script>alert("An error has occured")"</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Accessory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/inventory.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="inventory">
        <div id="sidebar-placeholder"><?php include("../sidebar.php") ?></div>
        <div class="addDiv">
            <div class="dashboard-header" style="margin: 2rem 0">
                <h3>ADD ACCESSORY</h3>
            </div>
            <!-- <h3 class="text-center mt-5 mb-3">ADD ICT NETWORK HARDWARE</h3> -->
            <form class="needs-validation" novalidate id="addForm" name="addForm" method="post">
                <div class="mb-3 col form-floating">
                    <input type="text" class="form-control" id="genericnameInp" name="genericnameInp" required>
                    <label for="genericnameInp" class="form-label fw-bold">Generic Name</label>
                    <div class="invalid-feedback">
                        Please enter Generic Name
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
                            <option value="<?php echo htmlentities($result->brand_id);?>"><?php echo htmlentities($result->name);?></option>
                        <?php }} ?>
                    </select>
                    <label class="form-label fw-bold" for="brandInp" id="brandLbl">Brand</label>
                    <div class="invalid-feedback">
                        Please select Brand
                    </div>
                </div>

                <div class="mb-3 col form-floating">
                    <input type="number" class="form-control" id="quantityInp" name="quantityInp" required>
                    <label for="quantityInp" class="form-label fw-bold">Quantity</label>
                    <div class="invalid-feedback">
                        Please enter Quantity
                    </div>
                </div>

                <div class="mb-3 col form-floating">
                    <input type="text" class="form-control" id="specificationsInp" name="specificationsInp" required>
                    <label for="specificationsInp" class="form-label fw-bold">Specifications</label>
                    <div class="invalid-feedback">
                        Please enter Specifications
                    </div>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="unitInp" name="unitInp" required>
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
                        <option value="<?php echo htmlentities($result->office_id);?>"><?php echo htmlentities($result->name);?></option>
                    <?php }} ?>
                    </select>
                    <label for="unitInp" id="officeLbl" class="form-label fw-bold">Office</label>
                    <div class="invalid-feedback">
                        Please select an Office
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
                    <label for="ownerInp" class="form-label fw-bold">Owner</label>
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