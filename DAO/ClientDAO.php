<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/Models/ClientModel.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/connection/Connector.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/Models/StoreModel.php');
class ClientDAO
{
    public Client $client;
    public static $conn;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public static function isExistUsername(Client $client)
    {
        try {
            ClientDAO::$conn = Connector::Connect();
            $stmt = ClientDAO::$conn->prepare("SELECT * FROM CLIENT WHERE USERNAME = ?");
            $stmt->bind_param("s", $client->username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0)
                return true;
            $stmt = ClientDAO::$conn->prepare("SELECT * FROM CLIENT WHERE TIN = ?");
            $stmt->bind_param("s", $client->TIN);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0)
                return true;
            return false;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public function insertClient()
    {
        ClientDAO::$conn = Connector::Connect();
        try {
            $stmt = ClientDAO::$conn->prepare("INSERT INTO CLIENT VALUES(?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "ssssss",
                $this->client->TIN,
                $this->client->username,
                $this->client->password,
                $this->client->NIN,
                $this->client->name,
                $this->client->address
            );
            return $stmt->execute();
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public static function updateClient(Client $client)
    {
        ClientDAO::$conn = Connector::Connect();
        try {
            $stmt = ClientDAO::$conn->prepare(" UPDATE Client 
                                                SET Password = ?, NIN = ?, Name = ?, Address = ?
                                                WHERE TIN = ?
                                            ");
            $stmt->bind_param(
                "sssss",
                $client->password,
                $client->NIN,
                $client->name,
                $client->address,
                $client->TIN
            );
            $stmt->execute();
            if($stmt->affected_rows == 0)
                return false;
            return true;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public function makeReservation(Store $store)
    {
        ClientDAO::$conn = Connector::Connect();
        try {
            $date = date('Y-m-d H:i:s');
            $stmt = ClientDAO::$conn->prepare(" INSERT INTO Reservation(TIN,Name_Store,Time)
                                                VALUES(?, ?, ?)
                                            ");
            $stmt->bind_param(
                "sss",
                $this->client->TIN,
                $store->uniqueName,
                $date
            );
            if($stmt->execute())
                return $stmt->insert_id;
            return null;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public static function getClient($TIN)
    {
        ClientDAO::$conn = Connector::Connect();
        try {
            $stmt = ClientDAO::$conn->prepare(" SELECT * FROM Client
                                                WHERE TIN = ?
                                            ");
            $stmt->bind_param(
                "s",
                $TIN
            );
            $stmt->execute();
            $data = $stmt->get_result();
            if($data->num_rows == 0)
                return null;
            return new Client($data->fetch_assoc());
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public static function cancelReservation($id)
    {
        ClientDAO::$conn = Connector::Connect();
        try {
            $stmt = ClientDAO::$conn->prepare(" DELETE FROM RESERVATION
                                                WHERE ID = ?
                                            ");
            $stmt->bind_param(
                "s",
                $id
            );
            $stmt->execute();
            if($stmt->affected_rows > 0)
                return true;
            return false;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public static function validAccess($username, $password)
    {
        ClientDAO::$conn = Connector::Connect();
        try {
            $stmt = ClientDAO::$conn->prepare("SELECT TIN, Username, Password FROM CLIENT WHERE USERNAME = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            // $stmt->store_result();
            if ($result->num_rows == 0) {
                echo "<script>alert('Username or password incorret!'); history.back();</script>";
                return;
            }
            $result = $result->fetch_assoc();
            $usernameMatch = strcmp($result["Username"], $username) == 0;
            $passwordMatch = password_verify($password, $result["Password"]);
            if ($usernameMatch && $passwordMatch) {
                session_start();
                $_SESSION['tin'] = $result['TIN'];
                $_SESSION['auth'] = 1;
                // echo "<script>localStorage.setItem('auth', 1); </script>";
                echo "<script> window.location = '../../index.php'; </script>";
                return;
            } else {
                echo "<script>alert('Username or password incorret!'); history.back();</script>";
                return;
            }
        } catch (Exception $th) {
            echo $th;
        }
        return true;
    }
}
