<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Vending Machine</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            /*background-color: orange;*/
            background-size: cover;
            background-position: center;
            /*background-repeat: no-repeat;*/
            /*font-family: Arial, sans-serif;*/
        }

		.password-container {
            position: relative; /* Mengatur posisi relatif untuk kontainer */
        }

        .password-container input {
            padding-right: 40px; /* Memberikan ruang untuk ikon di sebelah kanan */
        }

		.input-group {
			position: relative; /* Mengatur posisi relatif untuk mengatur ikon */
		}

		#togglePassword {
			position: absolute; /* Mengatur posisi absolut */
			right: 10px; /* Jarak dari sisi kanan */
			top: 50%; /* Menempatkan di tengah vertikal */
			transform: translateY(-50%); /* Mengatur ikon agar tepat di tengah */
			padding: 0; /* Menghapus padding */
		}
    </style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-gradient-primary" style="background-color: orange;">
<div class="container">

<!-- #e7dbeb -->
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5" style="">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">LOGIN</h1>
                                </div>

                                <!-- Pesan Error -->
                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger">
                                        <?= $this->session->flashdata('error'); ?>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" action="<?php echo base_url('login/index'); ?>" class="user">
                                    <div class="form-group mb-3">
                                        <label>Email</label>
                                        <input type="email" class="form-control form-control-user"
                                        id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="" name="email" required>
                                        <!--?php echo form_error('email', '<div class="text-danger small ml-2">','</div>'); ?-->
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Password</label>
                                        <div class="password-container">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="" name="password" required>
                                            <span id="togglePassword">
                                                <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                            </span>
                                        </div>
                                        <!--?php echo form_error('password', '<div class="text-danger small ml-2">','</div>'); ?-->
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-danger form-control">Sign In</button>
                                    </div>
                                </form>
                                
                                <!--hr>
                                <div class="text-center">
                                    Don't have an Account? <a class="small" href="">Sign up</a>
                                </div-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
        // Script untuk toggle visibility password
        var togglePassword = document.getElementById('togglePassword');
        var passwordInput = document.getElementById('exampleInputPassword');
        var eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            // Toggle antara password dan text
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle antara ikon mata terbuka dan tertutup
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>