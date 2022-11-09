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
    // require '../../connection/connection.php';
    include '../../connection/connection.php';
    $con = new Connection();
    $conn = $con->connect();
    session_start();
    class Reservation {
        public $tin;
        public $nameStore;
        public $time;

        public function __construct($tin, $nameStore, $time)
        {
          $this->tin = $tin;
          $this->nameStore = $nameStore;
          $this->time = $time;
        }

        function connect()
        {
          $conn = mysqli_connect('localhost', 'root', '', 'rent_bicycle');
          return $conn;
        }

        public function insertReservation() {
            $conn = $this->connect();
            $sql = "INSERT INTO reservation(TIN,Name_Store,Time) VALUES('$this->tin','$this->nameStore','$this->time')";
            mysqli_query($conn, $sql);
            return mysqli_insert_id($conn);
        }

        public function getLastId() {
            $conn = $this->connect();
            $id = $conn->insert_id;
            return $id;
        }

        public function insertReserBicycle($id, $indentifyNumber) {
            $conn = $this->connect();
            $sql = "INSERT INTO reservation_bicycle(ID,IdentifyNumber) VALUES('$id', '$indentifyNumber')";
            mysqli_query($conn, $sql);
        }

        public function insertReserBicycleModel($id, $name) {
            $conn = $this->connect();
            $sql = "INSERT INTO reservation_bicyclemodel(ID,Name_BicycleModel) VALUES('$id', '$name')";
            mysqli_query($conn, $sql);
        }

        public function updateBicycle($id) {
            $conn = $this->connect();
            $sql = "UPDATE bicycle SET bicycle.Status = '0' WHERE IdentifyNumber ='$id'";
            mysqli_query($conn, $sql);
        }
    }

    if (isset($_POST['submit-reser'])) {
        $TIN = $_SESSION['tin'];
        $location = $_SESSION['location'];  
        $name_store = mysqli_query($conn, "SELECT * FROM store WHERE Address LIKE '%$location%'");
        while($row = mysqli_fetch_array($name_store)) { $Name_Store = $row['UniqueName'];}
        $Time = $_POST['date'];
        $newReser = new Reservation($TIN, $Name_Store, $Time);
        $id = $newReser->insertReservation();
        foreach ($_SESSION['reservation'] as $key => $value) {
            $result2 = $newReser->insertReserBicycleModel($id, $key);
            for ($i = 0 ;$i < $_SESSION['quantity'][$key]; $i++) {
                $bicycle = mysqli_query($conn, "SELECT * FROM bicycle INNER JOIN store_bicycle ON bicycle.IdentifyNumber = store_bicycle.IdentifyNumber WHERE store_bicycle.Name_Store = '$Name_Store' AND bicycle.UniqueName LIKE '%$key%' AND bicycle.Status = '1' ORDER BY bicycle.IdentifyNumber ASC LIMIT 1;");
                while($row = mysqli_fetch_array($bicycle)) {
                $bicycle_key = $row['IdentifyNumber'];
            }
            $result3 = $newReser->updateBicycle($bicycle_key);
            $result4 = $newReser->insertReserBicycle($id, $bicycle_key);
        }
        }
            echo "<script> alert('Your reservation #$id has been received'); window.location='../../index.php'</script>";
            unset($_SESSION['cart']);
            unset($_SESSION['reservation']);
            unset($_SESSION['quantity']);
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