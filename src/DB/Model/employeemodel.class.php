<?php
namespace DB\Model;

abstract class EmployeeModel extends Model{
    
    function __construct()
    {
        parent::__construct('employee');
    }

    protected function getRecordByID($empID){
        $isDeleted=0;
        $columnNames= array('EmpID','IsDeleted'); 
        $columnVals= array($empID,$isDeleted);
        
        $wantedColumns=array('EmpID','FirstName','LastName','Position','Designation','Email','Username');
        $results = parent::getRecords($columnNames,$columnVals,$wantedColumns,$isDeleted); //change getRecords() to not get password from database
        return $results[0];
    }

    protected function getRecordByUsername($username){
        $isDeleted=0;
        $columnNames= array('Username','IsDeleted');
        $columnVals= array($username,$isDeleted);
        $isDeleted=0;
        $wantedColumns=array('EmpID','FirstName','LastName','Position','Designation','Email','Username');
        return parent::getRecords($columnNames,$columnVals,$wantedColumns,$isDeleted);
    }

    protected function saveRecord($empID, $firstName, $lastName, $position, $designation, $email, $username, $password) {
        $columnNames = array('EmpID','FirstName','LastName','Position','Designation','Email','Username','Password');
        $columnVals = array($empID, $firstName, $lastName, $position, $designation, $email, $username, $password);
        parent::addRecord($columnNames,$columnVals);
    }

    protected function checkPassword($username,$password){
        $isDeleted=0;
        $columnNames= array('Username','IsDeleted');
        $columnVals= array($username,$isDeleted);
        $isDeleted=0;
        $wantedColumns=array('Username','Password');
        return (parent::getRecords($columnNames,$columnVals,$wantedColumns)[0]['Password']==$password)? true:false;
    }

    protected function getEmails(string $position)
    {
        $isDeleted=0;
        $colmunNames = array('Position','IsDeleted');
        $columnVals = array($position,$isDeleted);
        $wantedCols = array('Email');
        $emailRecords = parent::getRecords($colmunNames,$columnVals,$wantedCols);

        $emails = array();
        foreach ($emailRecords as $email)
        {
             array_push($emails,$email['Email']);
        }
        return $emails;
    }
}