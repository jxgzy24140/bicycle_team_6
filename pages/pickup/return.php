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
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/Models/BicycleModel.php');
    include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/connection/Connector.php');
    $conn = Connector::Connect();
    if (isset($_GET['submit-btn'])) {
        $id = $_GET['id'];
        $listBicycle = mysqli_query($conn, "SELECT * FROM pickup_infor_bicycle INNER JOIN bicycle ON pickup_infor_bicycle.IdentifyNumber = bicycle.IdentifyNumber WHERE pickup_infor_bicycle.ID = '$id'");
        while($row = mysqli_fetch_array($listBicycle)) {
            $bike_id = $row['IdentifyNumber'];
        }
        $stmt = mysqli_query($conn, "SELECT DISTINCT store_bicycle.Name_Store FROM store_bicycle INNER JOIN pickup_infor_bicycle ON store_bicycle.IdentifyNumber = pickup_infor_bicycle.IdentifyNumber WHERE pickup_infor_bicycle.IdentifyNumber = '$bike_id';");
        if (mysqli_num_rows($stmt) == 0) {
            echo "<script>alert('This reservation not exist!')</script>";
        }
        $check = mysqli_query($conn, "SELECT * FROM return_infor WHERE ID = '$id'");
    }
    if (isset($_POST['submit-return'])) {
        $id = $_GET['id'];
        $date = date('d/m/y H:i:s');
        $user = mysqli_query($conn, "SELECT TIN FROM reservation WHERE ID = '$id'");
        while ($row = mysqli_fetch_array($user)) {
            $tin = $row['TIN'];
        }
        $result = mysqli_query($conn, "INSERT INTO return_infor (ID,TIN,Time) VALUES ('$id','$tin','$date')");
        while ($row = mysqli_fetch_array($listBicycle)) {
            $IdentifyNum = $row['IdentifyNumber'];
            $result2 = mysqli_query($conn, "INSERT INTO return_infor_bicycle (ID,IdentifyNumber) VALUES ('$id','$IdentifyNum')");
            $update = mysqli_query($conn, "UPDATE bicycle SET Status = '1' WHERE IdentifyNumber = '$IdentifyNum'");
        }
        echo "<script>alert('Return Success')</script>";
    }
    ?>
    <div class="container">
        <div class="header">
            <form action="" method="GET">
                <input type="text" placeholder="Enter reservation id" name="id" value="<?php echo (!empty($id)) ? $id : '' ?>">
                <input type="submit" value="Search...." name="submit-btn">
            </form>
        </div>
        <?php if (isset($stmt) && mysqli_num_rows($stmt) > 0) { ?>
            <div class="content">
                <div class="infor">
                        <p class="tile">ID: <?php echo $_GET['id'] ?></p>
                        <p class="tile">TIN: <?php echo $_SESSION[''] ?></p>
                        <p class="tile">Store: <?php echo $row['Name_Store'] ?></p>
                        <p class="tile">Return date: <?php echo $row['Time'] ?></p>
                </div>
                <form action="" method="POST" onSubmit="if(!confirm('Confirm return ?')){return false;}">
                    <?php while ($row = mysqli_fetch_array($listBicycle)) { ?>
                        <div class="form-group">
                            <label for="">Model: <?php echo $row['UniqueName'] ?></label>
                            <label for="">ID: <?php echo $row['IdentifyNumber'] ?></label>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <!-- <label for="">Return Date: </label> -->
                        <?php
                        $stmt2 = mysqli_query($conn, "SELECT * FROM pickup_infor WHERE ID = '$id' ");
                        while ($row = mysqli_fetch_array($stmt2)) { ?>
                            <!-- <input type="date" name="return-date" value="<?php echo $row['Time'] ?>" disabled> -->
                        <?php } ?>
                        <div style="padding: 0">
                            <input type="submit" name="submit-return" value="Confirm Return" <?php if (isset($check) && mysqli_num_rows($check) > 0) {
                                                                                                    echo "disabled";
                                                                                                } ?>>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</body>

</html>