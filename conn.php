<?php

$conn = mysqli_connect("localhost","root","","project");
mysqli_set_charset($conn, "utf8");
if($conn)
{
	// echo "connection success";	   
}
else
{
	echo "connection not success";	      
}
?>