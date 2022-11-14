<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/Models/StoreModel.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/Models/BicycleModelModel.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/connection/Connector.php');
class StoreDAO
{
    public Store $store;
    public static $conn;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function insert()
    {
        StoreDAO::$conn = Connector::Connect();
        try {
            $stmt = StoreDAO::$conn->prepare("INSERT INTO STORE VALUES(?, ?)");
            $stmt->bind_param("ss", $this->store->uniqueName, $this->store->address);
            return $stmt->execute();
            
        } catch (Exception $th) {
            //throw $th;
            echo $th;
        }
    }

    public static function insertStore(Store $store)
    {
        StoreDAO::$conn = Connector::Connect();
        try {
            $stmt = StoreDAO::$conn->prepare("INSERT INTO STORE VALUES(?, ?)");
            $stmt->bind_param("ss", $store->uniqueName, $store->address);
            return $stmt->execute();
            
        } catch (Exception $th) {
            //throw $th;
            echo $th;
        }
    }

    public static function getAllStore()
    {
        StoreDAO::$conn = Connector::Connect();
        try {
            $stmt = StoreDAO::$conn->prepare("SELECT * FROM STORE");
            $stmt->execute();
            $result = $stmt->get_result();
            $listStores = [];
            while($row = $result->fetch_assoc())
            {
                $listStores[] = new Store($row);
            }
            return $listStores;
        } catch (Exception $th) {
            //throw $th;
            echo $th;
        }
    }

    public static function getStoreByAddress($address)
    {
        $address = "%$address%";
        StoreDAO::$conn = Connector::Connect();
        try {
            $stmt = StoreDAO::$conn->prepare("  SELECT * FROM STORE WHERE Address LIKE ? LIMIT 1
                                            ");
            $stmt->bind_param("s", $address);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0)
                return null;
            $data = $result->fetch_assoc();
            return new Store($data);
        } catch (\Throwable $th) {
            //throw $th;
            echo $th;
        }
    }

    public static function getAllBicycleModelBelongToStore($address)
    {
        $address = "%$address%";
        StoreDAO::$conn = Connector::Connect();
        try {
            $stmt = StoreDAO::$conn->prepare("  SELECT Store_BicycleModel.Name_BicycleModel AS UniqueName, 
                                                        BicycleModel.Type, BicycleModel.Gear, BicycleModel.image 
                                                FROM Store_BicycleModel, BicycleModel, Store
                                                WHERE Store_BicycleModel.Name_BicycleModel = BicycleModel.UniqueName
                                                AND Store_BicycleModel.Name_Store = Store.UniqueName
                                                AND Store.Address LIKE ?
                                            ");
            $stmt->bind_param("s", $address);
            $stmt->execute();
            $result = $stmt->get_result();
            $listBicycleModels = [];
            while($row = $result->fetch_assoc())
            {
                $listBicycleModels[] = new BicycleModel($row);
            }
            return $listBicycleModels;
        } catch (\Throwable $th) {
            //throw $th;
            echo $th;
        }
    }
}
