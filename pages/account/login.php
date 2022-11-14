<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../styles/login.css" />
    <title>Document</title>
</head>

<body>
    <?php
    // require '../../connection/connection.php';
    // include '../../connection/connection.php';
    include($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/connection/connection.php');
    include($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/DAO/ClientDAO.php');

    // $con = new Connection();
    // $conn = $con->connect();
    if (isset($_POST['loginBtn'])) 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        ClientDAO::validAccess($username, $password);
        // $check = mysqli_query($conn, "SELECT * FROM client WHERE Username LIKE '%$username%'");
        // if (mysqli_num_rows($check) > 0) {
        //   while ($row = mysqli_fetch_array($check)) {
        //     $pwd = $row['Password'];
        //     $tin = $row['TIN'];
        //   }
        //   if (password_verify($password, $pwd)) {
        //     session_start();
        //     $_SESSION['tin'] = $tin;
        //     $_SESSION['auth'] = 1;
        //     echo "<script>localStorage.setItem('auth', 1); </script>";
        //     echo "<script> window.location = '../../index.php'; </script>";
        //   } else
        //     echo "<script>alert('Username or password incorret!')</script>";
        // } else
        //   echo "<script>alert('Username or password incorret!')</script>";
    }
    ?>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">
                                    Please enter your login and password!
                                </p>
                                <form action="" method="POST">
                                    <div class="form-outline form-white mb-4">
                                        <input value="<?php echo (isset($username)) ? $username : '' ?>" name="username" type="text" id="typeEmailX" class="form-control form-control-lg username" />
                                        <label class="form-label" for="typeEmailX">Username</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input value="<?php echo (isset($password)) ? $password : '' ?>" name="password" type="password" id="typePasswordX" class="form-control form-control-lg password" />
                                        <label class="form-label" for="typePasswordX">Password</label>
                                    </div>

                                    <!-- <p class="small mb-5 pb-lg-2">
                    <a class="text-white-50" href="#!">Forgot password?</a>
                  </p> -->

                                    <button name="loginBtn" class="btn btn-primary btn-lg" type="submit">
                                        Login
                                    </button>
                                </form>
                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                </div>
                            </div>

                            <div>
                                <p class="mb-0">
                                    Don't have an account?
                                    <a href="./register.php" class="text-white-50 fw-bold">Sign Up</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="login.js"></script>
</body>

</html>