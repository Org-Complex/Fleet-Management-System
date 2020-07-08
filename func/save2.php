<?php

use Employee\CAO;
use Employee\Requester;
use Employee\JO;
use Employee\VPMO;

include_once '../includes/autoloader.inc.php';
$method = $_POST['Method'];
switch ($method) {
	case 'JOJustify':
		$jo = JO::getObject($_POST['empID']);
		$jo->justifyRequest($_POST['justify-requestID'], $_POST['justify-comment']);
		echo json_encode("success_Request ".$_POST['justify-requestID']." successfully justified");
		break;
	case 'JODeny':
		$jo = JO::getObject($_POST['empID']);
		$jo->denyRequest($_POST['deny-requestID'], $_POST['decline-comment']);
		echo json_encode("success_Request ".$_POST['deny-requestID']." successfully denied");
		break;

	case 'CAOApprove':
		$cao = CAO::getObject($_POST['empID']);
		$cao->approveRequest($_POST['approve-requestID'], $_POST['approve-comment']);
		echo json_encode("success_Request ".$_POST['approve-requestID']." successfully approved");
		break;

	case 'CAODeny':
		$cao = CAO::getObject($_POST['empID']);
		$cao->denyRequest($_POST['CAOdeny-requestID'], $_POST['CAO-deny-comment']);
		echo json_encode("success_Request ".$_POST['CAOdeny-requestID']." successfully denied");
		break;

	case 'RequestAdd':
		$requester = Requester::getObject($_POST['empID']);
		$requester->placeRequest($_POST['date'], $_POST['time'], $_POST['dropoff'], $_POST['pickup'], $_POST['purpose']);
		echo json_encode("success_Request successfully added");
		break;

	case 'AddVehicle':
		$vpmo = VPMO::getObject($_POST['empID']);
		//echo $_POST['model'];
		if($_POST['isLeased']=="Yes"){
			$vpmo->addLeasedVehicle($_POST['registrationNo'], $_POST['model'], $_POST['purchasedYear'], $_POST['value'], $_POST['fuelType'], $_POST['insuranceValue'], $_POST['insuranceCompany'], $_POST['leasedCompany'], $_POST['leasedPeriodFrom'], $_POST['leasedPeriodTo'], $_POST['monthlyPayment']);
		}
		else{
			$vpmo->addPurchasedVehicle($_POST['registrationNo'], $_POST['model'], $_POST['purchasedYear'], $_POST['value'], $_POST['fuelType'], $_POST['insuranceValue'], $_POST['insuranceCompany']);
		}
		
		echo json_encode("success_Vehicle ".$_POST['registrationNo']." successfully added");
		break;

	case 'UpdateVehicle':
		$vpmo = VPMO::getObject($_POST['empID']);
		if($_POST['leasedCompany']!==""){
			$vpmo->updateLeasedVehicleInfo($_POST['registrationNo'], $_POST['model'], $_POST['purchasedYear'], $_POST['value'], $_POST['fuelType'], $_POST['insuranceValue'], $_POST['insuranceCompany'], $_POST['leasedCompany'], $_POST['leasedPeriodFrom'], $_POST['leasedPeriodTo'], $_POST['monthlyPayment']);
		}
		else{
			$vpmo->updatePurchasedVehicleInfo($_POST['registrationNo'], $_POST['model'], $_POST['purchasedYear'], $_POST['value'], $_POST['fuelType'], $_POST['insuranceValue'], $_POST['insuranceCompany']);
		}
		echo json_encode("success_Vehicle ".$_POST['registrationNo']." successfully updated");
		break;
	case 'CancelRequest':
		$requester = Requester::getObject($_POST['empID']);
		$requester->cancelRequest($_POST['requestID']);
		echo json_encode("success_Request ".$_POST['requestID']." successfully cancelled");
		break;

	default:
		echo "Invalid method";
}
