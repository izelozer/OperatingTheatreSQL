<?php
require "Query.php";
$columns = array(); //this will hold the column names
$dataList = array(); //the list that will hold the data for the row to be inserted in to database
$tableName = $_POST["tableName"];
foreach ($_POST as $key => $value){
    if ($key != "tableName"){//we have to check this since we also send the table name information and don't want it to be added in to the lists.
        array_push($columns,$key);
        array_push($dataList,$value);
    }

}
Query::connectDatabase();
$result = Query::addRow($tableName,$columns,$dataList);

if($result){
    echo "Added successfully to ".$tableName ;
}
else {
    echo "Couldn't add to ".$tableName;
}
echo"<br>";
$pageArray = array(
    "patient" => "PatientAdmin.php",
    "operation" => "OperationAdmin.php",
    "products" => "ProductsAdmin.php",
	"undergoes"=> "POAdmin.php",
	"equipment" => "EquipmentAdmin.php",
	"staff" => "StaffAdmin.php",
	"doctor" => "DoctorAdmin.php");
$returnPage = $pageArray[$tableName];
echo "<a href='$returnPage'>return to $tableName page</a>";