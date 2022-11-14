<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/rent_bicycle/Models/BicycleModelModel.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/rent_bicycle/connection/Connector.php');
class BicycleModelDAO
{
    public BicycleModel $bicycleModel;
    public static $conn;
    
    public function __construct(BicycleModel $bicycleModel)
    {
        $this->bicycleModel = $bicycleModel;
    }

    public function insert()
    {
        try {
            BicycleModelDAO::$conn = Connector::Connect();

            $stmt = BicycleModelDAO::$conn->prepare("INSERT INTO BicycleModel VALUES(?, ?, ?, ?)");
            $stmt->bind_param("ssss", 
                            $this->bicycleModel->uniqueName, 
                            $this->bicycleModel->type,
                            $this->bicycleModel->gear,
                            $this->bicycleModel->image 
                    );
            $stmt->execute();
            
            if ($stmt->affected_rows > 0)
                return true;
            return false;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public static function insertBicycleModel(BicycleModel $bicycleModel)
    {
        try {
            BicycleModelDAO::$conn = Connector::Connect();

            $stmt = BicycleModelDAO::$conn->prepare("INSERT INTO BicycleModel VALUES(?, ?, ?, ?)");
            $stmt->bind_param("ssss", 
                            $bicycleModel->uniqueName, 
                            $bicycleModel->type,
                            $bicycleModel->gear,
                            $bicycleModel->image 
                    );
            $stmt->execute();
            
            if ($stmt->affected_rows > 0)
                return true;
            return false;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public static function getAllBicycleModel()
    {
        try {
            BicycleModelDAO::$conn = Connector::Connect();

            $stmt = BicycleModelDAO::$conn->prepare("SELECT * FROM BicycleModel");
            
            $stmt->execute();
            $result = $stmt->get_result();
            $listBicycleModel = [];
            while($data = $result->fetch_assoc())
            {
                $listBicycleModel[] = new BicycleModel($data);
            }
            if($result->num_rows == 0)
                return null;
            return $listBicycleModel;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public static function getBicycleModel($nameBicycleModel)
    {
        try {
            BicycleModelDAO::$conn = Connector::Connect();

            $stmt = BicycleModelDAO::$conn->prepare("SELECT * FROM BicycleModel WHERE UniqueName = ?");
            $stmt->bind_param("s", $nameBicycleModel);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0)
                return null;
            return new BicycleModel($result->fetch_assoc());
        } catch (Exception $ex) {
            echo $ex;
        }
    }
}
?>