<?php

session_start();
$response = array(
  'status' => 0,
  'sms' => 'Unknown error, please try again later.'
);

if ((isset($_POST['username'])) && (isset($_POST['password']))) {
  include "../db_config.php";
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  $select = mysqli_query($config,"SELECT * FROM `user` WHERE (`mobile`='$username') OR (`email`='$username')");
  if (mysqli_num_rows($select) == 1) {
    $get = mysqli_fetch_assoc($select);
    if (password_verify($password,$get['password'])) {
      $_SESSION['userType'] = $get['userType'];
      $_SESSION['userId'] = $get['userId'];
      $_SESSION['names'] = ($get['lname']==NULL) ? $get['fname'] : $get['fname']." ".$get['lname'];

      $response['status'] = 1;
      $response['userType'] = $get['userType'];
      $response['sms'] = "Loged in..";
    } else {
      $response['status'] = 0;
      $response['sms'] = "Incorect username or password";
    }
  } else {
    $response['status'] = 0;
    $response['sms'] = "Incorect username or password";
  }
  echo json_encode($response);
}
?>
