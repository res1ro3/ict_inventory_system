<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/admin-signin.css">
</head>
<body>
    <div class="signin">
        <div id="nav-placeholder"></div>
        <div>
            <form onsubmit="handleSubmit(e)" class="needs-validation signin-form" novalidate method="post">
                <p class="fs-3 my-3">Sign In</p>
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="emailInp" name="emailInp" required autocomplete="TRUE">
                    <label for="emailInp" class="form-label">Email Address</label>
                    <div class="invalid-feedback">
                        Please enter Email address
                    </div>
                </div>
                <div class="mb-3 form-floating">
                    <input type="password" class="form-control" id="passInp" name="passInp" required autocomplete="TRUE">
                    <label for="passInp" class="form-label">Password</label>
                    <div class="invalid-feedback">
                        Please enter Password
                    </div>
                    <p class="btnshowpass" onclick="handleShowpass()">Show</p>
                </div>
                <button type="submit" class="btn btn-primary ">Signin</button>
            </form>
        </div>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
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
        })();

        function handleShowpass() {
            passVal = document.getElementById('passInp').type;
            if (passVal == 'text') {
                document.getElementById('passInp').type = 'password';
            } else {
                document.getElementById('passInp').type = 'text';
            }
        }

        const handleSubmit = (e) => {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "./submit-signin.php",
                data: {
                    employee_id: $("#employeeId").val(),
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

        $(document).ready(function() {
            $("#nav-placeholder").load("../nav.html");
        })
    </script>
</html>