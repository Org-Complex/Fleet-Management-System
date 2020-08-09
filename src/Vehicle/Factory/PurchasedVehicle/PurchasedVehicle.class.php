<?php

namespace Vehicle\Factory\PurchasedVehicle;

use db\Controller\VehicleController;
use JsonSerializable;
use Vehicle\Factory\Base\AbstractVehicle;
use Vehicle\State\State;

class PurchasedVehicle extends AbstractVehicle implements JsonSerializable
{
    public function __construct($values)
    {
        parent::__construct($values);
    }

    public function getField(string $field)
    {
        if (property_exists($this, $field)) {
            return $this->$field;
        }
        return null;
    }

    public function jsonSerialize()
    {
        return [
            'registration' => $this->registrationNo,
            'model' => $this->model,
            'purchasedYear' => $this->purchasedYear,
            'value' => $this->value,
            'fuelType' => $this->fuelType,
            'insuranceValue' => $this->insuranceValue,
            'insuranceCompany' => $this->insuranceCompany,
            'assignedOfficer' => $this->assignedOfficer,
            'state' => State::getStateString($this->state->getID()),
            'currentLocation' => $this->currentLocation,
            'numOfAllocations' => $this->numOfAllocations
        ];
    }

    //IObjectHandle
    public function saveToDatabase(): void
    {
        $vehicleController = new VehicleController();
        $vehicleController->savePurchasedVehicleRecord(
            $this->registrationNo,
            $this->model,
            $this->purchasedYear,
            $this->value,
            $this->fuelType,
            $this->insuranceValue,
            $this->insuranceCompany,
            $this->assignedOfficer,
            $this->state->getID(),
            $this->currentLocation,
            $this->numOfAllocations
        );
    }

    public function updateInfo(array $values): void
    {
        //changed vehicle attributes can be analysed here

        $this->registrationNo=$values['NewRegistrationNo'];
        $this->model = $values['Model'];
        $this->purchasedYear = $values['PurchasedYear'];
        $this->value = $values['Value'];
        $this->fuelType = $values['FuelType'];
        $this->insuranceValue = $values['InsuranceValue'];
        $this->insuranceCompany = $values['InsuranceCompany'];
        $this->currentLocation = $values['CurrentLocation'];

        $vehicleController = new VehicleController();
        $vehicleController->updatePurchasedVehicleInfo(
            $values['RegistrationNo'],
            $this->registrationNo,
            $this->model,
            $this->purchasedYear,
            $this->value,
            $this->fuelType,
            $this->insuranceValue,
            $this->insuranceCompany,
            $this->assignedOfficer
        );
    }
}
