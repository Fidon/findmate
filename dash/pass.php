<?php
include "../php/db_config.php";
$pass = password_hash("12345",PASSWORD_BCRYPT);
$change = mysqli_query($config,"UPDATE `user` SET `password`='$pass' WHERE `userId`='1'");
if ($change) {
  echo "success";
} else {
  echo "failed";
}

?>
