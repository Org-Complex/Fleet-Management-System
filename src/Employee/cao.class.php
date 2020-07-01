<?php
namespace Employee;

use Request\Request;
use DB\Controller\EmployeeController;
use DB\Viewer\EmployeeViewer;
use DB\Controller\RequestController;
use DB\Viewer\RequestViewer;
use Request\Factory\CAORequestFactory\CAORequestFactory;

class CAO extends Requester
{
    function __construct($empID, $firstName, $lastName, $position, $email, $username, $password)
    {
        parent::__construct($empID, $firstName, $lastName, $position, $email, $username, $password);
    }

    //IObjectHandle
    public static function getObject($ID){
        $empID=$ID;
        //get values from database
        $employeeViewer = new EmployeeViewer(); // method of obtaining the viewer/controller must be determined and changed
        $values=$employeeViewer->getRecordByID($empID);

        $obj = new CAO($values['EmpID'], $values['FirstName'], $values['LastName'], $values['Position'], $values['Email'], $values['Username'], "");
        
        return $obj; //return false, if fail
    }

    //IObjectHandle
    public static function getObjectByValues(array $values){
        $obj = new CAO($values['EmpID'], $values['FirstName'], $values['LastName'], $values['Position'], $values['Email'], $values['Username'], "");
        return $obj;
    }

    //IObjectHandle
    public static function constructObject($empID, $firstName, $lastName, $position, $email, $username, $password){

        $obj = new CAO($empID, $firstName, $lastName, $position, $email, $username, $password);

        $obj->saveToDatabase(); //check for failure

        return $obj; //return false, if fail
    }

    public function getMyApprovedRequestsByState(string $state) : array {
        return CAORequestFactory::makeApprovedRequests($this->empID,$state);
    }

    public function getJustifiedRequests(){
        return CAORequestFactory::getJustifiedRequests();
    }

    public function approveRequest($requestID,$CAOComment){
        $request = CAORequestFactory::makeRequest($requestID);
        $request->setApprove(true,$this->empID,$CAOComment);
    }

    public function denyRequest($requestID,$CAOComment){
        $request = CAORequestFactory::makeRequest($requestID);
        $request->setApprove(false,$this->empID,$CAOComment);
    }

}
