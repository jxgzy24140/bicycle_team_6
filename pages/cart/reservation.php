<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/reservation.css">
    <title>Document</title>
</head>

<body>
    <?php
    require '../../connection/connection.php';
    session_start();
    if (isset($_POST['submit-reser'])) {
        $TIN = $_SESSION['tin'];
        $location = $_SESSION['location'];  
        $name_store = mysqli_query($conn, "SELECT * FROM store WHERE Address LIKE '%$location%'");
        while($row = mysqli_fetch_array($name_store)) { $Name_Store = $row['UniqueName'];}
        $Time = $_POST['date'];
        $result = mysqli_query($conn, "INSERT INTO reservation(TIN,Name_Store,Time) VALUES('$TIN','$Name_Store','$Time')");
        $id = mysqli_insert_id($conn);
        foreach ($_SESSION['reservation'] as $key => $value) {
            $result2 = mysqli_query($conn, "INSERT INTO reservation_bicyclemodel(ID,Name_BicycleModel) VALUES ('$id','$key')");
            for ($i = 0 ;$i < $_SESSION['quantity'][$key]; $i++) {
                $bicycle = mysqli_query($conn, "SELECT * FROM bicycle INNER JOIN store_bicycle ON bicycle.IdentifyNumber = store_bicycle.IdentifyNumber WHERE store_bicycle.Name_Store = '$Name_Store' AND bicycle.UniqueName LIKE '%$key%' AND bicycle.Status = '1' ORDER BY bicycle.IdentifyNumber ASC LIMIT 1;");
                while($row = mysqli_fetch_array($bicycle)) {
                $bicycle_key = $row['IdentifyNumber'];
            }
            $result3 = mysqli_query($conn, "UPDATE bicycle SET bicycle.Status = '0' WHERE IdentifyNumber ='$bicycle_key'");
            $result4 = mysqli_query($conn,"INSERT INTO reservation_bicycle (ID,IdentifyNumber) VALUES('$id','$bicycle_key')");
        }
        }
        if($result && $result2 && $result3 && $result4 ) {
            unset($_SESSION['cart']);
            unset($_SESSION['reservation']);
            unset($_SESSION['quantity']);
            echo "<script> alert('Your reservation has been received'); window.location='../../index.php'</script>";
        }
    }
    ?>
    <div class="reser-popup hide">
        <form method="POST" onSubmit="if(!confirm('Is the form filled out correctly?')){return false;}">
            <?php
            foreach ($_SESSION['reservation'] as $key => $value) {
                $bicycle = mysqli_query($conn, "SELECT * FROM bicyclemodel WHERE UniqueName LIKE '%$key%'");
                while ($row = mysqli_fetch_array($bicycle)) {
            ?>
                    <div class="form-group">
                        <h3>Bicycle Model: <?php echo $row['UniqueName']; $uniqueName = $row['UniqueName']; ?></h3>
                        <p>Type: <?php echo $row['Type'] ?></p>
                        <p>Gear: <?php echo $row['Gear'] ?></p>
                        <p>Quantity: <?php echo $_POST[$key] ?></p>
                        <?php if(!isset($_SESSION['quantity'])) { $_SESSION['quantity'] = array(); } else { $_SESSION['quantity'][$uniqueName] = $_POST[$key];} ?>
                    </div>
            <?php }
            }  ?>
            <div class="form-group">
                <p>PICK-UP LOCATION: <?php echo $_SESSION['location'] ?></p>
                <?php echo $_SESSION['tin'] ?>
            </div>
            <div class="form-group">
                <label for="">PICK-UP DATE: </label>
                <input type="date" name="date">
            </div>
            <div class="submit-form-group form-group">
                <input type="submit" name="submit-reser" value="BOOK" class="submitBtn" />
            </div>
        </form>
    </div>
</body>

</html>