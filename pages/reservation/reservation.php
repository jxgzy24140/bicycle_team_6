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
    $id = (isset($_GET['id'])) ? $_GET['id'] : '';
    $reservation = mysqli_query($conn, "SELECT * FROM `reservation_bicyclemodel` WHERE `ID` = '$id'");
    if(isset($_POST['rmv-btn'])) {
        $bike = mysqli_query($conn, "SELECT * FROM reservation_bicycle WHERE ID = '$id'"); 
        while($row = mysqli_fetch_array($bike)) {
            $IdentifyNum = $row['IdentifyNumber'];
            $result = mysqli_query($conn, "UPDATE bicycle SET bicycle.Status = '1' WHERE bicycle.IdentifyNumber = '$IdentifyNum'");
        }
        $delete_reservation_bicycle = mysqli_query($conn, "DELETE FROM reservation_bicycle WHERE ID = '$id' ");
        $delete_reservation_bicyclemodel = mysqli_query($conn, "DELETE FROM reservation_bicyclemodel WHERE ID = '$id' ");
        $delete_reservation = mysqli_query($conn, "DELETE FROM reservation WHERE ID = '$id' ");
        //$result = mysqli_query($conn, "UPDATE bicycle SET bicycle.Status = '1' WHERE bicycle.IdentifyNumber = '$IdentifyNumber'");
        if($delete_reservation_bicyclemodel && $delete_reservation_bicycle && $delete_reservation) {
            echo "<script>alert('Removed'); window.location = '../account/profile.php?tin=$tin';</script>;";    
        }
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
                    <li>
                        <a href="" class="user-icon"><i class="fa-solid fa-user"></i></a>
                    </li>
                </div>
            </div>
        </div>
        <div id="content">
            <div class="content__container">
                <div class="revervation">
                    <?php if (isset($reservation) && mysqli_num_rows($reservation) > 0) { ?>
                        <table class="table" style="width: 100%; text-align:center; margin-top: 10px">
                            <thead>
                                <tr>
                                    <th scope="col">Name Bicycle</th>
                                    <td scope="col">Type</td>
                                    <td scope="col">Gear</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_array($reservation)) { ?>
                                    <tr>
                                        <td><?php echo $row['Name_BicycleModel'] ?></td>
                                        <td>
                                            <?php
                                            $name = $row['Name_BicycleModel'];
                                            $bike = mysqli_query($conn, "SELECT * FROM bicyclemodel WHERE UniqueName = '$name'");
                                            while($row=mysqli_fetch_array($bike)) {
                                                echo $row['Type'];
                                            }
                                            ?>
                                        </td>
                                        <td>
                                        <?php
                                            $bike = mysqli_query($conn, "SELECT * FROM bicyclemodel WHERE UniqueName = '$name'");
                                            while($row=mysqli_fetch_array($bike)) {
                                                echo $row['Gear'];
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="cancel" style="margin-top: 20px" onSubmit="if(!confirm('Delete This Reservation ?')){return false;}">
                            <form action="" method="POST">
               
                                <button type="submit" name="rmv-btn">CANCEL THIS RESERVATION</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>