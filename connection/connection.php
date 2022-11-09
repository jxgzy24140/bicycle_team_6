<pre lang="php"></pre>
<?php
class Connection {
    public $severname   = "localhost";
    public $user = "root";
    public $pass = "";
    public $database = "rent_bicycle";
    
    function connect()
    {
        $conn = mysqli_connect('localhost', 'root', '', 'rent_bicycle');
        return $conn;
    }

    function getLastId() {
        return mysqli_insert_id($this->connect());
    }
    // $conn = mysqli_connect($severname, $user, $pass, $database);
    
    // if(mysqli_connect_error())
    // {
    //     echo "Cannot connect";
    // }
}
    // $connect = mysqli_connect($severname, $user, $pass, $database);

?>