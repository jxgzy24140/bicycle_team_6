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
    // var_dump($_SESSION['quantity']['Martin-MT680']);
    class Reservation
    {
        public $tin;
        public $nameStore;
        public $days;
        public $time;

        public function __construct($tin, $nameStore, $days, $time)
        {
            $this->tin = $tin;
            $this->nameStore = $nameStore;
            $this->days = $days;
            $this->time = $time;
        }

        function connect()
        {
            $conn = mysqli_connect('localhost', 'root', '', 'rent_bicycle');
            return $conn;
        }

        public function insertReservation()
        {
            $conn = $this->connect();
            $sql = "INSERT INTO reservation(TIN,Name_Store,days_to_rent,Time) VALUES('$this->tin','$this->nameStore','$this->days','$this->time')";
            mysqli_query($conn, $sql);
            return mysqli_insert_id($conn);
        }

        public function getLastId()
        {
            $conn = $this->connect();
            $id = $conn->insert_id;
            return $id;
        }

        public function insertReserBicycle($id, $indentifyNumber)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO reservation_bicycle(ID,IdentifyNumber) VALUES('$id', '$indentifyNumber')";
            mysqli_query($conn, $sql);
        }

        public function insertReserBicycleModel($id, $name)
        {
            $conn = $this->connect();
            $sql = "INSERT INTO reservation_bicyclemodel(ID,Name_BicycleModel) VALUES('$id', '$name')";
            mysqli_query($conn, $sql);
        }

        public function updateBicycle($id)
        {
            $conn = $this->connect();
            $sql = "UPDATE bicycle SET bicycle.Status = '0' WHERE IdentifyNumber ='$id'";
            mysqli_query($conn, $sql);
        }
    }
    if (isset($_POST['submit-cart'])) {
        $ship = (isset($_POST['ship'])) ? $_POST['ship'] : '';
        $pickup = (isset($_POST['pickup'])) ? $_POST['pickup'] : '';
        if (empty($ship) && empty($pickup)) {
            echo "<script>alert('You must choice ship option!!'); window.location = './cart.php'</script>";
        }
    }
    if (isset($_POST['submit-reser'])) {

        $TIN = $_SESSION['tin'];
        $location = $_SESSION['location'];
        $name_store = mysqli_query($conn, "SELECT * FROM store WHERE Address LIKE '%$location%'");
        while ($row = mysqli_fetch_array($name_store)) {
            $Name_Store = $row['UniqueName'];
        }
        $Time = $_POST['date'];
        $days = $_POST['days'];
        $newReser = new Reservation($TIN, $Name_Store, $days, $Time);
        $id = $newReser->insertReservation();
        foreach ($_SESSION['reservation'] as $key => $value) {
            $result2 = $newReser->insertReserBicycleModel($id, $key);
            for ($i = 0; $i < $_SESSION['quantity'][$key]; $i++) {
                echo "key: ", $key;
                $bicycle = mysqli_query($conn, "SELECT * FROM bicycle INNER JOIN store_bicycle ON bicycle.IdentifyNumber = store_bicycle.IdentifyNumber WHERE store_bicycle.Name_Store = '$Name_Store' AND bicycle.UniqueName LIKE '%$key%' AND bicycle.Status = '1' ORDER BY bicycle.IdentifyNumber ASC LIMIT 1;");
                while ($row = mysqli_fetch_array($bicycle)) {
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
    <div class="reser-popup">
        <form method="POST" onSubmit="if(!confirm('Is the form filled out correctly?')){return false;}">
            <?php
            foreach ($_SESSION['reservation'] as $key => $value) {
                $bicycle = mysqli_query($conn, "SELECT * FROM bicyclemodel WHERE UniqueName LIKE '%$key%'");
                while ($row = mysqli_fetch_array($bicycle)) {
            ?>
                    <div class="form-group">
                        <h3>Bicycle Model: <?php echo $row['UniqueName'];
                                            $uniqueName = $row['UniqueName']; ?></h3>
                        <p>Type: <?php echo $row['Type'] ?></p>
                        <p>Gear: <?php echo $row['Gear'] ?></p>
                        <p>Quantity: <span class="quantity"><?php echo $_POST[$key] ?></span></p>
                        <?php if (!isset($_SESSION['quantity'])) {
                            $_SESSION['quantity'] = array();
                        } else {
                            $_SESSION['quantity'][$uniqueName] = $_POST[$key];
                        } ?>
                    </div>
            <?php }
            }  ?>
            <?php if (isset($ship) && !empty($ship)) { ?>
                <div class="form-group">
                    <div class="form-group">
                        <label style="display: inline" for="">Address:</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label style="display: inline" for="">Name:</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label style="display: inline" for="">Phone Numbers:</label>
                        <input type="text">
                    </div>
                </div>
            <?php } else { ?>
                <div class="form-group">
                    <label style="display: inline" for="">STORE PICKUP:</label>
                    <p><?php echo $_SESSION['location'] ?></p>
                </div>
            <?php } ?>
            <div class="form-group" style="display: flex; justify-content: space-around">
            <?php if(isset($pickup) && !empty($pickup)) {  ?>
                <div class="form-pay" style="display: inline-block">
                    <label for="">COD</label>
                    <input onclick="hide()" type="radio" class="cod" name="payment">
                </div>
                <?php } else { ?>
                    <div class="form-pay" style="display: inline-block">
                    <label for="">Thanh toán tại cửa hàng</label>
                    <input onclick="hide()" type="radio" class="cod" name="payment">
                </div>
                    <?php } ?>
                <div class="form-pay" style="display: inline-block">
                    <label for="">CREDIT CARD</label>
                    <input onclick="show()" type="radio" class="credit-card" name="payment">
                </div>
            </div>
            <div class="form-group credit-card-form hide">
                <div class="head" style="display: flex">
                    <div class="owner" style="display: inline-block; width: 70%; padding-right: 20px">
                        <label for="">Owner</label>
                        <input type="text">
                    </div>
                    <div class="cvv" style="display: inline-block; width: 30%">
                        <label for="">CVV</label>
                        <input type="text">
                    </div>
                </div>
                <div class="body">
                    <label for="">Card Number</label>
                    <input type="text">
                </div>
                <div class="footer">
                    <label for="">Expiration Date</label>
                    <div class="">
                        <input type="text" style="width: 10%">
                        <input type="text" style="width: 20%">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label style="display: inline" for="">TOTAL PRICE:</label>
                <span style="color: white" class="total-price"></span>
            </div>
            <div class="submit-form-group form-group">
                <input type="submit" name="submit-reser" value="BOOK" class="submitBtn" />
            </div>
        </form>
    </div>
    <script>
        const listQuantity = document.querySelectorAll('.quantity')
        const price = document.querySelector('.total-price')
        let sum = 0
        listQuantity.forEach(e => {
            sum = sum + parseInt(e.outerText)
        })
        price.innerHTML = (sum * 12000000).toLocaleString('it-IT', {
            style: 'currency',
            currency: 'VND'
        }); + " VND"
        const creditForm = document.querySelector('.credit-card-form')
        const cod = document.querySelector('.cod')
        const onlinePay = document.querySelector('.credit-card')
        function show() {
            creditForm.classList.remove('hide')
            creditForm.classList.add('show')
        }
        function hide() {
            creditForm.classList.remove('show')
            creditForm.classList.add('hide')
        }
    </script>
</body>

</html>