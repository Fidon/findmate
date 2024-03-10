<?php
$response = array(
  'status' => 0,
  'sms' => 'Unknown error, please try again later.',
  'input' => ''
);

//Register new personal account
if (isset($_POST['accType']) && ($_POST['accType']=='1')) {
  $userType = $_POST['accType'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $gender = $_POST['gender'];
  $location = htmlentities($_POST['location'],ENT_QUOTES);
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $bio = htmlentities($_POST['bio'],ENT_QUOTES);
  $pass1 = $_POST['pass1'];
  $pass2 = $_POST['pass2'];
  $upper = preg_match('/[A-Z]/',$pass1);
  $lower = preg_match('/[a-z]/',$pass1);
  $number = preg_match('/\d/',$pass1);
  $specialChars = preg_match('/[^a-zA-Z\d]/',$pass1);
  $password = password_hash($_POST['pass1'],PASSWORD_BCRYPT);
  include "../db_config.php";


  if ((strlen($pass1) >= 6) && (strlen($pass1) <= 15)) {
    if ($pass1 == $pass2) {
      if ($upper && $lower && $number && $specialChars) {
        if ((ctype_alpha($fname)) && (strlen($fname)>=3) && (strlen($fname)<=15)) {
          if ((ctype_alpha($lname)) && (strlen($lname)>=3) && (strlen($lname)<=15)) {
            if ((strlen($location)>=5) && (strlen($location)<=32)) {
              $checkEmail = mysqli_query($config,"SELECT `email` FROM `user` WHERE `email`='$email'");
              if (mysqli_num_rows($checkEmail)==0) {
                if ((strlen($phone) == 10) && (substr($phone,0,1) == '0') && (ctype_digit($phone))) {
                  $checkPhone = mysqli_query($config,"SELECT `mobile` FROM `user` WHERE `mobile`='$phone'");
                  if (mysqli_num_rows($checkPhone)==0) {
                    if (strlen(trim($_POST['bio'])) >= 10) {
                      if (empty($_FILES['picture']['name'])) {
                        $pic_link = ($gender=='M') ? "assets/imgs/profile_pictures/default_m.png" : "assets/imgs/profile_pictures/default_f.png";
                        $insert = "INSERT INTO `user`(`userType`,`fname`,`lname`,`gender`,`address`,`mobile`,`email`,`bio`,`picture`,`password`)
                        VALUES('$userType','$fname','$lname','$gender','$location','$phone','$email','$bio','$pic_link','$password')";
                        if (mysqli_query($config,$insert)) {
                          $response['status'] = 1;
                          $response['sms'] = "Registration completed successfully! You'll be redirected shortly";
                          $response['input'] = '';
                        } else {
                          $response['status'] = 0;
                          $response['sms'] = "Failed to complete registration!";
                          $response['input'] = '';
                        }
                      } else {
                        $imgInfo = getimagesize($_FILES["picture"]["tmp_name"]);
                        $width = $imgInfo[0];
                        $height = $imgInfo[1];
                        $fileName = basename($_FILES["picture"]["name"]);
                        $targetFilePath = "assets/imgs/profile_pictures/".$fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                        $allowTypes = array('jpg', 'png', 'jpeg', 'PNG', 'JPG', 'JPEG');
                        if(in_array($fileType, $allowTypes)) {
                          if ($_FILES["picture"]["size"] <= 2000000) {
                            $insert = "INSERT INTO `user`(`userType`,`fname`,`lname`,`gender`,`address`,`mobile`,`email`,`bio`,`password`)
                            VALUES('$userType','$fname','$lname','$gender','$location','$phone','$email','$bio','$password')";
                            if (mysqli_query($config,$insert)) {
                              $id = mysqli_insert_id($config);
                              $ext = explode(".", $_FILES['picture']['name']);
                              $imgExt = end($ext);
                              $folder = "../../assets/imgs/profile_pictures/".$id.".".$imgExt;
                              $path = "assets/imgs/profile_pictures/".$id.".".$imgExt;
                              if (move_uploaded_file($_FILES['picture']['tmp_name'], $folder)) {
                                mysqli_query($config,"UPDATE `user` SET `picture`='$path' WHERE `userId`='$id'");
                                $response['status'] = 1;
                                $response['sms'] = "Registration completed successfully! You'll be redirected shortly";
                                $response['input'] = '';
                              } else {
                                mysqli_query($config,"DELETE FROM `user` WHERE `userId`='$id'");
                                $response['status'] = 0;
                                $response['sms'] = "Failed to complete registration!";
                                $response['input'] = '';
                              }
                            } else {
                              $response['status'] = 0;
                              $response['sms'] = "Failed to complete registration!";
                              $response['input'] = '';
                            }
                          } else {
                            $response['status'] = 2;
                            $response['sms'] = "Picture size should not exceed 2MB";
                            $response['input'] = 'picture';
                          }
                        } else {
                          $response['status'] = 2;
                          $response['sms'] = "Please select valid picture format to upload";
                          $response['input'] = 'picture';
                        }
                      }
                    } else {
                      $response['status'] = 2;
                      $response['sms'] = "Please enter at least one sentence of your bio..";
                      $response['input'] = 'bio';
                    }
                  } else {
                    $response['status'] = 2;
                    $response['sms'] = "This phone number is already used;";
                    $response['input'] = 'phone';
                  }
                } else {
                  $response['status'] = 2;
                  $response['sms'] = "Phone number should start with 0 & have 10 digits only";
                  $response['input'] = 'phone';
                }
              } else {
                $response['status'] = 2;
                $response['sms'] = "This email address is already used";
                $response['input'] = 'email';
              }
            } else {
              $response['status'] = 2;
              $response['sms'] = "Location address should have atleast 5 characters";
              $response['input'] = 'location';
            }
          } else {
            $response['status'] = 2;
            $response['sms'] = "Last name should have only alphabets 3 to 15 long";
            $response['input'] = 'lname';
          }
        } else {
          $response['status'] = 2;
          $response['sms'] = "First name should have only alphabets 3 to 15 long";
          $response['input'] = 'fname';
        }
      } else {
        $response['status'] = 2;
        $response['sms'] = "Password should have at least one upper & lower case, number & special character.";
        $response['input'] = 'pass1';
      }
    } else {
      $response['status'] = 2;
      $response['sms'] = "Password does't match!";
      $response['input'] = 'pass1';
    }
  } else {
    $response['status'] = 2;
    $response['sms'] = "Password should be 6 to 15 characters long";
    $response['input'] = 'pass1';
  }
  echo json_encode($response);
}


//Register new institutional account
if (isset($_POST['accType']) && ($_POST['accType']=='2')) {
  $userType = $_POST['accType'];
  $names = htmlentities(trim($_POST['fname']),ENT_QUOTES);
  $location = htmlentities(trim($_POST['location']),ENT_QUOTES);
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $bio = htmlentities(trim($_POST['bio']),ENT_QUOTES);
  $pass1 = $_POST['pass1'];
  $pass2 = $_POST['pass2'];
  $upper = preg_match('/[A-Z]/',$pass1);
  $lower = preg_match('/[a-z]/',$pass1);
  $number = preg_match('/\d/',$pass1);
  $specialChars = preg_match('/[^a-zA-Z\d]/',$pass1);
  $password = password_hash($_POST['pass1'],PASSWORD_BCRYPT);
  include "../db_config.php";

  if ((strlen($pass1) >= 6) && (strlen($pass1) <= 15)) {
    if ($pass1 == $pass2) {
      if ($upper && $lower && $number && $specialChars) {
        if ((strlen($names)>=5) && (strlen($names)<=50)) {
          if ((strlen($location)>=5) && (strlen($location)<=32)) {
            $checkEmail = mysqli_query($config,"SELECT `email` FROM `user` WHERE `email`='$email'");
            if (mysqli_num_rows($checkEmail)==0) {
              if ((strlen($phone) == 10) && (substr($phone,0,1) == '0') && (ctype_digit($phone))) {
                $checkPhone = mysqli_query($config,"SELECT `mobile` FROM `user` WHERE `mobile`='$phone'");
                if (mysqli_num_rows($checkPhone)==0) {
                  if (strlen(trim($_POST['bio'])) >= 10) {
                    if (empty($_FILES['picture']['name'])) {
                      $pic_link = "assets/imgs/profile_pictures/company_default.png";
                      $insert = "INSERT INTO `user`(`userType`,`fname`,`address`,`mobile`,`email`,`bio`,`picture`,`password`)
                      VALUES('$userType','$names','$location','$phone','$email','$bio','$pic_link','$password')";
                      if (mysqli_query($config,$insert)) {
                        $response['status'] = 1;
                        $response['sms'] = "Registration completed successfully!";
                        $response['input'] = '';
                      } else {
                        $response['status'] = 0;
                        $response['sms'] = "Failed to complete registration!";
                        $response['input'] = '';
                      }
                    } else {
                      $imgInfo = getimagesize($_FILES["picture"]["tmp_name"]);
                      $width = $imgInfo[0];
                      $height = $imgInfo[1];
                      $fileName = basename($_FILES["picture"]["name"]);
                      $targetFilePath = "assets/imgs/profile_pictures/".$fileName;
                      $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                      $allowTypes = array('jpg', 'png', 'jpeg', 'PNG', 'JPG', 'JPEG');
                      if(in_array($fileType, $allowTypes)) {
                        if ($_FILES["picture"]["size"] <= 2000000) {
                          $insert = "INSERT INTO `user`(`userType`,`fname`,`address`,`mobile`,`email`,`bio`,`password`)
                          VALUES('$userType','$names','$location','$phone','$email','$bio','$password')";
                          if (mysqli_query($config,$insert)) {
                            $id = mysqli_insert_id($config);
                            $ext = explode(".", $_FILES['picture']['name']);
                            $imgExt = end($ext);
                            $folder = "../../assets/imgs/profile_pictures/".$id.".".$imgExt;
                            $path = "assets/imgs/profile_pictures/".$id.".".$imgExt;
                            if (move_uploaded_file($_FILES['picture']['tmp_name'], $folder)) {
                              mysqli_query($config,"UPDATE `user` SET `picture`='$path' WHERE `userId`='$id'");
                              $response['status'] = 1;
                              $response['sms'] = "Registration completed successfully! You'll bee redirected";
                              $response['input'] = '';
                            } else {
                              mysqli_query($config,"DELETE FROM `user` WHERE `userId`='$id'");
                              $response['status'] = 0;
                              $response['sms'] = "Failed to complete registration! You'll be redirected shortly";
                              $response['input'] = '';
                            }
                          } else {
                            $response['status'] = 0;
                            $response['sms'] = "Failed to complete registration!";
                            $response['input'] = '';
                          }
                        } else {
                          $response['status'] = 2;
                          $response['sms'] = "Picture size exceeds 2MB";
                          $response['input'] = 'picture';
                        }
                      } else {
                        $response['status'] = 2;
                        $response['sms'] = "Please select valid picture format to upload";
                        $response['input'] = 'picture';
                      }
                    }
                  } else {
                    $response['status'] = 2;
                    $response['sms'] = "Please enter at least one sentence of your bio..";
                    $response['input'] = 'bio';
                  }
                } else {
                  $response['status'] = 2;
                  $response['sms'] = "This phone number is already used;";
                  $response['input'] = 'phone';
                }
              } else {
                $response['status'] = 2;
                $response['sms'] = "Phone number should start with 0 & have 10 digits only";
                $response['input'] = 'phone';
              }
            } else {
              $response['status'] = 2;
              $response['sms'] = "This email address is already used";
              $response['input'] = 'email';
            }
          } else {
            $response['status'] = 2;
            $response['sms'] = "Location address should have atleast 5 characters";
            $response['input'] = 'location';
          }
        } else {
          $response['status'] = 2;
          $response['sms'] = "Name should be 5 to 50 characters long";
          $response['input'] = 'fname';
        }
      } else {
        $response['status'] = 2;
        $response['sms'] = "Password should have at least one upper & lower case, number & special character.";
        $response['input'] = 'pass1';
      }
    } else {
      $response['status'] = 2;
      $response['sms'] = "Password does't match!";
      $response['input'] = 'pass1';
    }
  } else {
    $response['status'] = 2;
    $response['sms'] = "Password should be 6 to 15 characters long";
    $response['input'] = 'pass1';
  }
  echo json_encode($response);
}


?>
