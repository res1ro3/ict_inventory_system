<?php 
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        $_SESSION['accType'] == 'Super Admin' ? $typeofaccount = "Admin" : $typeofaccount = "Ordinary User";
    } else {
        header("Location: ../admin/signin.php");
    }

    require_once('../dbConfig.php');

    if (isset($_POST['addAccBtn'])) {
        $lname = $_POST['lnameInp'];
        $fname = $_POST['fnameInp'];
        $username = $_POST['usernameInp'];
        $password = $_POST['passwordInp'];
        $sex = $_POST['sexInp'];
        $office = $_POST['officeInp'];
        $position = $_POST['positionInp'];
        $typeofemployment = $_POST['typeOfEmploymentInp'];
        
        $status = "Active";     

        $PASSWORD = $password;

        $salt = "94665FAE66173BF677A723E4E38E5";
        $hash_salt = hash_hmac("sha256", $PASSWORD, $salt);
        $pwd_hashed = password_hash($hash_salt, PASSWORD_ARGON2ID);

        $sql="INSERT INTO employee_tbl(lname,fname,username,password,sex,unitOffice,position,type_of_employment,type_of_account,status) VALUES(:lname,:fname,:username,:password,:sex,:office,:position,:typeofemployment,:typeofaccount,:status)";
        $query = $conn->prepare($sql);

        $query->bindParam(':lname',$lname,PDO::PARAM_STR);
        $query->bindParam(':fname',$fname,PDO::PARAM_STR);
        $query->bindParam(':username',$username,PDO::PARAM_STR);
        $query->bindParam(':password',$pwd_hashed,PDO::PARAM_STR);
        $query->bindParam(':sex',$sex,PDO::PARAM_STR);
        $query->bindParam(':office',$office,PDO::PARAM_STR);
        $query->bindParam(':position',$position,PDO::PARAM_STR);
        $query->bindParam(':typeofemployment',$typeofemployment,PDO::PARAM_STR);
        $query->bindParam(':typeofaccount',$typeofaccount,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);

        $query->execute();

        if($query->rowCount() == 1) {
            echo '<script>alert("User Added Successfully"); location.href="addEmployee.php";</script>';
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
    <title>ICT Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/employee.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="accounts">
        <div id="sidebar-placeholder"><?php include("../sidebar.php") ?></div>
        <div class="add-accounts-container">
            <div class="addAccDiv">
                <div class="dashboard-header" style="margin: 2rem 0">
                    <h3>Add Account</h3>
                </div>
                <form class="needs-validation" novalidate id="addAccForm" name="addAccForm" method="post">
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

                    <div class="mb-3 row">
                        <div class="mb-3 col form-floating">
                            <input type="password" class="form-control addAccInp" id="passwordInp" name="passwordInp" required>
                            <label for="passwordInp" class="form-label ps-4" id="passwordLbl">Password</label>
                            <div class="invalid-feedback">
                                Please enter Password
                            </div>
                        </div>
                        <div class="mb-3 col form-floating">
                            <input type="password" class="form-control addAccInp" id="confirmPasswordInp" name="confirmPasswordInp" required>
                            <label for="confirmPasswordInp" class="form-label ps-4" id="confirmPasswordLbl">Confirm Password</label>
                            <div class="invalid-feedback">
                                Please Confirm Password
                            </div>
                            <span id="confirmPasswordInp-message"></span>
                        </div>
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
                    
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control addAccInp" id="positionInp" name="positionInp" required>
                        <label for="positionInp" class="form-label" id="positionLbl">Position</label>
                        <div class="invalid-feedback">
                            Please enter a Position
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
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success" id="addAccBtn" name="addAccBtn">ADD</button>
                    </div>
                </form>
            </div>
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

        $(document).ready(function() {
            //Username check for existing
            $('#usernameInp').blur(function() {
                var username = $(this).val();
                console.log(username);
                $.ajax({
                    url: 'check_username.php',
                    method: 'POST',
                    data: {usernameInp:username},
                    success: function(response) {
                        if (response == 'taken') {
                            $('#usernameInp-message').html('Username already exists');
                            $('#usernameInp-message').css('color', '#dc3545');
                        } else {
                            $('#usernameInp-message').html('');
                        }
                    }
                });
            });

            //Pass and Confirm Pass Validation

            $('#confirmPasswordInp').blur(function() {
                var password = $('#passwordInp').val();
                var confirmPassword = $(this).val();

                if (password != confirmPassword) {
                    $('#confirmPasswordInp-message').html('Passwords do not match');
                    $('#confirmPasswordInp-message').css('color', '#dc3545');
                } else {
                    $('#confirmPasswordInp-message').html('Passwords match');
                    $('#confirmPasswordInp-message').css('color', '#198754');
                }
            });

            $('#passwordInp').blur(function() {
                var password = $(this).val();
                var confirmPassword = $('#confirmPasswordInp').val();

                if (password != confirmPassword) {
                    $('#confirmPasswordInp-message').html('Passwords do not match');
                    $('#confirmPasswordInp-message').css('color', '#dc3545');
                } else {
                    $('#confirmPasswordInp-message').html('Passwords match');
                    $('#confirmPasswordInp-message').css('color', '#198754');
                }
                
            });
        });
    </script>
</html>