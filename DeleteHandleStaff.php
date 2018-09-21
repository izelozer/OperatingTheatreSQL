<?php
require "Query.php";

$id = $_GET['id'];
$tableName = $_GET['tableName'];
$fieldIdName = $_GET['fieldIdName'];

Query::connectDatabase();
$result = Query::deleteRowStaff($tableName,$id,$fieldIdName);


if($result){
    echo "Deleted successfully from ".$tableName ;
}
else {
    echo "Couldn't delete from ".$tableName;
}
echo"<br>";
$pageArray = array(
    "patient" => "PatientAdmin.php",
    "operation" => "OperationAdmin.php",
    "products" => "ProductsAdmin.php",
	"undergoes"=> "POAdmin.php",
	"equipment" => "EquipmentAdmin.php",
	"staff" => "StaffAdmin.php",
	"doctor" => "DoctorAdmin.php",
	"nurse" => "NurseAdmin.php",
	"technicians" => "TechniciansAdmin.php");
$returnPage = $pageArray[$tableName];
echo "<a href='$returnPage'>return to $tableName page</a>";


?>