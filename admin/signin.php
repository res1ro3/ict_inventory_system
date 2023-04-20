<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/admin-signin.css">
</head>
<body>
    <div class="signin d-flex align-items-center flex-column">
        <div id="nav-placeholder"></div>
        <form onsubmit="handleSignin(); return false" class="signin-form mt-5 w-50 needs-validation" novalidate>
            <h3 class="form-title">Sign in</h3>
            <div class="mb-3">
                <label class="form-label" for="usernameInp">Username</label>
                <input class="form-control" type="text" name="usernameInp" id="usernameInp" placeholder="juan2345678" required>
            </div>
            <label class="form-label" for="passwordInp">Password</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" name="passwordInp" id="passwordInp" placeholder="********" aria-label="Example text with button addon" aria-describedby="button-addon1" required autocomplete>
                <button onclick="showPass()" id='btn-show' class="btn btn-outline-secondary" type="button" id="button-addon1">Show</button>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary" type="submit">Signin</button>
            </div>
        </form>
        <button onclick="handleSignin()">TEST</button>
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
            $("#nav-placeholder").load("../nav.html");
        });

        function showPass() {
            btnType = document.getElementById("passwordInp").type;
            if (btnType == "password") {
                document.getElementById("passwordInp").type = "text";
            } else {
                document.getElementById("passwordInp").type = "password";
            }
        }

        function handleSignin() {
            $.ajax({
                    url: 'submit-signin.php',
                    method: 'POST',
                    data: {
                        username: document.getElementById("usernameInp").value,
                        password: document.getElementById("passwordInp").value,
                    }

                }).then((res) => {
                    console.log(res);
                });
        }

    </script>
</html>