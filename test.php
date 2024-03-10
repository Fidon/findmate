<?php

include "php/db_config.php";
$abc = password_hash('12345/',PASSWORD_BCRYPT);
$x = mysqli_query($config,"UPDATE `user` SET `password`='$abc' WHERE `userId`='3'");
if ($x) {
  echo "success!";
} else {
  echo "Failed";
}

?>
