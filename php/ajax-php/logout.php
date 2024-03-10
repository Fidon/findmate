<?php
session_start();
if ((isset($_REQUEST['action'])) && ($_REQUEST['action']=='logout')) {
  if (session_destroy()) { echo "1"; } else {echo "0"; }
} else {
  echo "<script> window.location.href='../dash' </script>";
}

?>
