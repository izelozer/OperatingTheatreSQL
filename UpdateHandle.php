<?php
require "Query.php";
$columns = array(); //this will hold the column names
$dataList = array(); //the list that will hold the data for the row to be inserted in to database
$tableName = $_POST["tableName"];
$id = $_POST["id"];
$fieldIdName = $_POST["fieldIdName"];
foreach ($_POST as $key => $value){
    if ($key != "tableName" And $key != "id" And $key != "fieldIdName"){//we have to check this since we also send the table name information and don't want it to be added in to the lists.
        array_push($columns,$key);
        array_push($dataList,$value);
    }
}

Query::connectDatabase();
$result = Query::updateRow($tableName,$id,$dataList,$columns,$fieldIdName);


if($result){
    echo "Updated successfully in ".$tableName ;
}
else {
    echo "Couldn't update in ".$tableName;
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


?>