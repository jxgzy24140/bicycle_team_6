<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./styles/home.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
</head>

<body>

  <?php
  // require './connection/connection.php';
  include './connection/connection.php';
  $con = new Connection();
  $conn = $con->connect();
  session_start();
  date_default_timezone_set('Asia/Ho_Chi_Minh');
  if (isset($_POST['addBtn'])) {
    $location = (isset($_POST['location'])) ? $_POST['location'] : '';
    // $_SESSION['location'] = $_POST['location'];
    // echo "<script>window.location ='pages/bike/bike.php'</script>";
    if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
      echo "<script>window.location = 'pages/bike/bike.php?l=$location'</script>";
    } else {
      if(!empty($location)) {
        $_SESSION['location'] = $location;
      }
      echo "<script>window.location = './pages/account/login.php';</script>";
    }
    // if ($auth == 1) {
    //   $date = $_POST['pickupDate'];
    //   $name_store_run = mysqli_query($conn, "SELECT UniqueName FROM store WHERE Address LIKE '%$location%'");
    //   while ($row = mysqli_fetch_array($name_store_run)) {
    //     $name_store = $row['UniqueName'];
    //   }
    //   $result = mysqli_query($conn, "INSERT INTO reservation(TIN,Name_Store,Time) VALUES ('$tin','$name_store','$date')");
    // } else {
    //   echo "<script>window.location = './pages/account/login.php';</script>";
    // }
  }
  ?>
  <div class="container">
    <div id="header">
      <div class="header__container">
        <div class="logo">
          <img src="./assets/logo" alt="" style="width: 50px" />
        </div>
        <div class="navigation">

          <li><a href="">HOME</a></li>
          <li><a href="./pages/bike/bike.php">BIKE</a></li>
          <li><a href="">ABOUT</a></li>
          <li><a href="">CONTACT</a></li>
          <li class="profile <?php if(isset($_SESSION['auth']) && $_SESSION['auth']==1) {echo "show";}else{echo "hide";} ?>">
            <a href="./pages/account/profile.php" class="user-icon"><i class="fa-solid fa-user"></i></a>
          </li>
          <li class="cart <?php if(isset($_SESSION['auth']) && $_SESSION['auth']==1) {echo "show";}else{echo "hide";} ?>">
            <a href="./pages/cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
          </li>
          <li class="login <?php if(isset($_SESSION['auth']) && $_SESSION['auth']==1) {echo "hide";}else{echo "show";} ?>">
            <a href="./pages/account/login.php">LOGIN</a>
          </li>
        </div>
      </div>
    </div>
    <div id="main">
      <div class="main__left">
        <form method="POST" action="" class="inputForm">
          <div class="form-group">
            <label for="location">PICK-UP LOCATION</label>
            <select class="location" name="location" id="location" value="123">
              <option disabled checked="true" selected>
                --CHOOSE LOCATION STORE--
              </option>
              <?php
              $store = mysqli_query($conn, "SELECT * FROM store");
              while ($row = mysqli_fetch_array($store)) {
                if (isset($_SESSION['location']) && !empty($_SESSION['location'])) { ?>
                  <option selected="selected" value="<?php echo $_SESSION['location'] ?>"><?php echo $row['Address'] ?></option>
                <?php } else { ?>
                  <option value="<?php echo $row['Address'] ?>"><?php echo $row['Address'] ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <!-- <div class="form-group">
            <label for="location">PICK-UP LOCATION</label>
            <select class="location" name="location" id="location" value="123">
              <option disabled checked="true" selected>
                --CHOOSE LOCATION STORE--
              </option>
              <?php while ($row = mysqli_fetch_array($store)) {
                if (strcmp($row['Address'], $location) == 0) { ?>
                  <option selected="selected" value="<?php echo $row['Address'] ?>"><?php echo $row['Address'] ?></option>
                <?php } else { ?>
                  <option value="<?php echo $row['Address'] ?>"><?php echo $row['Address'] ?></option>
              <?php }
              } ?>
            </select>
          </div> -->
          <!-- <div class="form-group">
            <label for="start">PICK-UP DATE</label>
            <input class="startDate" type="date" name="pickupDate" />
          </div>
          <div class="form-group">
            <label for="type">CHOOSE BICYCLE TYPE</label>
            <?php if (isset($type) && mysqli_num_rows($type) > 0) { ?>
              <select class="type" name="type" id="" name="" id="">
                <?php while ($row = mysqli_fetch_array($type)) { ?>
                  <option value="echo $row['Type']"><?php echo $row['Type']; ?> (<?php echo $row['Quantity'] ?>)</option>
                <?php } ?>
              </select>
            <?php } else { ?>
              <select class="type" name="type" id="">
                <option disabled checked="true" selected>
                  --NONE--
                </option>
              </select>
            <?php } ?>
          </div> -->
          <button name="addBtn" type="submit" class="book-btn">BOOK NOW!</button>
        </form>
      </div>
      <div class="main__right">
        <h2 class="title">BOOK A BICYCLE TODAY!</h2>
        <p class="desc">WITH 15% DISCOUNT FOR NEW CUSTOMER</p>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    // const auth = localStorage.getItem('auth') ?? ''
    // console.log(auth);
    // if (auth == 1) {
    //   const profileElement = document.querySelector(".profile");
    //   profileElement.classList.remove("hide");
    //   profileElement.classList.add("show");
    //   const cartElement = document.querySelector(".cart");
    //   cartElement.classList.remove("hide");
    //   cartElement.classList.add("show");
    // }
    // document.getElementById('location').onchange = function() {
    //   window.location = "pages/bike.php?location=" + this.value;
    // };
  </script>
</body>

</html>