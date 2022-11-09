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
    include '../../connection/connection.php';
    $con = new Connection();
    $conn = $con->connect();
    session_start();
    $tin = $_SESSION['tin'];
    $id = $_GET['id'];
    $reservation = mysqli_query($conn, "SELECT * FROM `reservation_bicyclemodel` WHERE `ID` = '$id'");
    $location_query = "SELECT DISTINCT Address FROM store JOIN reservation ON store.UniqueName = reservation.Name_Store AND reservation.ID = '$id'";
    $location = mysqli_query($conn, $location_query);
    while ($row = mysqli_fetch_array($location)) {
        $address = $row['Address'];
    }
    $query = "SELECT DISTINCT Name_BicycleModel FROM store_bicyclemodel 
    JOIN store_bicycle ON store_bicyclemodel.Name_Store = store_bicycle.Name_Store 
    JOIN store ON store_bicycle.Name_Store = store.UniqueName AND Address LIKE '%$address%'";
    $result = mysqli_query($conn, $query);
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
                    <li>
                        <a href="" class="user-icon"><i class="fa-solid fa-user"></i></a>
                    </li>
                </div>
            </div>
        </div>
        <div id="content">
            <div class="content__container">
                <div class="revervation_form">
                    <div class="form-group">
                        <label for="location">Choose bicycle model</label>
                        <select class="location" name="location" id="location" value="123">
                            <option checked="true" selected>--CHOOSE BICYCLE MODEL--</option>
                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                <option value=""><?php echo $row['Name_BicycleModel'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>