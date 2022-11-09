<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../styles/detail.css" />
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
    $name = $_GET['name'];
    $bicycle = mysqli_query($conn, "SELECT * FROM bicyclemodel WHERE UniqueName ='$name'");
    $store = mysqli_query($conn, " SELECT DISTINCT store_bicyclemodel.Name_Store, store.Address FROM store_bicyclemodel, store, store_bicycle WHERE store_bicyclemodel.Name_BicycleModel = '$name' AND store_bicyclemodel.Name_Store = store.UniqueName AND store_bicyclemodel.Name_Store = store_bicycle.Name_Store;");
    if(isset($_POST['add'])) {
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        $_SESSION['cart'][$name] = 1;
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
                    <li><a href="./bike.php">BIKE</a></li>
                    <li><a href="">ABOUT</a></li>
                    <li><a href="">CONTACT</a></li>
                    <li>
                        <a href="" class="user-icon"><i class="fa-solid fa-user"></i></a>
                    </li>
                    <li>
                        <a href="../cart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                    </li>
                </div>
            </div>
        </div>
        <div id="content">
            <div class="content__container">
                <?php while ($card_row = mysqli_fetch_array($bicycle)) { ?>
                    <form action="" method="POST">
                    <div class="card">
                            <div class="card__left">
                                <div class="card__img">
                                    <img src="../../assets/homethumb.jpg" alt="">
                                </div>
                            </div>
                            <div class="card__right">
                                <div class="card__title">
                                    <h2>Name: <?php echo $card_row['UniqueName'] ?></h2>
                                    <p>Type: <?php echo $card_row['Type'] ?></p>
                                </div>
                                <div class="card__desc">
                                    <p class="desc__title">List store in stock</p>
                                    <div class="desc location">
                                        <ul>
                                            <?php while ($row = mysqli_fetch_array($store)) {
                                                $name_store = $row['Name_Store'];
                                                $query = "SELECT COUNT(bicycle.UniqueName) as quantity FROM bicycle INNER JOIN store_bicycle 
                                                ON bicycle.IdentifyNumber = store_bicycle.IdentifyNumber WHERE store_bicycle.Name_Store = '$name_store' 
                                                AND bicycle.UniqueName LIKE '%$name%' AND bicycle.Status = '1';";
                                                $quantity = mysqli_query($conn, $query);
                                                while($q = mysqli_fetch_array($quantity)) {
                                                    if($q['quantity'] != 0) {?>
                                                <li><?php  echo $row['Name_Store'];
                                                    echo "\x20", "- ";
                                                    echo $row['Address'] ?>
                                                    - Instock: <?php echo $q['quantity'] ?></li>
                                            <?php } } } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card__action">
                                    <button onclick="alert('Success')" type="submit" name="add" class="card__action--add">Add To Cart</button>
                                    <button type="submit" name="book" class="card__action--book">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function Test() {
            alert('Success!');
        }
    </script>
</body>

</html>