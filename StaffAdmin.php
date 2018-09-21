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
            Query::getTable("staff");
        ?>
    </div>
    <div id="PopulateContainer">
        <!-- a form element starts here -->
        <?php
            Query::tablePopulator("staff");
        ?>
    </div>
	<a href="AdminPanel.html">To the Admin Panel</a>
</div>

</body>
</html>