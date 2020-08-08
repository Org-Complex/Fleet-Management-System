<?php
namespace DB\Viewer;

use DB\Model\VehicleModel;

class VehicleViewer extends VehicleModel{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRecordByID($registrationNo, $isLeased){
        return parent::getRecordByID($registrationNo, $isLeased);
    }

    public function getAllRecords(int $offset){
        return parent::getAllRecords($offset);
    }

    public function isLeasedVehicle($registrationNo) : bool 
    {
        return parent::isLeasedVehicle($registrationNo);
    }

}