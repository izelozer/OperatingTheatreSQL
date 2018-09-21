<?php
define("COOKIE_LEN",600);//this defines a constant for cookie length (in seconds)
class Query
{
    public static $conn;

    public static function connectDatabase(){
        if(!self::$conn){//check if you are already connected to database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "operatingtheatre";        
            // Create connection
            self::$conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if (self::$conn->connect_error) {
                echo "Can't connect to database";
                exit();
            }
        }

    }

    public static function loginCheck(){
        if(!isset($_COOKIE['id'])){//check here if there is a cookie with 'id' which indicates that client has already logged in
            //if not set then exit
            echo "You are not logged in. Please log in first<br>";
            echo "<a href='Login.html'>Log in page </a>";
            exit();
        }
        else {
            $id = $_COOKIE['id'];
            $query = "SELECT *
                        FROM persons
                          WHERE persons.id = $id";
            $result = self::$conn->query($query);
            if(mysqli_num_rows($result)==0){
                echo "You have created a cookie with an id which is not in our database. If you are trying to cheat do it right :)<br>";
                echo "<a href='Login.html'>Log in page </a>";
                exit();
            }
        }
    }
	
	
	public static function getTableForOneDoctorPatient($tableName){
        $docID = $_COOKIE['doctorID'];
		$query = "SELECT $tableName.protocolNO, $tableName.patient_name
                    FROM $tableName, attends
					WHERE $docID = attends.staffID AND $tableName.protocolNO = attends.protocolNO
					";
        $result = self::$conn->query($query);
        $fields = mysqli_fetch_fields($result);
        echo "<table>";
        echo "<tr>";
        foreach($fields as $field){
            echo "<th>$field->name</th>";
        }
	//	echo "<th>Delete Action</th>";
	//	echo "<th>Update Action</th>";
        echo "</tr>";
        while($row = $result->fetch_assoc()){
            echo "<tr>";
			$control = TRUE;
            foreach($fields as $field){
				if($control){
					$id = $row[$field->name];
					$fieldIdName = $field->name;
				}
				$control = FALSE;
                $data = $row[$field->name];
                echo "<td>$data</td>";
            }
		//	echo "<td><a href='DeleteHandle.php?id=$id&tableName=$tableName&fieldIdName=$fieldIdName'>DELETE</a></td>";
		//	echo "<td><a href='UpdateForm.php?id=$id&tableName=$tableName&fieldIdName=$fieldIdName'>UPDATE</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
	
	
	public static function getTableOnlyUpdate($tableName){
        $query = "SELECT *
                    FROM $tableName";
        $result = self::$conn->query($query);
        $fields = mysqli_fetch_fields($result);
        echo "<table>";
        echo "<tr>";
        foreach($fields as $field){
            echo "<th>$field->name</th>";
        }
		
		echo "<th>Update Action</th>";
        echo "</tr>";
        while($row = $result->fetch_assoc()){
            echo "<tr>";
			$control = TRUE;
            foreach($fields as $field){
				if($control){
					$id = $row[$field->name];
					$fieldIdName = $field->name;
				}
				$control = FALSE;
                $data = $row[$field->name];
                echo "<td>$data</td>";
            }
			echo "<td><a href='UpdateFormForDoctors.php?id=$id&tableName=$tableName&fieldIdName=$fieldIdName'>UPDATE</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
	
	
    public static function getTable($tableName){
        $query = "SELECT *
                    FROM $tableName";
        $result = self::$conn->query($query);
        $fields = mysqli_fetch_fields($result);
        echo "<table>";
        echo "<tr>";
        foreach($fields as $field){
            echo "<th>$field->name</th>";
        }
		echo "<th>Delete Action</th>";
		echo "<th>Update Action</th>";
        echo "</tr>";
        while($row = $result->fetch_assoc()){
            echo "<tr>";
			$control = TRUE;
            foreach($fields as $field){
				if($control){
					$id = $row[$field->name];
					$fieldIdName = $field->name;
				}
				$control = FALSE;
                $data = $row[$field->name];
                echo "<td>$data</td>";
            }
			echo "<td><a href='DeleteHandle.php?id=$id&tableName=$tableName&fieldIdName=$fieldIdName'>DELETE</a></td>";
			echo "<td><a href='UpdateForm.php?id=$id&tableName=$tableName&fieldIdName=$fieldIdName'>UPDATE</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
	
	
	public static function getTableStaff($tableName){
        $query = "SELECT staff.staffID, staff.staff_name
                    FROM $tableName, staff
					WHERE $tableName.staffID = staff.staffID ";
        $result = self::$conn->query($query);
        $fields = mysqli_fetch_fields($result);
        echo "<table>";
        echo "<tr>";
        foreach($fields as $field){
            echo "<th>$field->name</th>";
        }
		echo "<th>Delete Action</th>";
		echo "<th>Update Action</th>";
        echo "</tr>";
		
        while($row = $result->fetch_assoc()){
            echo "<tr>";
			$control = TRUE;
            foreach($fields as $field){
				if($control){
					$id = $row[$field->name];
					$fieldIdName = $field->name;
				}
				$control = FALSE;
                $data = $row[$field->name];
                echo "<td>$data</td>";
            }
			echo "<td><a href='DeleteHandleStaff.php?id=$id&tableName=$tableName&fieldIdName=$fieldIdName'>DELETE</a></td>";
			echo "<td><a href='UpdateFormStaff.php?id=$id&tableName=$tableName&fieldIdName=$fieldIdName'>UPDATE</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

	
    public static function tablePopulator($tableName){
        $query = "DESCRIBE $tableName";//to get the only the table information without getting all the rows.Run this query in phpmyadmin to understand whats going on.
        //for example run 'DESCRIBE persons'
        $result = self::$conn->query($query);
        echo "<form action='SubmitForm.php' method='post'>";//starting of the submit form
        echo "<input type='hidden' name='tableName' value=$tableName >";//hidden attributed elements is not shown
        while($row = $result->fetch_assoc()) {
            $fieldName = $row["Field"];
            if ($fieldName != "id") {
                echo "<a>$fieldName</a><br>";
                if($fieldName == "password"){
                    echo "<input type='password' name=$fieldName><br>";
                }
                else{
                    echo "<input type=\"text\" name=$fieldName><br>";
                }
            }
        }
        echo "<input type=\"submit\" value=\"Create\">";
        echo "</form>";
    }
	
	
	public static function tablePopulatorStaff($tableName){
        $query = "DESCRIBE staff";//to get the only the table information without getting all the rows.Run this query in phpmyadmin to understand whats going on.
        //for example run 'DESCRIBE persons'
        $result = self::$conn->query($query);
        echo "<form action='SubmitFormStaff.php' method='post'>";//starting of the submit form
        echo "<input type='hidden' name='tableName' value=$tableName >";//hidden attributed elements is not shown
        while($row = $result->fetch_assoc()) {
            $fieldName = $row["Field"];
            if ($fieldName != "id") {
                echo "<a>$fieldName</a><br>";
                if($fieldName == "password"){
                    echo "<input type='password' name=$fieldName><br>";
                }
                else{
                    echo "<input type=\"text\" name=$fieldName><br>";
                }
            }
        }
        echo "<input type=\"submit\" value=\"Create\">";
        echo "</form>";
    }
	
	
	public static function tablePopulatorUpdate($tableName,$id,$fieldIdName){
		$query = "SELECT *
                    FROM $tableName WHERE $fieldIdName=$id";
        $result = self::$conn->query($query);
        $fields = mysqli_fetch_fields($result);
        $result = self::$conn->query($query);
        echo "<form action='UpdateHandle.php' method='post'>";//starting of the submit form
        echo "<input type='hidden' name='tableName' value=$tableName >";
		echo "<input type='hidden' name='id' value=$id >";//hidden attributed elements is not shown
		echo "<input type='hidden' name='fieldIdName' value=$fieldIdName >";
        while($row = $result->fetch_assoc()) {
			foreach($fields as $field){
				$fieldName = $field->name;
				if ($fieldName != "id") {
					echo "<a>$fieldName</a><br>";
					if($fieldName == "password"){
						echo "<input type='password' name=$fieldName><br>";
					}
					else{
						$someValue = $row[$field->name];
						echo "<input type=\"text\" name=$fieldName value=$someValue><br>";
					}
				}
			} 
        }
        echo "<input type=\"submit\" value=\"Update\">";
        echo "</form>";
    }
	
	
	public static function tablePopulatorUpdateDate($tableName,$id,$fieldIdName){
		$query = "SELECT *
                    FROM $tableName WHERE $fieldIdName=$id";
        $result = self::$conn->query($query);
        $fields = mysqli_fetch_fields($result);
        $result = self::$conn->query($query);
        echo "<form action='UpdateHandle.php' method='post'>";//starting of the submit form
        echo "<input type='hidden' name='tableName' value=$tableName >";
		echo "<input type='hidden' name='id' value=$id >";//hidden attributed elements is not shown
		echo "<input type='hidden' name='fieldIdName' value=$fieldIdName >";
        while($row = $result->fetch_assoc()) {
			foreach($fields as $field){
				    $fieldName = $field->name;
				if ($fieldName != "id") {
					
					if($fieldName == "password"){
						echo "<input type='password' name=$fieldName><br>";
					}
					else{
						if ($fieldName == "op_date"){
							echo "<a>$fieldName</a><br>";
							$someValue = $row[$field->name];
						echo "<input type=\"text\" name=$fieldName value=$someValue><br>";
						}
						
					}
				}	
			}
        }
        echo "<input type=\"submit\" value=\"Update\">";
        echo "</form>";
    }

	
    public static function addRow($tableName,$columns,$dataList){
        $query = "INSERT INTO `$tableName`";
        $query = $query."(";
        foreach($columns as $column){
            $query = $query."$column".",";
        }
        $query = substr($query,0,-1);
        $query = $query.")";
        $query = $query."VALUES";
        $query = $query."(";
        foreach($dataList as $data){
            $query = $query."'$data'".",";
        }
        $query = substr($query,0,-1);
        $query = $query.")";
        $result = self::$conn->query($query);
        return $result;
    }
	
	    public static function deleteRow($tableName,$id,$fieldIdName){
        $query = "DELETE FROM $tableName WHERE $fieldIdName = $id";
       
        $result = self::$conn->query($query);
        return $result;
    }

	
	public static function deleteRowStaff($tableName,$id,$fieldIdName){
        $query = "DELETE FROM staff WHERE $fieldIdName = $id";
       
        $result = self::$conn->query($query);
        return $result;
    }
	
	
	 public static function updateRow($tableName,$id,$dataList,$columns,$fieldIdName){
        $query = "UPDATE $tableName SET ";
		$counter = 0;
		$fieldName = "";
        foreach($columns as $column){
			
            $query = $query."$column"." = ";
			$query = $query."'$dataList[$counter]'".", ";
			
			//echo $column."----";
			//echo $dataList[$counter];
			//echo"<br>";
			

		$counter= $counter + 1 ;
		}
        $query = substr($query,0,-1);
		$query = substr($query,0,-1);
        
        $query = $query." WHERE $fieldIdName = $id";
		
		//echo $query;
		
        $result = self::$conn->query($query);
        return $result;
    }
	
   
}