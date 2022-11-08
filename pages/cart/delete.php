<?php
if(isset($_GET['name'])) {
    session_start();
    $key = $_GET['name'];
    unset($_SESSION['cart'][$key]);
    echo "<script>window.location = 'cart.php'</script>";
}

?>