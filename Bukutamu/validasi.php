<?php
include 'config.php';
session_start();

$username = $_POST['tusername'];
$password = md5($_POST['tpassword']);

// set up the query
$query = "SELECT * FROM pengguna WHERE username='$username' AND password='$password'";

// run the query and get the number of affected rows
$result = mysqli_query($conn,$query) or die ('error making query');
$affected_rows = mysqli_num_rows($result);
$data = mysqli_fetch_assoc($result);

// if there's exactly one result, the user is validated. Otherwise, he's invalid
if($affected_rows == 1) {
  $_SESSION['sadmin_username']=$username;
  header( 'location: admin.php');


} else {
  header( 'location: login.php');
}
?>
