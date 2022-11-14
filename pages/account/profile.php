<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../styles/profile.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
</head>

<body>
  <?php
  // require '../../connection/connection.php';
  session_start();
  include '../../connection/connection.php';
  $con = new Connection();
  $conn = $con->connect();
  $tin = $_SESSION['tin'];
  $reservation = mysqli_query($conn, "SELECT * FROM `reservation` WHERE `TIN` = '$tin'");
  if (isset($_POST['logout'])) {
    echo "<script>window.location = '../../index.php'</script>";
    session_destroy();
  }
  ?>
  <div class="container">
    <div id="header">
      <div class="header__container">
        <div class="logo">
          <img src="../../assets/logo" alt="" style="width: 50px" />
        </div>
        <div class="navigation">
          <li><a href="">HOME</a></li>
          <li><a href="">BIKE</a></li>
          <li><a href="">ABOUT</a></li>
          <li><a href="">CONTACT</a></li>
          <li class="profile <?php if(isset($_SESSION['auth']) && $_SESSION['auth']==1) {echo "show";}else{echo "hide";} ?>"> 
            <a href="" class="user-icon"><i class="fa-solid fa-user"></i></a>
          </li>
          <li class="cart <?php if(isset($_SESSION['auth']) && $_SESSION['auth']==1) {echo "show";}else{echo "hide";} ?>">
            <a href="../cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
          </li>
        </div>
      </div>
    </div>
    <div id="content">
      <div class="content__container">
        <?php if(isset($reservation) && mysqli_num_rows($reservation) > 0) { ?>
        <div class="revervation">
          <table class="table" style="width: 100%; text-align:center; margin-top: 10px">
            <thead>
              <tr>
                <th scope="col">Reservation ID</th>
                <th scope="col">Name Store</th>
                <th scope="col">Time</th>
                <th scope="col">Detail</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = mysqli_fetch_array($reservation)) { ?>
                <tr>
                  <td><?php echo $row['ID'] ?></td>
                  <td><?php echo $row['Name_Store'] ?></td>
                  <td><?php echo $row['Time'] ?></td>
                  <td>
                  <a href="../reservation/reservation.php?id=<?php echo $row['ID'] ?>"><i class="fa-thin fa-info"></i></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        </div>
      </div>
      <?php } else { ?>
        
        <?php } ?>
      <div class="logout">
        <form action="" method="POST">
          <button name="logout">LOG OUT</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>