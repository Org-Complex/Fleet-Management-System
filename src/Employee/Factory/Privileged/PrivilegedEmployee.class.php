<?php

namespace Employee\Factory\Privileged;

use Employee\Employee;
use DB\Controller\EmployeeController;
use JsonSerializable;


abstract class PrivilegedEmployee extends Employee implements JsonSerializable
{
    protected string $empID;
    protected string $position;
    protected string $designation;
    protected string $username;
    protected ?string $password; //TODO: might need a separate table for username and password

    function __construct($values)
    {
        parent::__construct($values);
        $this->empID = $values['EmpID'];
        $this->position = $values['Position'];
        $this->designation = $values['Designation'];
        $this->username = $values['Username'];
        $this->password = $values['Password'];
    }
    public function jsonSerialize()
    {
        return [
            'empID' => $this->empID,
            'FirstName' => $this->firstName,
            'LastName' => $this->lastName,
            'Designation' => $this->designation,
            'Position' => $this->position,
            'Email' => $this->email
        ];
    }

    public function updateInfo(array $values): void
    {
        //changed employee attributes can be analysed here

        $this->empID = $values['NewEmpID'];
        $this->firstName = $values['FirstName'];
        $this->lastName = $values['LastName'];
        $this->position = $values['Position'];
        $this->designation = $values['Designation'];
        $this->email = $values['Email'];

        $employeeController = new EmployeeController();
        $employeeController->updateEmployeeInfo(
            $values['NewEmpID'],
            $this->empID,
            $this->firstName,
            $this->lastName,
            $this->position,
            $this->designation,
            $this->email
        );
    }

    public function delete(): void
    {
        $employeeController = new EmployeeController();
        $employeeController->deleteEmployee($this->empID);
    }

    public function getField($field)
    {
        if (property_exists($this, $field)) {
            return $this->$field;
        }
        return null;
    }

    //IObjectHandle
    public function saveToDatabase()
    {
        $employeeController = new EmployeeController();
        $employeeController->saveRecord(
            $this->empID,
            $this->firstName,
            $this->lastName,
            $this->position,
            $this->designation,
            $this->email,
            $this->username,
            $this->password
        );
    }
}