<?php
namespace Vehicle\Factory\Base;

use Vehicle\Vehicle;
use DB\Viewer\VehicleViewer;
use Vehicle\Factory\LeasedVehicle\LeasedVehicleFactory;
use Vehicle\Factory\PurchasedVehicle\PurchasedVehicleFactory;

abstract class VehicleFactory
{
    /**
     * Creates a new vehicle
     * 
     * @param array $vehicleInfo
     * @return Vehicle
     */
    abstract public function makeNewVehicle(array $vehicleInfo) : Vehicle;

    /**
     * Creates a vehicle object for a given ID
     * 
     * @param int $vehicleID
     * @return Vehicle
     */
    abstract public function makeVehicle(string $vehicleID) : Vehicle;

    /**
     * Get all the vehicles
     * 
     * @return array(Vehicle)
     */
    abstract public function getVehicles() : array;

    /**
     * Create a vehicle object for given values
     * 
     * @param array $vehicleInfo
     * @return Vehicle
     */
    abstract public function makeVehicleByValues(array $vehicleInfo) : Vehicle;

    /**
     * Casts a vehicle object to vehicle interface
     * 
     * @param Vehicle $vehicle
     * @return Vehicle
     */
    protected function castToVehicle(Vehicle $vehicle) : Vehicle 
    {
        return $vehicle;
    }

    /**
     * Get either purchased or leased vehicle object for a given registration number.
     * 
     * @param string $registrationNo
     * 
     * @return Vehicle
     */
    public static function getVehicle(string $registrationNo) : Vehicle 
    {
        $vehicleViewer = new VehicleViewer();
        $isLeased = $vehicleViewer->isLeasedVehicle($registrationNo);
        if ($isLeased)
        {
            $leasedVehicleFactory = LeasedVehicleFactory::getInstance();
            return $leasedVehicleFactory->makeVehicle($registrationNo);
        }
        else
        {
            $purchasedVehicleFactory = PurchasedVehicleFactory::getInstance();
            return $purchasedVehicleFactory->makeVehicle($registrationNo);
        }
    }
}