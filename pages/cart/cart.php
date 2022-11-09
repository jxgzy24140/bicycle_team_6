<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../styles/cart.css" />
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body>
    <?php
    // require '../../connection/connection.php';
    include '../../connection/connection.php';
    $con = new Connection();
    $conn = $con->connect();
    session_start();
    $location = (isset($_SESSION['location'])) ? $_SESSION['location'] : '';
    //unset($_SESSION['reservation']);
    if(!empty($location) && isset($_SESSION['cart'])) {
        $name_store = mysqli_query($conn, "SELECT * FROM store WHERE Address LIKE '%$location%'");
        foreach ($_SESSION['cart'] as $key => $value) {
            while($row = mysqli_fetch_array($name_store)) { $UniqueNameStore = $row['UniqueName'];}
            $query = "SELECT COUNT(bicycle.IdentifyNumber) FROM store_bicycle 
            INNER JOIN bicycle ON store_bicycle.IdentifyNumber = bicycle.IdentifyNumber
            AND store_bicycle.Name_Store = '$UniqueNameStore' AND bicycle.Status = '1' 
            AND bicycle.UniqueName LIKE '%$key%'";
            if(!isset($_SESSION['reservation'])) {
            $_SESSION['reservation'] = array();
            }
            $result = mysqli_query($conn, $query);
            while($result_row = mysqli_fetch_array($result)) { $count = $result_row['COUNT(bicycle.IdentifyNumber)']; }
            if($count !=0  ) {
                $_SESSION['reservation'][$key] = $key;
            } else {
                unset($_SESSION['reservation'][$key]);
            }
        }
    }
    if (isset($_SESSION['cart'])) {
        if (isset($_GET['remove'])) {
            $key = $_GET['sessionKey'];
            unset($_SESSION['cart'][$key]);
            unset($_SESSION['reservation'][$key]);
            echo "<script>window.location = 'cart.php'</script>";
        }
    }
    
        ?>
    <div class="container">
        <div class="cart__container">
            <div id="header">
                <div class="header__container">
                    <div class="logo">
                        <img src="../../assets/logo" alt="" style="width: 50px" />
                    </div>
                    <div class="navigation">
                        <li><a href="">HOME</a></li>
                        <li><a href="../bike/bike.php?l=<?php echo $_SESSION['location'] ?>">BIKE</a></li>
                        <li><a href="">ABOUT</a></li>
                        <li><a href="">CONTACT</a></li>
                        <li class="profile <?php if(isset($_SESSION['auth']) && $_SESSION['auth']==1) {echo "show";}else{echo "hide";} ?>">
                            <a href="../account/profile.php?tin=<?php if (isset($_SESSION['tin']) && $_SESSION['auth'] == 1) echo $_SESSION['tin'] ?>" class="user-icon"><i class="fa-solid fa-user"></i></a>
                        </li>
                        <li class="cart <?php if(isset($_SESSION['auth']) && $_SESSION['auth']==1) {echo "show";}else{echo "hide";} ?>">
                            <a href=""><i class="fa-solid fa-cart-shopping"></i></a>
                        </li>
                    </div>
                </div>
            </div>
            <div id="content">
                <div class="content__container">
                    <h2 style="padding-bottom: 20px">Your Cart</h2>
                    <p>PICK-UP LOCATION: <?php echo $_SESSION['location'] ?></p>
                    <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
                        <form id="cart-form" method="POST" action="./reservation.php">
                            <table class="table" style="width: 100%; text-align:center; margin-top: 10px">
                                <thead>
                                    <tr>
                                        <th scope="col">Bicycle's Name</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Gear</th>
                                        <th scope="col">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($_SESSION['cart'] as $key => $value) {
                                        $bicycle = mysqli_query($conn, "SELECT * FROM bicyclemodel WHERE UniqueName Like '%$key%'"); //get bike like name từ session
                                        while ($row = mysqli_fetch_array($bicycle)) {
                                            $bike = $row['UniqueName']; $location = $_SESSION['location'] ?>
                                            <tr>
                                                <input id="bike" type="text" style="display: none" value="<?php echo $bike; ?>">
                                                <td><?php echo $row['UniqueName'] ?></td>
                                                <td><?php echo $row['Type'] ?></td>
                                                <td><?php echo $row['Gear'] ?></td>
                                                <td>
                                                    <input
                                                     name="<?php
                                                      while($row = mysqli_fetch_array($name_store)) { $UniqueNameStore = $row['UniqueName'];}
                                                      $query = "SELECT COUNT(bicycle.IdentifyNumber) FROM store_bicycle 
                                                      INNER JOIN bicycle ON store_bicycle.IdentifyNumber = bicycle.IdentifyNumber
                                                      AND store_bicycle.Name_Store = '$UniqueNameStore' AND bicycle.Status = '1' 
                                                      AND bicycle.UniqueName LIKE '%$key%'";
                                                      $result = mysqli_query($conn, $query);
                                                      while($result_row = mysqli_fetch_array($result)) { $count = $result_row['COUNT(bicycle.IdentifyNumber)']; }
                                                      if($count > 0) {
                                                          echo $key;
                                                    }
                                                      ?>"  
                                                     <?php if (isset($location)) {
                                                        $name_store = mysqli_query($conn, "SELECT UniqueName FROM store WHERE Address LIKE '%$location%'");
                                                        while($name_store_row = mysqli_fetch_array($name_store)) {$UniqueNameStore = $name_store_row['UniqueName'];}
                                                        $max_run = mysqli_query($conn, "SELECT COUNT(bicycle.IdentifyNumber) FROM store_bicycle 
                                                        INNER JOIN bicycle ON store_bicycle.IdentifyNumber = bicycle.IdentifyNumber
                                                        AND store_bicycle.Name_Store = '$UniqueNameStore' AND bicycle.Status = '1' 
                                                        AND bicycle.UniqueName LIKE '%$bike%';");
                                                        while ($max = mysqli_fetch_array($max_run)) { $max_value = $max['COUNT(bicycle.IdentifyNumber)']; }
                                                        if($max_value != 0) { 
                                                            echo $max_value;
                                                            ?> type="number" value="1" min="1" max="<?php echo $max_value ?>"<?php
                                                        } else {
                                                            ?> type="text" value="This product is not available here" disabled <?php
                                                        }
                                                        } ?> />
                                                </td>
                                                <td>
                                                    <input name="sessionKey" type="text" value="<?php echo $key ?>" style="display: none" />
                                                    <a href="./delete.php?name=<?php echo $bike ?>" style="border: 1px solid;color: black;text-decoration: none;padding: 2px 4px;background-color: white;cursor: pointer;">Delete</a>
                                                </td>
                                                </tr>
                                    <?php } }  ?>
                                </tbody>
                            </table>
                            <div>
                                <input type="submit" name="submit-cart" class="book-btn" value="Make Reservation" />
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</body>

</html>