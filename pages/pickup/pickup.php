<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        min-height: 100vh;
        width: 100%;
        position: relative;
    }

    .container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #ccc;
        height: 100%;
        width: 100%;
    }

    .header {
        text-align: center;
        padding: 10px;
    }

    .content {
        text-align: center;
    }

    .form-group {
        margin-top: 20px;
        padding: 10px;
    }
</style>

<body>
    <?php
    include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/Models/BicycleModel.php');
    include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/connection/Connector.php');
    $conn = Connector::Connect();
    if (isset($_GET['submit-btn'])) {
        $id = $_GET['id'];
        $stmt = mysqli_query($conn, "SELECT * FROM reservation  WHERE ID = '$id'");
        $listBicycle = mysqli_query($conn, "SELECT reservation_bicycle.IdentifyNumber, bicycle.UniqueName FROM reservation_bicycle INNER JOIN bicycle ON reservation_bicycle.IdentifyNumber = bicycle.IdentifyNumber WHERE reservation_bicycle.ID = '$id'");
        if (mysqli_num_rows($stmt) == 0) {
            echo "<script>alert('This reservation not exist!')</script>";
        }
        $check = mysqli_query($conn, "SELECT * FROM return_infor WHERE ID = '$id'");
        $check2 = mysqli_query($conn, "SELECT * FROM pickup_infor WHERE ID = '$id'");
    }

    ?>
    <div class="container">
        <div class="header">
            <form action="" method="GET" id="search-form">
                <input type="text" placeholder="Enter reservation id" name="id" value="<?php echo (!empty($id)) ? $id : '' ?>">
                <input type="submit" value="Search...." name="submit-btn">
            </form>
        </div>
        <?php if (isset($stmt) && mysqli_num_rows($stmt) > 0) { ?>
            <div class="content">
                <form action="./process.php" method="GET " onSubmit="if(!confirm('Is correctly ?')){return false;}">
                    <div class="infor">
                        <?php while ($row = mysqli_fetch_array($stmt)) { ?>
                            <p class="tile">ID: <?php echo $row['ID'] ?></p>
                            <input type="text" name="id" style="display: none" value="<?php echo $row['ID'] ?>">
                            <p class="tile">TIN: <?php echo $row['TIN'] ?></p>
                            <p class="tile">Store: <?php echo $row['Name_Store'] ?></p>
                            <!-- <p class="tile">Pickup time: <?php echo $row['Time'] ?></p> -->
                            <label for="">Pickup Date: </label>
                            <input type="date" name="pickup" disabled value="<?php echo $row['Time']; ?>">
                            <br>
                            <label for="">Return Date: </label>
                            <input type="date" name="return" disabled value="<?php $Date = $row['Time'];
                                                                                $days = $row['days_to_rent'];
                                                                                echo date('Y-m-d', strtotime($Date . '+' . $days . ' days')); ?>">
                            <input style="display: none" class="days-to-rent" value="<?php echo $row['days_to_rent'] ?>">
                            <div class="total-price">
                                Total: <span class="price"></span> VND
                            </div>
                            <input name="date" type="text" style="display: none" value ="<?php $Date = $row['Time'];
                                                                                $days = $row['days_to_rent'];
                                                                                echo date('Y-m-d', strtotime($Date . '+' . $days . ' days')); ?>">
                        <?php } ?>
                    </div>
                    <?php while ($row = mysqli_fetch_array($listBicycle)) { ?>
                        <div class="form-group">
                            <label for="">Model: <?php echo $row['UniqueName'] ?></label>
                            <label class="bikes" for="">ID: <?php echo $row['IdentifyNumber'] ?></label>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                            <input type="submit" name="submit-pickup" value="Confirm">
                            <!-- <?php if (isset($check) && mysqli_num_rows($check) > 0 || isset($check2) && mysqli_num_rows($check2) > 0) {echo "disabled";} ?> -->
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
    <script>
        const listBike = document.querySelectorAll('.bikes')
        const days = document.querySelector('.days-to-rent')
        const showPrice = document.querySelector('.price').innerHTML = days.value * listBike.length * 100000
    </script>
</body>

</html>