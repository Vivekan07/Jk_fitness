<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | JK Fitness</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
    .auth-bg {
        background-image: url('assets/images/qqq.png');
        background-size: cover;
        background-position: center;
    }
    .auth-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .btn-jk {
        background-color: #E31E24 !important;
        border-color: #E31E24 !important;
        color: #ffffff !important;
    }
    .btn-jk:hover {
        background-color: #c41920 !important;
        border-color: #c41920 !important;
    }
    .password-field {
        position: relative;
    }
    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
    }
    </style>
</head>

<body class="auth-bg">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card auth-card">
                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Welcome Admin!</h5>
                            <p class="text-muted">Sign in to continue to JK Fitness.</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form id="loginForm">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="password-field">
                                        <input type="password" class="form-control" name="password" id="password" required>
                                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                                    </div>
                                </div>

                                <div class="mt-3 d-grid">
                                    <button class="btn btn-jk waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        // Password visibility toggle
        $('#togglePassword').click(function() {
            const passwordField = $('#password');
            const icon = $(this);
            
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Login form submission
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'process_login.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    try {
                        const result = JSON.parse(response);
                        if (result.status === 'success') {
                            window.location.href = 'index.php';
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: result.message,
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An unexpected error occurred',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                }
            });
        });
    });
    </script>
</body>
</html> 