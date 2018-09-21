<?php
require "Query.php";
$adminLogin = "admin";
$doctorLogin = "heydoctor";
$email = $_POST['email'];
$password = $_POST['password'];
if($email == $adminLogin){
    header("Location:AdminPanel.html");
    exit();

}
Query::connectDatabase();
$query = "SELECT doctor.staffID
                FROM doctor, staff
                  WHERE staff.staffID = doctor.staffID AND staff.staff_name = '$email' AND doctor.staffID = '$password' ";
    $result = Query::$conn->query($query);
    if(mysqli_num_rows($result) != 0){
		$person = $result->fetch_assoc();
		setcookie("doctorID",$person["staffID"], time()+1000,"/");
        header("Location:DoctorPanel.html");
		exit();
	}else {
	echo "Bad log in credentials<br>";
        echo "<a href='OTLogin.html'>Log in Page</a>";
        exit();
}



?>