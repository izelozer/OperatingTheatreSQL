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
require "Query.php";
Query::connectDatabase();
?>
<div class="MainContainer">
    <div id="TableContainer">
        <!-- a table element starts here -->
        <?php
            Query::getTableOnlyUpdate("undergoes");
        ?>
    </div>
    <div id="PopulateContainer">
        <!-- a form element starts here -->
        <?php
        //    Query::tablePopulator("undergoes");
        ?>
    </div>
	<a href="DoctorPanel.html">To the Doctor Panel</a>
</div>

</body>
</html>