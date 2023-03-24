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
            <form name="addAccForm" method="post">
                <h3 class="text-center mt-5 mb-3">ADD ACCOUNT</h3>
                <div class="mb-3 row">
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="lnameInp" name="lnameInp" placeholder="Dela Cruz">
                        <label for="lnameInp" class="form-label ps-4">Last Name</label>
                    </div>
                    <div class="mb-3 col form-floating">
                        <input type="text" class="form-control" id="fnameInp" name="fnameInp" placeholder="Juan">
                        <label for="fnameInp" class="form-label ps-4">First Name</label>
                    </div>
                </div>
                
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="usernameInp" name="usernameInp" placeholder="Juan234">
                    <label for="usernameInp" class="form-label">Username</label>
                </div>

                <div class="mb-3 row">
                    <div class="mb-3 col form-floating">
                        <input type="password" class="form-control" id="passwordInp" name="passwordInp" placeholder="********">
                        <label for="passwordInp" class="form-label ps-4">Password</label>
                    </div>
                    <div class="mb-3 col form-floating">
                        <input type="password" class="form-control" id="confirmPasswordInp" name="confirmPasswordInp" placeholder="********">
                        <label for="confirmPasswordInp" class="form-label ps-4">Confirm Password</label>
                    </div>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="officeInp">
                        <option selected>Select Office</option>
                        <option value="1">Office 1</option>
                        <option value="2">Office 2</option>
                        <option value="3">Office 3</option>
                    </select>
                    <label for="officeInp">Office</label>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="positionInp">
                        <option selected>Select Position</option>
                        <option value="1">Position 1</option>
                        <option value="2">Position 2</option>
                        <option value="3">Position 3</option>
                    </select>
                    <label for="positionInp">Position</label>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="typeOfEmploymentInp">
                        <option selected>Select Type of Employment</option>
                        <option value="1">Type of Employment 1</option>
                        <option value="2">Type of Employment 2</option>
                        <option value="3">Type of Employment 3</option>
                    </select>
                    <label for="typeOfEmploymentInp">Type of Employment</label>
                </div>

                <div class="mb-3 form-floating">
                    <select class="form-select" id="typeOfAccounttInp">
                        <option selected>Select Type of Account</option>
                        <option value="1">Type of Account 1</option>
                        <option value="2">Type of Account 2</option>
                        <option value="3">Type of Account 3</option>
                    </select>
                    <label for="typeOfAccounttInp">Type of Account</label>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success" name="addAccForm">ADD</button>
                </div>
            </form>
        </div>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6952492a89.js" crossorigin="anonymous"></script>
</html>