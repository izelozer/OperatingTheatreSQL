<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>title</title>
    <link rel="stylesheet" href="style.css">
    <!--<script src="script.js"></script>-->
</head>
<body>
<?php
$id = $_GET['id'];
$tableName = $_GET['tableName'];
$fieldIdName = $_GET['fieldIdName'];
require "Query.php";
Query::connectDatabase();
?>
<div class="MainContainer">
    <div id="PopulateContainer">
        <!-- a form element starts here -->
        <?php
            Query::tablePopulatorUpdate($tableName,$id,$fieldIdName);
        ?>
    </div>
</div>

</body>
</html>