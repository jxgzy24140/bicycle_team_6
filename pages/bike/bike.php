<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../styles/bike.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    // require '../../connection/connection.php';
    /* include '../../connection/connection.php';
  $con = new Connection();
  $conn = $con->connect();
  $location = (isset($_GET['l'])) ? $_GET['l'] : '';
  if (isset($location) && !empty($location)) {
    if (isset($_SESSION['location'])) {
      unset($_SESSION['location']);
    }
    $_SESSION['location'] = $location;
  }
  if(isset($_SESSION['location']) && empty($_SESSION['location'])) {
    $temp = $_SESSION['location'];
    $bicycle = mysqli_query($conn, "SELECT DISTINCT bicycle.Status, bicyclemodel.UniqueName, bicyclemodel.image FROM bicyclemodel INNER JOIN bicycle ON bicycle.UniqueName = bicyclemodel.UniqueName INNER JOIN store_bicyclemodel ON bicyclemodel.UniqueName = store_bicyclemodel.Name_BicycleModel INNER JOIN store ON store_bicyclemodel.Name_Store = store.UniqueName AND store.Address LIKE '%$temp%' AND bicycle.Status = '1';");
  } else {
    $bicycle = mysqli_query($conn, "SELECT DISTINCT bicycle.Status, bicyclemodel.UniqueName, bicyclemodel.image FROM bicyclemodel INNER JOIN bicycle ON bicycle.UniqueName = bicyclemodel.UniqueName INNER JOIN store_bicyclemodel ON bicyclemodel.UniqueName = store_bicyclemodel.Name_BicycleModel INNER JOIN store ON store_bicyclemodel.Name_Store = store.UniqueName AND store.Address LIKE '%$location%' AND bicycle.Status = '1';");
  } */
    include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/DAO/StoreDAO.php');
    if(isset($_GET['l']))
    {
        $address = $_GET['l'];
        $_SESSION['location'] = $address;
        $store = StoreDAO::getStoreByAddress($address);
        $listBicycleModels = StoreDAO::getAllBicycleModelBelongToStore($store->address);

    }
    ?>
    <div class="container">
        <div id="header">
            <div class="header__container">
                <div class="logo">
                    <img src="../../assets/logo" alt="" style="width: 50px" />
                </div>
                <div class="navigation">
                    <li>
                        <p style="display: inline">Pick-up location: </p>
                        <select name="location" id="location" style="background-color: #0C0402; color: white; border: none">
                            <?php 
                            if (isset($_SESSION['location']) && !empty($_SESSION['location'])) { ?>
                                <option value="" selected><?php echo $_SESSION['location'] ?></option>
                            <?php } else { ?>
                                <option disabled selected value="">--CHOOSE PICK-UP LOCATION--</option>
                                <?php }
                            // $store = mysqli_query($conn, "SELECT * FROM store");
                            $listStores = StoreDAO::getAllStore();
                            foreach ($listStores as $store) {
                                if ($store->address != $_SESSION['location']) { ?>
                                    <option value="<?php echo $store->address ?>"><?php echo $store->address ?></option>
                            <?php }
                            } ?>
                        </select>
                    </li>
                    <li><a href="../../index.php">HOME</a></li>
                    <li><a href="">BIKE</a></li>
                    <li><a href="">ABOUT</a></li>
                    <li><a href="">CONTACT</a></li>
                    <li class="profile <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
                                            echo "show";
                                        } else {
                                            echo "hide";
                                        } ?>">
                        <a href="../account/profile.php?tin=<?php echo $_SESSION['tin'] ?>" class="user-icon"><i class="fa-solid fa-user"></i></a>
                    </li>
                    <li class="cart <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
                                        echo "show";
                                    } else {
                                        echo "hide";
                                    } ?>">
                        <a href="../cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                    </li>
                </div>
            </div>
        </div>
        <div id="main">
            <div class="main__container">
                <div class="filter">
                    <h1>Filter By:</h1>
                    <div class="categories">
                        <h2>Categories</h2>
                        <a href="">Road</a>
                        <a href="">Mountain</a>
                        <a href="">Comfort</a>
                    </div>
                </div>
                <?php if (isset($location) && !empty($location) || isset($_SESSION['location']) && !empty($_SESSION['location'])) { ?>
                    <div class="content">
                        <div class="content__product">
                            <?php foreach($listBicycleModels as $bicycleModel) { ?>
                                <div class="item item1">
                                    <div class="item__img">
                                        <a href="./detail.php?name=<?php echo $bicycleModel->uniqueName ?>">
                                            <img src="../../assets/homethumb.jpg" alt="" />
                                        </a>
                                        <a href="./detail.php?name=<?php echo $bicycleModel->uniqueName ?>" class="rentBtn">Rent Now</a>
                                    </div>
                                    <p class="title"><?php echo $bicycleModel->uniqueName ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <h2>YOU MUST SELECT PICK UP LOCATION</h2>
                <?php } ?>
            </div>
        </div>
        <!-- <div class="location">
      <div class="location__container">
        <div class="location">
          <select name="" id="" class="select-location">
            
          </select>
        </div>
      </div>
    </div> -->
        <!-- <script type="text/javascript">
      const auth = localStorage.getItem('auth') ?? ''
      if (auth == 1) {
        const profileElement = document.querySelector(".profile");
        profileElement.classList.remove("hide");
        profileElement.classList.add("show");
      }
    </script> -->
        <script>
            document.getElementById('location').onchange = function() {
                window.location = "bike.php?l=" + this.value;
            };
        </script>
</body>

</html>