<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Media Pembelajaran</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .center-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
            margin-bottom: -60px;
        }
        .center-logo img {
            max-width: 100%;
            height: auto;
            width: 420px; /* atau ukuran yang Anda inginkan */
        }
        @media (max-width: 768px) {
            .center-logo img {
                width: 80%; /* Sesuaikan ukuran gambar pada layar kecil */
            }
        }
    </style>

</head>
<body style="background-color: #23274D;">
    @include('sweetalert::alert')
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-9 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0" style="background-color: #ffffff;">
                        <!-- Nested Row within Card Body -->
                        <div class="row mx-auto">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 mb-4" style="font-size: 40px; color: #000; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Selamat Datang!</h1>
                                    </div>

                                    <form class="user" action="{{ route('login.submit') }}" method="POST">
                                        @csrf <!-- Include CSRF token -->
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="email"
                                                placeholder="enter email" required >
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" placeholder="enter password" required>
                                        </div>
                                        <button type="submit" class="btn-user btn-block mb-4" style="background-color: white; color: #23274D; font-size: 20px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif" align="center" >
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
   {{-- @include('layout.footer') --}}

   <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
   <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

   <!-- Core plugin JavaScript-->
   <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

   <!-- Custom scripts for all pages-->
   <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>

</html>
