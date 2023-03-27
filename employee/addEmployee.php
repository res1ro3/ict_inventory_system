<?php 
    require_once('../dbConfig.php');

    // if (isset($_POST['addAccBtn'])) {
    //     $lname = $_POST['lnameInp'];
    //     $fname = $_POST['fnameInp'];
    //     $username = $_POST['usernameInp'];
    //     $password = $_POST['passwordInp'];


    //     $sql="INSERT INTO user(name,email,mobile) VALUES(:name,:email,:mobile)";
    //     $query = $conn->prepare($sql);

    //     $query->bindParam(':name',$name,PDO::PARAM_STR);
    //     $query->bindParam(':email',$email,PDO::PARAM_STR);
    //     $query->bindParam(':mobile',$mobile,PDO::PARAM_STR);

    //     $query->execute();

    //     $lastInsertId = $conn->lastInsertId();
    //     if($lastInsertId) {
    //         // Message for successfull insertion
    //         echo "<script>alert('Record inserted successfully');</script>";
    //         echo "<script>window.location.href='index.php'</script>";
    //     }
    //     else {
    //         // Message for unsuccessfull insertion
    //         echo "<script>alert('Something went wrong. Please try again');</script>";
    //         echo "<script>window.location.href='index.php'</script>";
    //     }
    // }
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
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="addAccDiv" style="width: 50%">
            <form class="needs-validation" novalidate id="addAccForm" name="addAccForm" method="post">
                <h3 class="text-center mt-5 mb-3">ADD ACCOUNT</h3>
                <div class="mb-3 row">
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control addAccInp" id="lnameInp" name="lnameInp" placeholder="Dela Cruz" required>
                        <label for="lnameInp" class="form-label ps-4" id="lnameLbl">Last Name</label>
                        <div class="invalid-feedback">
                            Please enter Last Name
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control addAccInp" id="fnameInp" name="fnameInp" placeholder="Juan" required>
                        <label for="fnameInp" class="form-label ps-4" id="fnameLbl">First Name</label>
                        <div class="invalid-feedback">
                            Please enter First Name
                        </div>
                    </div>
                </div>
                
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control addAccInp" id="usernameInp" name="usernameInp" placeholder="Juan234" required>
                    <label for="usernameInp" class="form-label" id="usernameLbl">Username</label>
                    <div class="invalid-feedback">
                        Please enter Username
                    </div>   
                </div>

                <div class="mb-3 row">
                    <div class="mb-3 col form-floating">
                        <input type="password" class="form-control addAccInp" id="passwordInp" name="passwordInp" placeholder="********" required>
                        <label for="passwordInp" class="form-label ps-4" id="passwordLbl">Password</label>
                        <div class="invalid-feedback">
                            Please enter Password
                        </div>
                    </div>
                    <div class="mb-3 col form-floating">
                        <input type="password" class="form-control addAccInp" id="confirmPasswordInp" name="confirmPasswordInp" placeholder="********" required>
                        <label for="confirmPasswordInp" class="form-label ps-4" id="confirmPasswordLbl">Confirm Password</label>
                        <div class="invalid-feedback">
                            Please Confirm Password
                        </div>
                    </div>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="officeInp" required>
                        <option value="0" selected>Select Office</option>
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
                        <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->name);?></option>
                    <?php }} ?>
                    </select>
                    <label for="officeInp" id="officeLbl">Office</label>
                    <div class="invalid-feedback">
                        Please select an Office
                    </div>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="positionInp" required>
                        <option value="0" selected>Select Position</option>
                        <option value="1">Position 1</option>
                        <option value="2">Position 2</option>
                        <option value="3">Position 3</option>
                    </select>
                    <label for="positionInp" id="positionLbl">Position</label>
                    <div class="invalid-feedback">
                        Please select a Position
                    </div>
                </div>

                <div class="mb-3">
                    <label for="typeOfEmploymentInp" id="typeOfEmploymentLbl" class="form-label">Type of Employment</label>
                    <select class="form-select" id="typeOfEmploymentInp" required>
                        <option value="0" selected disabled>Select Type of Employment</option>
                        <option value="1">Type of Employment 1</option>
                        <option value="2">Type of Employment 2</option>
                        <option value="3">Type of Employment 3</option>
                    </select>
                    
                    <div class="invalid-feedback">
                        Please select Type of Employment
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="validationCustom04" class="form-label">State</label>
                    <select class="form-select" id="validationCustom04" required>
                        <option selected disabled value="">Choose...</option>
                        <option>...</option>
                    </select>
                    <div class="invalid-feedback">
                    Please select a valid state.
                    </div>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="typeOfAccounttInp" required>
                        <option value="0" selected>Select Type of Account</option>
                        <option value="1">Admin</option>
                        <option value="2">Ordinary User</option>
                    </select>
                    <label for="typeOfAccounttInp" id="typeOfAccounttLbl">Type of Account</label>
                    <div class="invalid-feedback">
                        Please select Type of Account
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success" id="addAccBtn" name="addAccBtn">ADD</button>
                </div>
            </form>
        </div>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6952492a89.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
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
        })()

        function isBlank (inp) {
            
        }

        $(document).ready(function () {
            // $('#addAccBtn').click( function (e){
            //     e.preventDefault();

            //     var inputs = ['#lnameInp', '#fnameInp', '#usernameInp', '#passwordInp', '#confirmPasswordInp', '#officeInp', '#positionInp', '#typeOfEmploymentInp', '#typeOfAccounttInp'];
            //     var labels = ['#lnameLbl', '#fnameLbl', '#usernameLbl', '#passwordLbl', '#confirmPasswordLbl', '#officeLbl', '#positionLbl', '#typeOfEmploymentLbl', '#typeOfAccounttLbl'];

            //     for (var i = 0; i < inputs.length; i++) {
            //         if ($(inputs[i]).val() === '') {
            //             alert('Please enter ' + $(labels[i]).text());
            //             return;
            //         }
            //     }
            // })

            $('.addAccInp').focusout(function(){
                console.log($(this)[0].id);
                
            });
        });
    </script>
</html>