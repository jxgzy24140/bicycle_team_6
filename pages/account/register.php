<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <title>Document</title>
</head>

<body>
    <?php
    include ($_SERVER["DOCUMENT_ROOT"].'/rent_bicycle/connection/connection.php');
    include ($_SERVER["DOCUMENT_ROOT"].'/rent_bicycle/DAO/ClientDAO.php');
    include ('functionHelper.php');
    
    if (isset($_POST['addBtn'])) {
        
        $password = (isset($_POST['password']) ? $_POST['password'] : '');
        $rpassword = (isset($_POST['rpassword']) ? $_POST['rpassword'] : '');

        if(!recheckPassword($password, $rpassword))
        {
            echo "<script>alert('Repeat-password not match!');history.back()</script>";
            return ;
        }
        
        
        $data = array(
            "TIN" => $_POST['tin'],
            "Address" => isset($_POST['address']) ? $_POST['address'] : '',
            "Name" => $_POST['name'],
            "NIN" => isset($_POST['nin']) ? $_POST['nin'] : '',
            "Username" => $_POST['username'],
            "Password" => password_hash($password, PASSWORD_DEFAULT)
        );
        $client = new Client($data);
        $clientDAO = new ClientDAO($client);
        if(ClientDAO::isExistUsername($client))
        {
            echo "<script>alert('The user has already used');history.back();</script>";
            return ;
        }
        if($clientDAO->insertClient())
        {
            echo "<script>window.location = 'login.php'</script>";
        }
        
       
    }
    ?>
    <section class="vh-100" style="background-color: #eee">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">
                                        Sign up
                                    </p>
                                    <form method="POST" class="mx-1 mx-md-4">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input value="<?php echo (isset($tin)) ? $tin : '' ?>" type="text" id="form3Example1c" class="form-control " name="tin" required />
                                                <label class="form-label" for="form3Example1c">TIN</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input value="<?php echo (isset($username)) ? $username : '' ?>" type="text" id="form3Example1c" class="form-control " name="username" required />
                                                <label class="form-label" for="form3Example1c">Username</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input value="<?php echo (isset($password)) ? $password : '' ?>" type="password" id="form3Example4c" class="form-control password" name="password" />
                                                <label class="form-label" for="form3Example4c">Password</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input value="<?php echo (isset($rpassword)) ? $rpassword : '' ?>" type="password" id="form3Example4cd" class="form-control rpassword" name="rpassword" />
                                                <label class="form-label" for="form3Example4cd">Repeat your password</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input value="<?php echo (isset($nin)) ? $nin : '' ?>" type="text" id="form3Example1c" class="form-control " name="nin" />
                                                <label class="form-label" for="form3Example1c">NIN</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input value="<?php echo (isset($name)) ? $name : '' ?>" type="text" id="form3Example1c" class="form-control " name="name" required />
                                                <label class="form-label" for="form3Example1c">Name</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input value="<?php echo (isset($address)) ? $address : '' ?>" type="text" id="form3Example1c" class="form-control " name="address" />
                                                <label class="form-label" for="form3Example1c">Address</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button name="addBtn" type="submit" class="btn btn-primary btn-lg">
                                                Register
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" alt="Sample image" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="register.js"></script>
</body>

</html>