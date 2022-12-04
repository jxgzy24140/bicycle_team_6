<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/connection/Connector.php');
    $conn = Connector::Connect();
    if (isset($_GET['submit-pickup'])) {
        $id = $_GET['id'];
        $return_date = $_GET['date'];
        $user = mysqli_query($conn, "SELECT TIN FROM reservation WHERE ID = '$id'");
        while ($row = mysqli_fetch_array($user)) {
            $tin = $row['TIN'];
        }
        $listBicycle = mysqli_query($conn, "SELECT reservation_bicycle.IdentifyNumber, bicycle.UniqueName FROM reservation_bicycle INNER JOIN bicycle ON reservation_bicycle.IdentifyNumber = bicycle.IdentifyNumber WHERE reservation_bicycle.ID = '$id'");
        $result2 = mysqli_query($conn, "INSERT INTO pickup_infor (ID,TIN,Time) VALUES ('$id','$tin','$return_date')");
        while ($row = mysqli_fetch_array($listBicycle)) {
            $IdentifyNum = $row['IdentifyNumber'];
            $result = mysqli_query($conn, "INSERT INTO pickup_infor_bicycle (ID,IdentifyNumber) VALUES ('$id','$IdentifyNum')");
        }
        $delete_reservation_bicycle = mysqli_query($conn, "DELETE FROM reservation_bicycle WHERE ID = '$id' ");
        $delete_reservation_bicyclemodel = mysqli_query($conn, "DELETE FROM reservation_bicyclemodel WHERE ID = '$id' ");
        $delete_reservation = mysqli_query($conn, "DELETE FROM reservation WHERE ID = '$id' ");
        echo "<script>alert('success!');window.location = './pickup.php'</script>";
    }
?>